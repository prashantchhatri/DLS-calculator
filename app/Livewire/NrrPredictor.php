<?php

namespace App\Livewire;

use App\Services\NrrService;
use Livewire\Component;

class NrrPredictor extends Component
{
    public string $currentNrr = '-0.352';

    public int $matchesPlayed = 5;

    public int $totalRunsScored = 812;

    public string $totalOversFaced = '98.4';

    public int $totalRunsConceded = 845;

    public string $totalOversBowled = '100.0';

    public string $upcomingMatchFormat = 't20';

    public string $expectedOvers = '20.0';

    public string $targetNrr = '0.0';

    public string $inningsMode = 'batting_first';

    public ?int $predictedTeamScore = 180;

    public ?int $predictedOppScore = null;

    public ?array $scenarios = null;

    public function updatedUpcomingMatchFormat(): void
    {
        if ($this->upcomingMatchFormat === 't20') {
            $this->expectedOvers = '20.0';
        } elseif ($this->upcomingMatchFormat === 'odi') {
            $this->expectedOvers = '50.0';
        }
    }

    public function loadExample(): void
    {
        $this->currentNrr = '-0.352';
        $this->matchesPlayed = 5;
        $this->totalRunsScored = 812;
        $this->totalOversFaced = '98.4';
        $this->totalRunsConceded = 845;
        $this->totalOversBowled = '100.0';
        $this->upcomingMatchFormat = 't20';
        $this->expectedOvers = '20.0';
        $this->targetNrr = '0.0';
        $this->inningsMode = 'batting_first';
        $this->predictedTeamScore = 180;
        $this->predictedOppScore = null;
    }

    public function predict(NrrService $nrrService): void
    {
        $this->validate($this->rules());

        $overs = max(0.1, (float) $this->expectedOvers);
        $faced = max(0.1, (float) $this->totalOversFaced);
        $bowled = max(0.1, (float) $this->totalOversBowled);

        $this->scenarios = $nrrService->buildPredictorScenarios([
            'matches_played' => $this->matchesPlayed,
            'runs_scored_total' => $this->totalRunsScored,
            'overs_faced_total' => $faced,
            'runs_conceded_total' => $this->totalRunsConceded,
            'overs_bowled_total' => $bowled,
            'expected_overs' => $overs,
            'target_nrr' => $this->targetNrr,
            'current_nrr_input' => $this->currentNrr,
            'innings_mode' => $this->inningsMode,
            'predicted_team_score' => $this->inningsMode === 'batting_first' ? $this->predictedTeamScore : null,
            'predicted_opp_score' => $this->inningsMode === 'bowling_first' ? $this->predictedOppScore : null,
        ]);
    }

    protected function rules(): array
    {
        return [
            'currentNrr' => ['required', 'numeric', 'between:-20,20'],
            'matchesPlayed' => ['required', 'integer', 'min:0', 'max:1000'],
            'totalRunsScored' => ['required', 'integer', 'min:0', 'max:100000'],
            'totalOversFaced' => ['required', 'regex:/^\d+(\.\d+)?$/'],
            'totalRunsConceded' => ['required', 'integer', 'min:0', 'max:100000'],
            'totalOversBowled' => ['required', 'regex:/^\d+(\.\d+)?$/'],
            'upcomingMatchFormat' => ['required', 'in:t20,odi,custom'],
            'expectedOvers' => ['required', 'regex:/^\d+(\.\d+)?$/'],
            'targetNrr' => ['required', 'numeric', 'between:-20,20'],
            'inningsMode' => ['required', 'in:batting_first,bowling_first'],
            'predictedTeamScore' => ['nullable', 'integer', 'min:1', 'max:500', 'required_if:inningsMode,batting_first'],
            'predictedOppScore' => ['nullable', 'integer', 'min:1', 'max:500', 'required_if:inningsMode,bowling_first'],
        ];
    }

    public function render()
    {
        return view('livewire.nrr-predictor');
    }
}
