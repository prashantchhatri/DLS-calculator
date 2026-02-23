<?php

namespace App\Services;

class NrrService
{
    /**
     * Convert cricket overs format (e.g. 14.2) into balls.
     */
    public function oversToBalls(string $overs): int
    {
        $overs = trim($overs);

        if ($overs === '' || ! preg_match('/^\d+(\.\d+)?$/', $overs)) {
            return 0;
        }

        [$fullOvers, $ballsPart] = array_pad(explode('.', $overs, 2), 2, '0');
        $fullOvers = max(0, (int) $fullOvers);
        $balls = (int) substr($ballsPart, 0, 1);
        $balls = min(5, max(0, $balls));

        return ($fullOvers * 6) + $balls;
    }

    public function ballsToOvers(int $balls): string
    {
        $balls = max(0, $balls);

        return sprintf('%d.%d', intdiv($balls, 6), $balls % 6);
    }

    public function ballsToOversFloat(int $balls): float
    {
        return (float) $this->ballsToOvers($balls);
    }

    /**
     * For NRR denominator:
     * - if all out, count full quota overs.
     * - otherwise count actual overs played.
     */
    public function effectiveOversForNrr(string $actualOvers, string $quotaOvers, bool $allOut): float
    {
        $actualBalls = $this->oversToBalls($actualOvers);
        $quotaBalls = $this->oversToBalls($quotaOvers);

        if ($quotaBalls <= 0) {
            return 0.0;
        }

        $usedBalls = $allOut ? $quotaBalls : min($actualBalls, $quotaBalls);

        return $usedBalls / 6;
    }

    public function matchOversForSide(
        string $baseOvers,
        bool $rainAffected,
        ?string $revisedOvers
    ): string {
        if (! $rainAffected || $revisedOvers === null || trim($revisedOvers) === '') {
            return $baseOvers;
        }

        return $revisedOvers;
    }

    /**
     * Core NRR computation for one match.
     *
     * @param array{
     *   team_runs:int,
     *   team_overs:string,
     *   team_all_out:bool,
     *   opp_runs:int,
     *   opp_overs:string,
     *   opp_all_out:bool,
     *   base_overs:string,
     *   rain_affected:bool,
     *   revised_team_overs:?string,
     *   revised_opp_overs:?string,
     *   dls_applied:bool,
     *   revised_target:?int,
     *   par_score:?int,
     *   result_status:string
     * } $payload
     */
    public function calculateMatchNrr(array $payload): array
    {
        $status = $payload['result_status'];

        if (in_array($status, ['abandoned', 'no_result'], true)) {
            return [
                'status' => $status,
                'summary' => 'No NRR impact for abandoned / no-result match.',
                'team_run_rate' => 0.0,
                'opp_run_rate' => 0.0,
                'team_nrr' => 0.0,
                'opp_nrr' => 0.0,
                'breakdown' => [
                    'reason' => 'Tournament NRR is unchanged because innings were not completed for a result.',
                ],
            ];
        }

        $teamQuota = $this->matchOversForSide(
            $payload['base_overs'],
            $payload['rain_affected'],
            $payload['revised_team_overs']
        );
        $oppQuota = $this->matchOversForSide(
            $payload['base_overs'],
            $payload['rain_affected'],
            $payload['revised_opp_overs']
        );

        $teamOversUsed = $this->effectiveOversForNrr(
            $payload['team_overs'],
            $teamQuota,
            $payload['team_all_out']
        );
        $oppOversUsed = $this->effectiveOversForNrr(
            $payload['opp_overs'],
            $oppQuota,
            $payload['opp_all_out']
        );

        if ($teamOversUsed <= 0 || $oppOversUsed <= 0) {
            return [
                'status' => 'invalid',
                'summary' => 'Cannot calculate NRR. Overs faced/bowled must be greater than 0.',
                'team_run_rate' => 0.0,
                'opp_run_rate' => 0.0,
                'team_nrr' => 0.0,
                'opp_nrr' => 0.0,
                'breakdown' => [],
            ];
        }

        $teamRunRate = round($payload['team_runs'] / $teamOversUsed, 4);
        $oppRunRate = round($payload['opp_runs'] / $oppOversUsed, 4);
        $teamNrr = round($teamRunRate - $oppRunRate, 4);
        $oppNrr = round(-$teamNrr, 4);

        $summary = match ($status) {
            'tie' => 'Match tied. NRR still computed from scored and conceded rates.',
            default => $teamNrr >= 0
                ? 'Positive NRR performance in this match.'
                : 'Negative NRR performance in this match.',
        };

        if ($payload['rain_affected']) {
            $summary .= ' Rain-reduced overs have been used for denominator calculations.';
        }

        if ($payload['dls_applied']) {
            $summary .= ' DLS context recorded for match summary.';
        }

        return [
            'status' => 'ok',
            'summary' => $summary,
            'team_run_rate' => $teamRunRate,
            'opp_run_rate' => $oppRunRate,
            'team_nrr' => $teamNrr,
            'opp_nrr' => $oppNrr,
            'breakdown' => [
                'team_runs' => $payload['team_runs'],
                'team_overs_for_nrr' => round($teamOversUsed, 2),
                'opp_runs' => $payload['opp_runs'],
                'opp_overs_for_nrr' => round($oppOversUsed, 2),
                'team_quota_overs' => $teamQuota,
                'opp_quota_overs' => $oppQuota,
                'dls_applied' => $payload['dls_applied'],
                'revised_target' => $payload['revised_target'],
                'par_score' => $payload['par_score'],
            ],
        ];
    }

    /**
     * Generate scenario ranges for target NRR in the next match.
     */
    public function buildPredictorScenarios(array $payload): array
    {
        $played = max(0, (int) $payload['matches_played']);
        $currentRunsFor = max(0.0, (float) $payload['runs_scored_total']);
        $currentOversFor = max(0.1, (float) $payload['overs_faced_total']);
        $currentRunsAgainst = max(0.0, (float) $payload['runs_conceded_total']);
        $currentOversAgainst = max(0.1, (float) $payload['overs_bowled_total']);
        $targetNrr = (float) $payload['target_nrr'];
        $currentNrrInput = (float) ($payload['current_nrr_input'] ?? 0.0);
        $expectedOvers = max(0.1, (float) $payload['expected_overs']);
        $inningsMode = $payload['innings_mode'] ?? 'batting_first';

        // Baseline next-match score expectation from current scoring pace.
        $currentScoringRate = $currentRunsFor / $currentOversFor;
        $baselineFirstInningsScore = max(40, (int) round($currentScoringRate * $expectedOvers));
        $predictedTeamScore = max(30, (int) ($payload['predicted_team_score'] ?? $baselineFirstInningsScore));
        $predictedOppScore = max(30, (int) ($payload['predicted_opp_score'] ?? $baselineFirstInningsScore));

        $levels = [
            ['label' => 'Minimum', 'factor' => 0.92],
            ['label' => 'Moderate', 'factor' => 1.00],
            ['label' => 'Safe', 'factor' => 1.10],
        ];

        $battingFirst = [];
        $bowlingFirst = [];
        $primaryBatting = null;
        $primaryBowling = null;

        foreach ($levels as $level) {
            $defendScore = max(30, (int) round($predictedTeamScore * $level['factor']));

            // A: scored, B: overs faced, C: conceded, D: overs bowled
            // Target: ((A+x)/(B+eo)) - ((C+y)/(D+eo)) >= targetNrr
            $maxOppScoreRaw = ((($currentRunsFor + $defendScore) / ($currentOversFor + $expectedOvers)) - $targetNrr)
                * ($currentOversAgainst + $expectedOvers) - $currentRunsAgainst;
            $maxOppScore = max(0, (int) floor($maxOppScoreRaw));
            $runMargin = max(1, $defendScore - $maxOppScore);

            $assumedConcedeRate = max(3.5, $defendScore / $expectedOvers);
            $bowlOutOvers = max(0.1, min($expectedOvers, $maxOppScore / $assumedConcedeRate));
            $bowlOutBallsLeft = max(0, (int) round(($expectedOvers - $bowlOutOvers) * 6));

            $battingFirst[] = [
                'level' => $level['label'],
                'defend_score' => $defendScore,
                'max_opp_score' => $maxOppScore,
                'min_win_margin_runs' => $runMargin,
                'bowl_out_by_over' => $this->ballsToOvers((int) round($bowlOutOvers * 6)),
                'finish_with_balls_left' => $bowlOutBallsLeft,
            ];
            if ($level['label'] === 'Moderate') {
                $primaryBatting = [
                    'opp_all_out_runs' => $maxOppScore,
                    'opp_all_out_by_over' => $this->ballsToOvers((int) round($bowlOutOvers * 6)),
                ];
            }

            $oppTarget = max(1, $predictedOppScore);
            $chaseRuns = $oppTarget + 1;

            $denominator = $targetNrr + (($currentRunsAgainst + $oppTarget) / ($currentOversAgainst + $expectedOvers));
            $maxChaseOvers = $denominator > 0
                ? (($currentRunsFor + $chaseRuns) / $denominator) - $currentOversFor
                : $expectedOvers;
            $maxChaseOvers = max(0.1, min($expectedOvers, $maxChaseOvers));

            $oversSaved = max(0, $expectedOvers - $maxChaseOvers);
            $wicketsRemaining = min(10, max(1, (int) round(($oversSaved / max(0.1, $expectedOvers)) * 8) + 2));
            $ballsBefore = max(0, (int) round(($expectedOvers - $maxChaseOvers) * 6));

            $bowlingFirst[] = [
                'level' => $level['label'],
                'opp_target' => $oppTarget,
                'chase_by_over' => $this->ballsToOvers((int) round($maxChaseOvers * 6)),
                'approx_wickets_remaining' => $wicketsRemaining,
                'finish_before_balls' => $ballsBefore,
            ];
            if ($level['label'] === 'Moderate') {
                $primaryBowling = [
                    'chase_target' => $predictedOppScore + 1,
                    'chase_by_over' => $this->ballsToOvers((int) round($maxChaseOvers * 6)),
                    'wickets_remaining' => $wicketsRemaining,
                ];
            }
        }

        return [
            'baseline_score_estimate' => $baselineFirstInningsScore,
            'played_matches' => $played,
            'current_nrr_input' => round($currentNrrInput, 4),
            'current_nrr_calculated' => round(($currentRunsFor / $currentOversFor) - ($currentRunsAgainst / $currentOversAgainst), 4),
            'target_nrr' => round($targetNrr, 4),
            'innings_mode' => $inningsMode,
            'primary_batting' => $primaryBatting,
            'primary_bowling' => $primaryBowling,
            'batting_first' => $inningsMode === 'batting_first' ? $battingFirst : [],
            'bowling_first' => $inningsMode === 'bowling_first' ? $bowlingFirst : [],
        ];
    }
}
