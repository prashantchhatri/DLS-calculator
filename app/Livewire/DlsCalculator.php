<?php

namespace App\Livewire;

use Livewire\Component;

class DlsCalculator extends Component
{
    private const WICKET_RESOURCE_FACTORS = [
        1.00,
        0.95,
        0.90,
        0.84,
        0.77,
        0.69,
        0.60,
        0.50,
        0.39,
        0.27,
        0.00,
    ];

    public string $interruptionStage = 'during_chase';

    public string $originalOvers = '20.0';

    public string $revisedOvers = '15.0';

    public int $firstInningsScore = 170;

    public int $firstInningsWickets = 6;

    public string $firstInningsOvers = '20.0';

    public int $secondInningsScore = 92;

    public int $secondInningsWickets = 3;

    public string $rainHappenedOvers = '10.0';

    public string $specificProjectionOver = '14.2';

    public string $matchStoppedNow = 'no';

    public ?string $selectedInfoOver = null;

    public function mount(): void
    {
        $this->ensureDefaults();
    }

    public function hydrate(): void
    {
        $this->ensureDefaults();
    }

    public function resetCalculator(): void
    {
        $this->interruptionStage = 'during_chase';
        $this->originalOvers = '20.0';
        $this->revisedOvers = '15.0';
        $this->firstInningsOvers = '20.0';
        $this->firstInningsScore = 170;
        $this->firstInningsWickets = 6;
        $this->secondInningsScore = 92;
        $this->secondInningsWickets = 3;
        $this->rainHappenedOvers = '10.0';
        $this->specificProjectionOver = '14.2';
        $this->matchStoppedNow = 'no';
        $this->selectedInfoOver = null;
    }

    public function calculate(): void
    {
        $this->ensureDefaults();

        if ($this->matchStoppedNow === 'yes') {
            $this->specificProjectionOver = $this->currentChaseOvers();
            $this->revisedOvers = $this->currentChaseOvers();
            return;
        }

        $this->revisedOvers = $this->projectionOverNormalized();
    }

    public function updatedMatchStoppedNow(string $value): void
    {
        $this->matchStoppedNow = $value === 'yes' ? 'yes' : 'no';

        if ($this->matchStoppedNow === 'yes') {
            $this->specificProjectionOver = $this->currentChaseOvers();
        }

        $this->selectedInfoOver = null;
    }

    public function effectiveProjectionOver(): string
    {
        if ($this->matchStoppedNow === 'yes') {
            return $this->ballsToOversString(
                min($this->originalTotalBalls(), max(0, $this->oversToBalls($this->currentChaseOvers())))
            );
        }

        return $this->projectionOverNormalized();
    }

    public function projectionOverNormalized(): string
    {
        $balls = min($this->originalTotalBalls(), max(0, $this->oversToBalls($this->specificProjectionOver)));

        return $this->ballsToOversString($balls);
    }

    public function projectionParScore(): int
    {
        return $this->dlsParScoreAt($this->effectiveProjectionOver());
    }

    public function projectionRunsNeeded(): int
    {
        return max(0, ($this->projectionParScore() + 1) - $this->secondInningsScore);
    }

    public function projectionMatchesRainOver(): bool
    {
        return $this->oversToBalls($this->effectiveProjectionOver()) === $this->oversToBalls($this->currentChaseOvers());
    }

    public function rainStopOverLabel(): string
    {
        return $this->ballsToOversString(
            min($this->originalTotalBalls(), max(0, $this->oversToBalls($this->currentChaseOvers())))
        );
    }

    public function stopOverParScore(): int
    {
        return $this->dlsParScoreAt($this->currentChaseOvers());
    }

    public function runsNeededAtStopOver(): int
    {
        return max(0, ($this->stopOverParScore() + 1) - $this->secondInningsScore);
    }

    public function stoppedMatchResult(): ?array
    {
        if ($this->matchStoppedNow !== 'yes') {
            return null;
        }

        $par = $this->dlsParScoreAt($this->currentChaseOvers());
        $score = $this->secondInningsScore;
        $margin = abs($score - $par);

        if ($score > $par) {
            return [
                'summary' => 'Team 2 wins by '.$margin.' runs (DLS, simplified)',
                'par' => $par,
                'score' => $score,
            ];
        }

        if ($score < $par) {
            return [
                'summary' => 'Team 1 wins by '.$margin.' runs (DLS, simplified)',
                'par' => $par,
                'score' => $score,
            ];
        }

        return [
            'summary' => 'Scores are level on DLS par (Match tied on simplified model)',
            'par' => $par,
            'score' => $score,
        ];
    }

    public function dlsTarget(): int
    {
        $team1ResourceUsed = $this->team1ResourceUsed();

        if ($team1ResourceUsed <= 0) {
            return max(1, $this->firstInningsScore + 1);
        }

        $team2StartResource = $this->team2StartResource();
        $ratio = $team2StartResource / $team1ResourceUsed;

        return (int) ceil(($this->firstInningsScore * $ratio) + 1);
    }

    public function dlsParScoreAt(string $oversPoint): int
    {
        $team1ResourceUsed = $this->team1ResourceUsed();

        if ($team1ResourceUsed <= 0) {
            return 0;
        }

        $usedByPoint = $this->team2UsedResourceAt($oversPoint, $this->secondInningsWickets);
        $ratio = min(1, max(0, $usedByPoint / $team1ResourceUsed));

        return (int) floor($this->firstInningsScore * $ratio);
    }

    public function runsNeededNow(): int
    {
        if ($this->matchStoppedNow === 'yes') {
            return $this->runsNeededAtStopOver();
        }

        return max(0, $this->dlsTarget() - $this->secondInningsScore);
    }

    public function oversRemainingNow(): float
    {
        $remainingBalls = max(0, $this->revisedTotalBalls() - $this->currentChaseBalls());

        return $this->ballsToOversFloat($remainingBalls);
    }

    public function requiredRunRateNow(): float
    {
        if ($this->matchStoppedNow === 'yes') {
            return 0.0;
        }

        $remainingBalls = max(0, $this->revisedTotalBalls() - $this->currentChaseBalls());

        if ($remainingBalls === 0) {
            return 0.0;
        }

        return round($this->runsNeededNow() / ($remainingBalls / 6), 2);
    }

    public function resourceInUseNow(): float
    {
        return round($this->team2UsedResourceAt($this->currentChaseOvers(), $this->secondInningsWickets), 2);
    }

    public function projectionRows(): array
    {
        $rows = [];

        foreach ($this->projectionOversList() as $balls) {
            $overLabel = $this->ballsToOversString($balls);
            $par = $this->dlsParScoreAt($overLabel);
            $runsToWin = max(0, $this->dlsTarget() - $par);

            $remainingBalls = max(0, $this->revisedTotalBalls() - $balls);
            $rr = $remainingBalls > 0 ? round($runsToWin / ($remainingBalls / 6), 2) : 0.0;

            $rows[] = [
                'over' => $overLabel,
                'par_score' => $par,
                'runs_to_win' => $runsToWin,
                'required_rr' => $rr,
            ];
        }

        return $rows;
    }

    public function showOverInfo(string $over): void
    {
        $this->selectedInfoOver = $over;
    }

    public function closeOverInfo(): void
    {
        $this->selectedInfoOver = null;
    }

    public function selectedOverBreakdown(): ?array
    {
        if ($this->selectedInfoOver === null) {
            return null;
        }

        return $this->breakdownForOver($this->selectedInfoOver);
    }

    protected function breakdownForOver(string $over): array
    {
        $overBalls = min($this->revisedTotalBalls(), max(0, $this->oversToBalls($over)));
        $overLabel = $this->ballsToOversString($overBalls);

        $team1ResourceUsed = $this->team1ResourceUsed();
        $team2StartResource = $this->team2StartResource();
        $team2UsedAtOver = $this->team2UsedResourceAt($overLabel, $this->secondInningsWickets);
        $resourceRatio = $team1ResourceUsed > 0 ? $team2UsedAtOver / $team1ResourceUsed : 0.0;

        $parScore = $this->dlsParScoreAt($overLabel);
        $runsToWin = max(0, $this->dlsTarget() - $parScore);
        $remainingBalls = max(0, $this->revisedTotalBalls() - $overBalls);
        $requiredRr = $remainingBalls > 0 ? round($runsToWin / ($remainingBalls / 6), 2) : 0.0;

        $wicketsLost = min(10, max(0, $this->secondInningsWickets));
        $wicketFactor = self::WICKET_RESOURCE_FACTORS[$wicketsLost] ?? 0.0;
        $oversFactor = $this->originalTotalBalls() > 0
            ? round($remainingBalls / $this->originalTotalBalls(), 4)
            : 0.0;

        return [
            'over' => $overLabel,
            'team1_score' => $this->firstInningsScore,
            'team1_resource_used' => round($team1ResourceUsed, 2),
            'team2_start_resource' => round($team2StartResource, 2),
            'team2_used_resource_at_over' => round($team2UsedAtOver, 2),
            'resource_ratio_at_over' => round($resourceRatio, 4),
            'par_score' => $parScore,
            'dls_target' => $this->dlsTarget(),
            'runs_to_win' => $runsToWin,
            'required_rr' => $requiredRr,
            'remaining_balls' => $remainingBalls,
            'remaining_overs' => $this->ballsToOversString($remainingBalls),
            'overs_factor' => $oversFactor,
            'wickets_lost' => $wicketsLost,
            'wicket_factor' => $wicketFactor,
        ];
    }

    protected function projectionOversList(): array
    {
        $points = ['5.0', '10.0', '15.0', $this->effectiveProjectionOver()];
        $maxBalls = $this->revisedTotalBalls();
        $valid = [];

        foreach ($points as $point) {
            $balls = $this->oversToBalls($point);
            $balls = min($maxBalls, max(0, $balls));
            $valid[$balls] = true;
        }

        $result = array_keys($valid);
        sort($result);

        return $result;
    }

    protected function team1ResourceUsed(): float
    {
        $totalBalls = $this->originalTotalBalls();

        if ($totalBalls === 0) {
            return 0.0;
        }

        $done = min($totalBalls, $this->oversToBalls($this->firstInningsOvers));
        $remaining = max(0, $totalBalls - $done);
        $wickets = min(10, max(0, (int) ($this->firstInningsWickets ?? 0)));
        $remainingPct = $this->resourceRemainingPercent($remaining, $totalBalls, $wickets);

        return round(max(0, 100 - $remainingPct), 2);
    }

    protected function team2StartResource(): float
    {
        $original = $this->originalTotalBalls();

        if ($original === 0) {
            return 0.0;
        }

        $revised = min($original, $this->revisedTotalBalls());

        return round(($revised / $original) * 100, 2);
    }

    protected function team2UsedResourceAt(string $oversDone, int $wickets): float
    {
        $original = $this->originalTotalBalls();

        if ($original === 0) {
            return 0.0;
        }

        $revised = min($original, $this->revisedTotalBalls());
        $done = min($revised, $this->oversToBalls($oversDone));
        $remaining = max(0, $revised - $done);

        $remainingPct = $this->resourceRemainingPercent($remaining, $original, $wickets);
        $used = $this->team2StartResource() - $remainingPct;

        return round(max(0, $used), 2);
    }

    protected function resourceRemainingPercent(int $remainingBalls, int $originalTotalBalls, int $wicketsLost): float
    {
        if ($originalTotalBalls <= 0) {
            return 0.0;
        }

        $oversFactor = min(1, max(0, $remainingBalls / $originalTotalBalls));
        $wicketsLost = min(10, max(0, $wicketsLost));
        $wicketFactor = self::WICKET_RESOURCE_FACTORS[$wicketsLost] ?? 0.0;

        return round($oversFactor * $wicketFactor * 100, 2);
    }

    protected function currentChaseOvers(): string
    {
        if ($this->interruptionStage === 'before_chase') {
            return '0.0';
        }

        return (string) ($this->rainHappenedOvers ?? '0.0');
    }

    protected function currentChaseBalls(): int
    {
        return min($this->revisedTotalBalls(), $this->oversToBalls($this->currentChaseOvers()));
    }

    protected function originalTotalBalls(): int
    {
        return $this->oversToBalls($this->originalOvers);
    }

    protected function revisedTotalBalls(): int
    {
        return $this->oversToBalls($this->revisedOvers);
    }

    protected function oversToBalls(string $overs): int
    {
        $overs = trim($overs);

        if ($overs === '' || ! preg_match('/^\d+(\.\d+)?$/', $overs)) {
            return 0;
        }

        [$completedOvers, $ballsPart] = array_pad(explode('.', $overs, 2), 2, '0');
        $completedOvers = max(0, (int) $completedOvers);
        $balls = (int) substr($ballsPart, 0, 1);
        $balls = min(5, max(0, $balls));

        return ($completedOvers * 6) + $balls;
    }

    protected function ballsToOversFloat(int $balls): float
    {
        $balls = max(0, $balls);

        return (float) sprintf('%d.%d', intdiv($balls, 6), $balls % 6);
    }

    protected function ballsToOversString(int $balls): string
    {
        $balls = max(0, $balls);

        return sprintf('%d.%d', intdiv($balls, 6), $balls % 6);
    }

    public function render()
    {
        return view('livewire.dls-calculator');
    }

    protected function ensureDefaults(): void
    {
        $this->interruptionStage = $this->interruptionStage !== '' ? $this->interruptionStage : 'during_chase';
        $this->matchStoppedNow = in_array($this->matchStoppedNow, ['yes', 'no'], true) ? $this->matchStoppedNow : 'no';

        $this->originalOvers = $this->originalOvers !== '' ? $this->originalOvers : '20.0';
        $this->revisedOvers = $this->revisedOvers !== '' ? $this->revisedOvers : '15.0';
        $this->firstInningsOvers = $this->firstInningsOvers !== '' ? $this->firstInningsOvers : '20.0';
        $this->rainHappenedOvers = $this->rainHappenedOvers !== '' ? $this->rainHappenedOvers : '10.0';
        $this->specificProjectionOver = $this->specificProjectionOver !== '' ? $this->specificProjectionOver : '14.2';

        $this->firstInningsScore = max(0, (int) ($this->firstInningsScore ?? 0));
        $this->firstInningsWickets = min(10, max(0, (int) ($this->firstInningsWickets ?? 0)));
        $this->secondInningsScore = max(0, (int) ($this->secondInningsScore ?? 0));
        $this->secondInningsWickets = min(10, max(0, (int) ($this->secondInningsWickets ?? 0)));
    }
}
