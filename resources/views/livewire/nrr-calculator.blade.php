<div class="cricket-theme relative min-h-screen overflow-hidden px-3 py-5 sm:px-6 sm:py-8 lg:px-8">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/cricket/stadium.jpg') }}');"></div>
    <div class="theme-overlay absolute inset-0 bg-[linear-gradient(180deg,rgba(2,6,23,0.72)_0%,rgba(2,6,23,0.84)_38%,rgba(5,46,22,0.92)_100%)]"></div>
    <div class="absolute inset-x-0 bottom-0 h-[58%] bg-[radial-gradient(ellipse_at_bottom,#22c55e_0%,#15803d_45%,#14532d_78%,#052e16_100%)] opacity-80"></div>

    <div class="relative mx-auto max-w-6xl space-y-4 sm:space-y-6">
        <section class="theme-panel rounded-2xl border border-cyan-100/20 bg-slate-900/75 p-4 shadow-2xl backdrop-blur-sm sm:p-6">
            <h2 class="mb-4 text-lg text-cyan-100" style="font-family: 'Rajdhani', sans-serif;">NRR Calculator Inputs</h2>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Match Format</span>
                    <select wire:model.live="matchFormat" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-4 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                        <option value="t20">T20</option>
                        <option value="odi">ODI</option>
                        <option value="custom">Custom</option>
                    </select>
                </label>
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Match Overs</span>
                    <input type="text" inputmode="decimal" wire:model.defer="customOvers" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-4 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                </label>
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Result Type</span>
                    <select wire:model.defer="resultStatus" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-4 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                        <option value="completed">Completed</option>
                        <option value="tie">Tie</option>
                        <option value="abandoned">Abandoned</option>
                        <option value="no_result">No Result</option>
                    </select>
                </label>
            </div>

            <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-2">
                <div class="rounded-xl border border-cyan-100/20 bg-slate-950/65 p-4">
                    <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-cyan-100">Team A</p>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <label class="block">
                            <span class="mb-1 block text-xs text-cyan-200/80">Runs Scored</span>
                            <input type="text" inputmode="numeric" wire:model.defer="teamRuns" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="mb-1 block text-xs text-cyan-200/80">Overs Faced</span>
                            <input type="text" inputmode="decimal" wire:model.defer="teamOvers" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                        </label>
                        <label class="inline-flex items-center gap-2 pt-8 text-cyan-100">
                            <input type="checkbox" wire:model.defer="teamAllOut" class="h-4 w-4 rounded border-cyan-300/50 bg-slate-950/70 text-cyan-400 focus:ring-cyan-300">
                            <span class="text-xs uppercase tracking-wide">All Out</span>
                        </label>
                    </div>
                </div>

                <div class="rounded-xl border border-cyan-100/20 bg-slate-950/65 p-4">
                    <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-cyan-100">Team B</p>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <label class="block">
                            <span class="mb-1 block text-xs text-cyan-200/80">Runs Scored</span>
                            <input type="text" inputmode="numeric" wire:model.defer="oppRuns" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="mb-1 block text-xs text-cyan-200/80">Overs Faced</span>
                            <input type="text" inputmode="decimal" wire:model.defer="oppOvers" class="h-12 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none">
                        </label>
                        <label class="inline-flex items-center gap-2 pt-8 text-cyan-100">
                            <input type="checkbox" wire:model.defer="oppAllOut" class="h-4 w-4 rounded border-cyan-300/50 bg-slate-950/70 text-cyan-400 focus:ring-cyan-300">
                            <span class="text-xs uppercase tracking-wide">All Out</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4 rounded-xl border border-amber-300/25 bg-slate-950/60 p-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <label class="inline-flex items-center gap-2 text-cyan-100">
                        <input type="checkbox" wire:model.live="rainAffected" class="h-4 w-4 rounded border-cyan-300/50 bg-slate-950/70 text-cyan-400 focus:ring-cyan-300">
                        <span class="text-xs uppercase tracking-wide">Rain Affected</span>
                    </label>
                    <label class="inline-flex items-center gap-2 text-cyan-100">
                        <input type="checkbox" wire:model.defer="dlsApplied" class="h-4 w-4 rounded border-cyan-300/50 bg-slate-950/70 text-cyan-400 focus:ring-cyan-300">
                        <span class="text-xs uppercase tracking-wide">DLS Applied</span>
                    </label>
                    <label class="block">
                        <span class="mb-1 block text-xs text-cyan-200/80">Revised Team A Overs</span>
                        <input type="text" inputmode="decimal" wire:model.defer="revisedTeamOvers" class="h-10 w-full rounded-lg border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none disabled:opacity-40" @disabled(!$rainAffected)>
                    </label>
                    <label class="block">
                        <span class="mb-1 block text-xs text-cyan-200/80">Revised Team B Overs</span>
                        <input type="text" inputmode="decimal" wire:model.defer="revisedOppOvers" class="h-10 w-full rounded-lg border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none disabled:opacity-40" @disabled(!$rainAffected)>
                    </label>
                </div>

                <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <label class="block">
                        <span class="mb-1 block text-xs text-cyan-200/80">Revised Target (optional)</span>
                        <input type="text" inputmode="numeric" wire:model.defer="revisedTarget" class="h-10 w-full rounded-lg border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none disabled:opacity-40" @disabled(!$dlsApplied)>
                    </label>
                    <label class="block">
                        <span class="mb-1 block text-xs text-cyan-200/80">Par Score (optional)</span>
                        <input type="text" inputmode="numeric" wire:model.defer="parScore" class="h-10 w-full rounded-lg border border-cyan-100/25 bg-slate-950/70 px-3 text-cyan-50 focus:border-cyan-300 focus:outline-none disabled:opacity-40" @disabled(!$dlsApplied)>
                    </label>
                </div>
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

            <div class="mt-4 grid grid-cols-2 gap-2 sm:max-w-sm">
                <button type="button" wire:click="calculate" class="rounded-xl border border-emerald-300/40 bg-emerald-500/25 px-5 py-3 text-sm font-semibold uppercase tracking-wider text-emerald-100">Calculate NRR</button>
                <button type="button" wire:click="useExampleData" class="rounded-xl border border-cyan-300/40 bg-cyan-500/20 px-5 py-3 text-sm font-semibold uppercase tracking-wider text-cyan-100">Load Example</button>
            </div>
        </section>

        @if($result)
            <section class="theme-panel rounded-2xl border border-amber-300/25 bg-slate-900/80 p-4 shadow-2xl backdrop-blur-sm sm:p-6">
                <h3 class="mb-3 text-lg text-amber-100">NRR Output</h3>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <article class="rounded-xl border border-cyan-300/20 bg-slate-950/75 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-cyan-200/80">Team A NRR</p>
                        <p class="mt-1 text-3xl text-cyan-100">{{ number_format($result['team_nrr'], 4) }}</p>
                    </article>
                    <article class="rounded-xl border border-cyan-300/20 bg-slate-950/75 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-cyan-200/80">Team B NRR</p>
                        <p class="mt-1 text-3xl text-cyan-100">{{ number_format($result['opp_nrr'], 4) }}</p>
                    </article>
                </div>
            </section>
        @endif
    </div>
</div>
