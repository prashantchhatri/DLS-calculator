<div class="cricket-theme relative min-h-screen overflow-hidden px-3 py-5 sm:px-6 sm:py-8 lg:px-8">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/cricket/stadium.jpg') }}');"></div>
    <div class="theme-overlay absolute inset-0 bg-[linear-gradient(180deg,rgba(2,6,23,0.72)_0%,rgba(2,6,23,0.84)_38%,rgba(5,46,22,0.92)_100%)]"></div>
    <div class="absolute inset-x-0 bottom-0 h-[58%] bg-[radial-gradient(ellipse_at_bottom,#22c55e_0%,#15803d_45%,#14532d_78%,#052e16_100%)] opacity-80"></div>

    <div class="relative mx-auto max-w-6xl space-y-4 sm:space-y-6">
        <section class="theme-panel rounded-2xl border border-cyan-100/20 bg-slate-900/75 p-4 shadow-2xl backdrop-blur-sm sm:p-6">
            <h2 class="mb-4 text-lg text-cyan-100">NRR Target Predictor</h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Current NRR</span>
                    <input type="text" inputmode="decimal" wire:model.defer="currentNrr" class="h-11 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                </label>
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Matches Played</span>
                    <input type="text" inputmode="numeric" wire:model.defer="matchesPlayed" class="h-11 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                </label>
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Runs Scored (Total)</span>
                    <input type="text" inputmode="numeric" wire:model.defer="totalRunsScored" class="h-11 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                </label>
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Overs Faced (Total)</span>
                    <input type="text" inputmode="decimal" wire:model.defer="totalOversFaced" class="h-11 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                </label>
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Runs Conceded (Total)</span>
                    <input type="text" inputmode="numeric" wire:model.defer="totalRunsConceded" class="h-11 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                </label>
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Overs Bowled (Total)</span>
                    <input type="text" inputmode="decimal" wire:model.defer="totalOversBowled" class="h-11 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                </label>
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Upcoming Match Format</span>
                    <select wire:model.live="upcomingMatchFormat" class="h-11 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                        <option value="t20">T20</option>
                        <option value="odi">ODI</option>
                        <option value="custom">Custom</option>
                    </select>
                </label>
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Expected Overs</span>
                    <input type="text" inputmode="decimal" wire:model.defer="expectedOvers" class="h-11 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                </label>
            </div>

            <div class="mt-4 grid grid-cols-1 gap-3">
                <label class="block max-w-sm">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Target NRR</span>
                    <input type="text" inputmode="decimal" wire:model.defer="targetNrr" class="h-11 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                </label>
            </div>

            <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Upcoming Innings Choice</span>
                    <select wire:model.live="inningsMode" class="h-11 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                        <option value="batting_first">Batting First</option>
                        <option value="bowling_first">Bowling First</option>
                    </select>
                </label>

                @if($inningsMode === 'batting_first')
                    <label class="block">
                        <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Predicted Team Score (batting first)</span>
                        <input type="text" inputmode="numeric" wire:model.defer="predictedTeamScore" class="h-11 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                    </label>
                @else
                    <label class="block">
                        <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Predicted Opponent Score (bowling first)</span>
                        <input type="text" inputmode="numeric" wire:model.defer="predictedOppScore" class="h-11 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                    </label>
                @endif
            </div>

            <div class="mt-4 grid grid-cols-2 gap-2 sm:max-w-sm">
                <button type="button" wire:click="predict" class="rounded-xl border border-emerald-300/40 bg-emerald-500/25 px-4 py-3 text-sm font-semibold uppercase tracking-wider text-emerald-100">Predict</button>
                <button type="button" wire:click="loadExample" class="rounded-xl border border-cyan-300/40 bg-cyan-500/20 px-4 py-3 text-sm font-semibold uppercase tracking-wider text-cyan-100">Load Example</button>
            </div>

            @if($errors->any())
                <div class="mt-4 rounded-xl border border-rose-300/35 bg-rose-950/30 p-3 text-sm text-rose-100">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>

        @if($scenarios)
            <section class="theme-panel rounded-2xl border border-amber-300/25 bg-slate-900/80 p-4 shadow-2xl backdrop-blur-sm sm:p-6">
                <h3 class="mb-3 text-lg text-amber-100">Scenario Summary</h3>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <article class="rounded-xl border border-cyan-300/20 bg-slate-950/75 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-cyan-200/80">Current NRR</p>
                        <p class="mt-1 text-3xl text-cyan-100">{{ number_format($scenarios['current_nrr_input'], 4) }}</p>
                    </article>
                    <article class="rounded-xl border border-cyan-300/20 bg-slate-950/75 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-cyan-200/80">Target NRR</p>
                        <p class="mt-1 text-3xl text-cyan-100">{{ number_format($scenarios['target_nrr'], 4) }}</p>
                    </article>
                </div>

                @if($scenarios['innings_mode'] === 'batting_first')
                    <div class="mt-5">
                        <article class="rounded-xl border border-cyan-100/20 bg-slate-950/65 p-4">
                            <h4 class="mb-2 text-cyan-100">Batting First Scenarios (for required NRR)</h4>
                            @if($scenarios['primary_batting'])
                                <p class="rounded-xl border border-cyan-300/20 bg-slate-950/75 px-4 py-3 text-cyan-100">
                                    All out opponent under <strong>{{ $scenarios['primary_batting']['opp_all_out_runs'] }}</strong> runs before
                                    <strong>{{ $scenarios['primary_batting']['opp_all_out_by_over'] }}</strong> overs.
                                </p>
                            @endif
                        </article>
                    </div>
                @else
                    <div class="mt-5">
                        <article class="rounded-xl border border-cyan-100/20 bg-slate-950/65 p-4">
                            <h4 class="mb-2 text-cyan-100">Bowling First Scenarios (for required NRR)</h4>
                            @if($scenarios['primary_bowling'])
                                <p class="rounded-xl border border-cyan-300/20 bg-slate-950/75 px-4 py-3 text-cyan-100">
                                    Chase target <strong>{{ $scenarios['primary_bowling']['chase_target'] }}</strong> in
                                    <strong>{{ $scenarios['primary_bowling']['chase_by_over'] }}</strong> overs with
                                    <strong>{{ $scenarios['primary_bowling']['wickets_remaining'] }}</strong> wickets remaining.
                                </p>
                            @endif
                        </article>
                    </div>
                @endif
            </section>
        @endif
    </div>
</div>
