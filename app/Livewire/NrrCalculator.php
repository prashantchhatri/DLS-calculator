<?php

namespace App\Livewire;

use App\Services\NrrService;
use Livewire\Component;

class NrrCalculator extends Component
{
    public string $matchFormat = 't20';

    public string $customOvers = '20.0';

    public int $teamRuns = 187;

    public string $teamOvers = '20.0';

    public bool $teamAllOut = true;

    public int $oppRuns = 111;

    public string $oppOvers = '18.5';

    public bool $oppAllOut = true;

    public bool $rainAffected = false;

    public string $revisedTeamOvers = '20.0';

    public string $revisedOppOvers = '20.0';

    public bool $dlsApplied = false;

    public ?int $revisedTarget = null;

    public ?int $parScore = null;

    public string $resultStatus = 'completed';

    public ?array $result = null;

    public function mount(): void
    {
        $this->syncOversByFormat();
        $this->result = app(NrrService::class)->calculateMatchNrr([
            'team_runs' => (int) $this->teamRuns,
            'team_overs' => $this->teamOvers,
            'team_all_out' => (bool) $this->teamAllOut,
            'opp_runs' => (int) $this->oppRuns,
            'opp_overs' => $this->oppOvers,
            'opp_all_out' => (bool) $this->oppAllOut,
            'base_overs' => $this->baseOversByFormat(),
            'rain_affected' => (bool) $this->rainAffected,
            'revised_team_overs' => null,
            'revised_opp_overs' => null,
            'dls_applied' => (bool) $this->dlsApplied,
            'revised_target' => null,
            'par_score' => null,
            'result_status' => $this->resultStatus,
        ]);
    }

    public function updatedMatchFormat(): void
    {
        $this->syncOversByFormat();
    }

    public function syncOversByFormat(): void
    {
        if ($this->matchFormat === 't20') {
            $this->customOvers = '20.0';
        } elseif ($this->matchFormat === 'odi') {
            $this->customOvers = '50.0';
        }

        if (! $this->rainAffected) {
            $this->revisedTeamOvers = $this->customOvers;
            $this->revisedOppOvers = $this->customOvers;
        }
    }

    public function useExampleData(): void
    {
        $this->matchFormat = 'custom';
        $this->customOvers = '18.0';
        $this->teamRuns = 133;
        $this->teamOvers = '18.0';
        $this->teamAllOut = true;
        $this->oppRuns = 50;
        $this->oppOvers = '5.1';
        $this->oppAllOut = false;
        $this->rainAffected = true;
        $this->revisedTeamOvers = '18.0';
        $this->revisedOppOvers = '18.0';
        $this->dlsApplied = true;
        $this->revisedTarget = 72;
        $this->parScore = 71;
        $this->resultStatus = 'completed';
    }

    public function calculate(NrrService $nrrService): void
    {
        $validated = $this->validate($this->rules(), [], $this->attributes());

        if (! $validated['rainAffected']) {
            $this->revisedTeamOvers = $this->customOvers;
            $this->revisedOppOvers = $this->customOvers;
        }

        $baseOvers = $this->baseOversByFormat();

        $this->result = $nrrService->calculateMatchNrr([
            'team_runs' => (int) $this->teamRuns,
            'team_overs' => $this->teamOvers,
            'team_all_out' => (bool) $this->teamAllOut,
            'opp_runs' => (int) $this->oppRuns,
            'opp_overs' => $this->oppOvers,
            'opp_all_out' => (bool) $this->oppAllOut,
            'base_overs' => $baseOvers,
            'rain_affected' => (bool) $this->rainAffected,
            'revised_team_overs' => $this->rainAffected ? $this->revisedTeamOvers : null,
            'revised_opp_overs' => $this->rainAffected ? $this->revisedOppOvers : null,
            'dls_applied' => (bool) $this->dlsApplied,
            'revised_target' => $this->dlsApplied ? $this->revisedTarget : null,
            'par_score' => $this->dlsApplied ? $this->parScore : null,
            'result_status' => $this->resultStatus,
        ]);
    }

    protected function baseOversByFormat(): string
    {
        return match ($this->matchFormat) {
            't20' => '20.0',
            'odi' => '50.0',
            default => $this->customOvers,
        };
    }

    protected function rules(): array
    {
        return [
            'matchFormat' => ['required', 'in:t20,odi,custom'],
            'customOvers' => ['required', 'regex:/^\d+(\.\d+)?$/'],
            'teamRuns' => ['required', 'integer', 'min:0', 'max:999'],
            'teamOvers' => ['required', 'regex:/^\d+(\.\d+)?$/'],
            'teamAllOut' => ['required', 'boolean'],
            'oppRuns' => ['required', 'integer', 'min:0', 'max:999'],
            'oppOvers' => ['required', 'regex:/^\d+(\.\d+)?$/'],
            'oppAllOut' => ['required', 'boolean'],
            'rainAffected' => ['required', 'boolean'],
            'revisedTeamOvers' => ['required_if:rainAffected,1', 'regex:/^\d+(\.\d+)?$/'],
            'revisedOppOvers' => ['required_if:rainAffected,1', 'regex:/^\d+(\.\d+)?$/'],
            'dlsApplied' => ['required', 'boolean'],
            'revisedTarget' => ['nullable', 'integer', 'min:1', 'max:999'],
            'parScore' => ['nullable', 'integer', 'min:0', 'max:999'],
            'resultStatus' => ['required', 'in:completed,tie,abandoned,no_result'],
        ];
    }

    protected function attributes(): array
    {
        return [
            'teamRuns' => 'Team A runs',
            'teamOvers' => 'Team A overs',
            'oppRuns' => 'Team B runs',
            'oppOvers' => 'Team B overs',
        ];
    }

    public function render()
    {
        return view('livewire.nrr-calculator');
    }
}
