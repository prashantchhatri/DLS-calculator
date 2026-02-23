<?php

namespace App\Livewire;

use Livewire\Component;

class DlsCalculator extends Component
{
    /**
     * Simplified remaining-resource multipliers by wickets lost.
     * Index = wickets, value = remaining batting resource factor.
     */
    private const WICKET_RESOURCE_FACTORS = [
        1.00, // 0 wickets
        0.95, // 1 wicket
        0.90, // 2 wickets
        0.84, // 3 wickets
        0.77, // 4 wickets
        0.69, // 5 wickets
        0.60, // 6 wickets
        0.50, // 7 wickets
        0.39, // 8 wickets
        0.27, // 9 wickets
        0.00, // 10 wickets
    ];

    public int $currentRuns = 0;

    public int $wickets = 0;

    public string $oversDone = '0.0';

    public string $totalOvers = '20.0';

    public int $targetScore = 0;

    public function adjust(string $field, int $delta): void
    {
        $allowed = ['currentRuns', 'wickets', 'targetScore'];

        if (! in_array($field, $allowed, true)) {
            return;
        }

        $next = (int) $this->{$field} + $delta;

        if ($field === 'wickets') {
            $next = min(10, max(0, $next));
        } else {
            $next = max(0, $next);
        }

        $this->{$field} = $next;
    }

    public function resetCalculator(): void
    {
        $this->currentRuns = 0;
        $this->wickets = 0;
        $this->oversDone = '0.0';
        $this->totalOvers = '20.0';
        $this->targetScore = 0;
    }

    public function loadSampleT20(): void
    {
        $this->currentRuns = 76;
        $this->wickets = 3;
        $this->oversDone = '11.2';
        $this->totalOvers = '20.0';
        $this->targetScore = 178;
    }

    public function oversRemaining(): float
    {
        $remainingBalls = $this->remainingBalls();

        return $this->ballsToOvers($remainingBalls);
    }

    public function runsRemaining(): int
    {
        return max(0, $this->adjustedTarget() - $this->currentRuns);
    }

    public function requiredRunRate(): float
    {
        $remainingBalls = $this->remainingBalls();

        if ($remainingBalls === 0) {
            return 0.0;
        }

        $remainingOvers = $remainingBalls / 6;

        return round($this->runsRemaining() / $remainingOvers, 2);
    }

    /**
     * Simplified DLS resource percentage (0-100).
     * Resources drop as overs are consumed and wickets are lost.
     */
    public function resourcePercentage(): float
    {
        $totalBalls = $this->totalBalls();

        if ($totalBalls === 0) {
            return 0.0;
        }

        $oversFactor = $this->remainingBalls() / $totalBalls;
        $oversFactor = min(1, max(0, $oversFactor));

        $wicketsLost = min(10, max(0, $this->wickets));
        $wicketFactor = self::WICKET_RESOURCE_FACTORS[$wicketsLost] ?? 0.0;

        return round($oversFactor * $wicketFactor * 100, 2);
    }

    /**
     * Simplified adjusted target based on remaining resources.
     * Formula: ((original target - 1) * resource%) + 1
     */
    public function adjustedTarget(): int
    {
        $baseTarget = max(1, $this->targetScore);
        $resourcePct = $this->resourcePercentage();

        return (int) ceil((($baseTarget - 1) * ($resourcePct / 100)) + 1);
    }

    protected function doneBalls(): int
    {
        return $this->oversToBalls($this->oversDone);
    }

    protected function totalBalls(): int
    {
        return $this->oversToBalls($this->totalOvers);
    }

    protected function remainingBalls(): int
    {
        return max(0, $this->totalBalls() - $this->doneBalls());
    }

    protected function oversToBalls(string $overs): int
    {
        $overs = trim($overs);

        if ($overs === '' || ! preg_match('/^\d+(\.\d+)?$/', $overs)) {
            return 0;
        }

        [$completedOvers, $ballsPart] = array_pad(explode('.', $overs, 2), 2, '0');
        $completedOvers = (int) $completedOvers;
        $balls = (int) substr($ballsPart, 0, 1);
        $balls = min(5, max(0, $balls));

        return ($completedOvers * 6) + $balls;
    }

    protected function ballsToOvers(int $balls): float
    {
        $balls = max(0, $balls);

        return (float) sprintf('%d.%d', intdiv($balls, 6), $balls % 6);
    }

    public function render()
    {
        return view('livewire.dls-calculator');
    }
}
