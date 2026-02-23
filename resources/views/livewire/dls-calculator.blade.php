<div class="cricket-theme relative min-h-screen overflow-hidden px-3 py-5 sm:px-6 sm:py-8 lg:px-8">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Rajdhani:wght@400;500;600;700&display=swap');
    </style>

    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/cricket/stadium.jpg') }}');"></div>
    <div class="theme-overlay absolute inset-0 bg-[linear-gradient(180deg,rgba(2,6,23,0.72)_0%,rgba(2,6,23,0.84)_38%,rgba(5,46,22,0.92)_100%)]"></div>
    <div class="absolute inset-x-0 bottom-0 h-[58%] bg-[radial-gradient(ellipse_at_bottom,#22c55e_0%,#15803d_45%,#14532d_78%,#052e16_100%)] opacity-80"></div>

    <div class="relative mx-auto max-w-6xl space-y-4 sm:space-y-6">
        <header class="theme-panel rounded-2xl border border-cyan-100/20 bg-slate-900/70 p-4 shadow-2xl backdrop-blur-sm sm:p-5">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-full border border-amber-300/40 bg-amber-300/10 text-amber-200">
                        <i class="fa-solid fa-baseball-bat-ball text-xl"></i>
                    </span>
                    <div>
                        <p class="text-xs uppercase tracking-[0.28em] text-cyan-200/80" style="font-family: 'Rajdhani', sans-serif;">Cricket DLS Pro</p>
                        <h1 class="text-[clamp(2rem,9vw,3.4rem)] leading-none text-white" style="font-family: 'Bebas Neue', cursive;">Rain Interruption Calculator</h1>
                    </div>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-[1.35fr_1fr]">
            <section class="theme-panel rounded-2xl border border-cyan-100/20 bg-slate-900/75 p-4 shadow-2xl backdrop-blur-sm sm:p-6">
                <h2 class="mb-4 text-lg text-cyan-100" style="font-family: 'Rajdhani', sans-serif;">User Inputs</h2>

                <div class="mb-4 grid grid-cols-1 gap-3 sm:grid-cols-1">
                    <label class="block">
                        <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Original Match Overs</span>
                        <input type="text" inputmode="decimal" wire:model.defer="originalOvers" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-4 text-cyan-50 focus:border-cyan-300 focus:outline-none" style="font-family: 'Rajdhani', sans-serif;">
                    </label>
                </div>

                <label class="mb-4 block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Rain Interruption Stage</span>
                    <select wire:model.change="interruptionStage" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-4 text-cyan-50 focus:border-cyan-300 focus:outline-none" style="font-family: 'Rajdhani', sans-serif;">
                        <option value="before_chase">Rain before second innings started</option>
                        <option value="during_chase">Rain during second innings chase</option>
                    </select>
                </label>

                <label class="mb-4 block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Has Match Stopped Now?</span>
                    <select wire:model.live="matchStoppedNow" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-4 text-cyan-50 focus:border-cyan-300 focus:outline-none" style="font-family: 'Rajdhani', sans-serif;">
                        <option value="no">No, show projection for specific over</option>
                        <option value="yes">Yes, show result directly at rain-stop over</option>
                    </select>
                </label>

                <div class="rounded-xl border border-cyan-100/20 bg-slate-950/65 p-4">
                    <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-cyan-100" style="font-family: 'Rajdhani', sans-serif;">First Innings (Team 1)</p>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <label class="block">
                            <span class="mb-1 block text-xs text-cyan-200/80">Score</span>
                            <input type="text" inputmode="numeric" wire:model.defer="firstInningsScore" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none" style="font-family: 'Rajdhani', sans-serif;">
                        </label>
                        <label class="block">
                            <span class="mb-1 block text-xs text-cyan-200/80">Wickets</span>
                            <input type="text" inputmode="numeric" wire:model.defer="firstInningsWickets" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none" style="font-family: 'Rajdhani', sans-serif;">
                        </label>
                        <label class="block">
                            <span class="mb-1 block text-xs text-cyan-200/80">Overs Faced</span>
                            <input type="text" inputmode="decimal" wire:model.defer="firstInningsOvers" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none" style="font-family: 'Rajdhani', sans-serif;">
                        </label>
                    </div>
                </div>

                <div class="mt-4 rounded-xl border border-cyan-100/20 bg-slate-950/65 p-4">
                    <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-cyan-100" style="font-family: 'Rajdhani', sans-serif;">Second Innings (Team 2 at Rain Time)</p>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <label class="block">
                            <span class="mb-1 block text-xs text-cyan-200/80">Current Score</span>
                            <input type="text" inputmode="numeric" wire:model.defer="secondInningsScore" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none" style="font-family: 'Rajdhani', sans-serif;">
                        </label>
                        <label class="block">
                            <span class="mb-1 block text-xs text-cyan-200/80">Wickets Lost</span>
                            <input type="text" inputmode="numeric" wire:model.defer="secondInningsWickets" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none" style="font-family: 'Rajdhani', sans-serif;">
                        </label>
                        <label class="block">
                            <span class="mb-1 block text-xs text-cyan-200/80">Overs at Rain</span>
                            <input type="text" inputmode="decimal" wire:model.defer="rainHappenedOvers" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none disabled:opacity-40" @if($interruptionStage === 'before_chase') disabled @endif style="font-family: 'Rajdhani', sans-serif;">
                        </label>
                    </div>
                    @if($interruptionStage === 'before_chase')
                        <p class="mt-2 text-xs text-amber-100/85" style="font-family: 'Rajdhani', sans-serif;">Second innings not started: overs at rain is treated as 0.0.</p>
                    @endif
                </div>

                <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-[1fr_auto]">
                    @if($matchStoppedNow === 'no')
                    <label class="block">
                        <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Weather-Decided Total Overs</span>
                        <input type="text" inputmode="decimal" wire:model.defer="specificProjectionOver" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-4 text-cyan-50 focus:border-cyan-300 focus:outline-none" style="font-family: 'Rajdhani', sans-serif;">
                    </label>
                    @else
                    <div class="rounded-xl border border-cyan-100/20 bg-slate-950/65 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-widest text-cyan-200/80" style="font-family: 'Rajdhani', sans-serif;">Projection Over</p>
                        <p class="mt-1 text-cyan-50" style="font-family: 'Rajdhani', sans-serif;">Using rain-stop over automatically: {{ $this->rainStopOverLabel() }}</p>
                    </div>
                    @endif
                    <div class="grid grid-cols-2 gap-2 self-end">
                        <button type="button" wire:click="calculate" class="touch-manipulation rounded-xl border border-emerald-300/40 bg-emerald-500/25 px-5 py-3 text-sm font-semibold uppercase tracking-wider text-emerald-100 active:scale-[0.98]" style="font-family: 'Rajdhani', sans-serif;">Calculate DLS</button>
                        <button type="button" wire:click="resetCalculator" class="touch-manipulation rounded-xl border border-rose-300/40 bg-rose-400/20 px-5 py-3 text-sm font-semibold uppercase tracking-wider text-rose-100 active:scale-[0.98]" style="font-family: 'Rajdhani', sans-serif;">Reset</button>
                    </div>
                </div>
                <p class="mt-2 text-xs text-cyan-200/80" style="font-family: 'Rajdhani', sans-serif;">Results refresh only when you click <strong>Calculate DLS</strong>.</p>
            </section>

            <section class="theme-panel rounded-2xl border border-amber-300/25 bg-slate-900/80 p-4 shadow-2xl backdrop-blur-sm sm:p-6">
                <h2 class="mb-4 text-lg text-amber-100" style="font-family: 'Rajdhani', sans-serif;">DLS Results</h2>

                @if($matchStoppedNow === 'yes')
                    @if($this->stoppedMatchResult())
                        @php($stopped = $this->stoppedMatchResult())
                        <article class="rounded-xl border border-amber-300/30 bg-amber-950/40 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-amber-200/80">Match Result</p>
                            <p class="mt-1 text-[clamp(1.4rem,6vw,2rem)] leading-tight text-amber-100" style="font-family: 'Rajdhani', sans-serif;">{{ $stopped['summary'] }}</p>
                        </article>
                    @endif
                @else
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-1">
                        <article class="rounded-xl border border-emerald-300/30 bg-emerald-950/70 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-emerald-100/85">Target Score At {{ $this->effectiveProjectionOver() }} Overs</p>
                            <p class="mt-1 text-[clamp(2.2rem,10vw,3rem)] leading-none text-emerald-300" style="font-family: 'Bebas Neue', cursive;">{{ $this->projectionParScore() + 1 }}</p>
                        </article>

                        <article class="rounded-xl border border-sky-300/20 bg-slate-950/75 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-sky-200/80">Runs Needed From Current Score</p>
                            <p class="mt-1 text-[clamp(1.9rem,8.8vw,2.45rem)] leading-none text-sky-200" style="font-family: 'Bebas Neue', cursive;">{{ $this->projectionRunsNeeded() }}</p>
                        </article>
                    </div>
                @endif

                <p class="mt-4 rounded-xl border border-amber-300/20 bg-slate-950/60 px-3 py-2 text-xs text-amber-100/85" style="font-family: 'Rajdhani', sans-serif;">
                    Note: This app uses a simplified public DLS-style resource model. ICC matches use the official licensed DLS-Stern tables and exact match-official rules, so results may differ from official ICC outcomes.
                </p>
            </section>
        </div>

        @if($matchStoppedNow !== 'yes')
            <section class="theme-panel rounded-2xl border border-cyan-100/20 bg-slate-900/75 p-4 shadow-2xl backdrop-blur-sm sm:p-6">
                <div class="mb-3 flex items-center justify-between gap-3">
                    <h2 class="text-lg text-cyan-100" style="font-family: 'Rajdhani', sans-serif;">DLS Par Score Projections</h2>
                    <button
                        type="button"
                        wire:click="showOverInfo('{{ $this->effectiveProjectionOver() }}')"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-cyan-300/50 bg-cyan-400/10 text-cyan-100 hover:bg-cyan-400/20"
                        title="Calculation info"
                        aria-label="Calculation info"
                    >
                        <i class="fa-solid fa-circle-info text-base"></i>
                    </button>
                </div>
                <p class="mb-3 text-xs text-cyan-200/80" style="font-family: 'Rajdhani', sans-serif;">Includes checkpoints for 5.0, 10.0, 15.0 overs and your specific over input.</p>

                <div class="overflow-x-auto rounded-xl border border-cyan-100/20">
                    <table class="min-w-full text-left text-sm" style="font-family: 'Rajdhani', sans-serif;">
                        <thead class="bg-slate-950/80 text-cyan-100">
                            <tr>
                                <th class="px-4 py-3">Over</th>
                                <th class="px-4 py-3">Par Score at Over</th>
                            </tr>
                        </thead>
                        <tbody class="bg-slate-900/45 text-cyan-50">
                            @foreach ($this->projectionRows() as $row)
                                <tr class="border-t border-cyan-100/10">
                                    <td class="px-4 py-3 font-semibold">{{ $row['over'] }}</td>
                                    <td class="px-4 py-3">{{ $row['par_score'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </div>

    @if($this->selectedOverBreakdown())
        @php($info = $this->selectedOverBreakdown())
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/75 p-4 backdrop-blur-sm">
            <div class="w-full max-w-2xl rounded-2xl border border-cyan-100/25 bg-slate-900 p-5 shadow-2xl">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <div>
                        <h3 class="text-xl text-cyan-100" style="font-family: 'Rajdhani', sans-serif;">Calculation Details for Over {{ $info['over'] }}</h3>
                        <p class="mt-1 text-xs text-cyan-200/75" style="font-family: 'Rajdhani', sans-serif;">How the app derived par score and required runs for this checkpoint.</p>
                    </div>
                    <button type="button" wire:click="closeOverInfo" class="rounded-lg border border-cyan-100/25 px-3 py-1 text-cyan-100 hover:bg-cyan-400/10">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 gap-2 text-sm text-cyan-50 sm:grid-cols-2" style="font-family: 'Rajdhani', sans-serif;">
                    <p><span class="font-semibold text-cyan-200">Team 1 Score:</span> {{ $info['team1_score'] }}</p>
                    <p><span class="font-semibold text-cyan-200">Team 1 Resource Used:</span> {{ number_format($info['team1_resource_used'], 2) }}%</p>
                    <p><span class="font-semibold text-cyan-200">Team 2 Start Resource:</span> {{ number_format($info['team2_start_resource'], 2) }}%</p>
                    <p><span class="font-semibold text-cyan-200">Team 2 Used @ {{ $info['over'] }}:</span> {{ number_format($info['team2_used_resource_at_over'], 2) }}%</p>
                    <p><span class="font-semibold text-cyan-200">Par Score @ Over:</span> {{ $info['par_score'] }}</p>
                    <p><span class="font-semibold text-cyan-200">DLS Target:</span> {{ $info['dls_target'] }}</p>
                    <p><span class="font-semibold text-cyan-200">Runs to Win from {{ $info['over'] }}:</span> {{ $info['runs_to_win'] }}</p>
                    <p><span class="font-semibold text-cyan-200">Required RR:</span> {{ number_format($info['required_rr'], 2) }}</p>
                    <p><span class="font-semibold text-cyan-200">Remaining Overs:</span> {{ $info['remaining_overs'] }}</p>
                    <p><span class="font-semibold text-cyan-200">Remaining Balls:</span> {{ $info['remaining_balls'] }}</p>
                    <p><span class="font-semibold text-cyan-200">Wickets Lost:</span> {{ $info['wickets_lost'] }}</p>
                    <p><span class="font-semibold text-cyan-200">Wicket Factor:</span> {{ number_format($info['wicket_factor'], 2) }}</p>
                </div>

                <div class="mt-4 text-right">
                    <button type="button" wire:click="closeOverInfo" class="rounded-xl border border-cyan-300/40 bg-cyan-400/20 px-4 py-2 text-sm font-semibold text-cyan-100 hover:bg-cyan-400/30">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
