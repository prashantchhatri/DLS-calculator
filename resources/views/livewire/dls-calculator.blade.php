<div class="cricket-theme relative min-h-screen overflow-hidden px-3 py-5 sm:px-6 sm:py-8 lg:px-8">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Rajdhani:wght@400;500;600;700&display=swap');
    </style>

    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/cricket/stadium.jpg') }}');"></div>
    <div class="theme-overlay absolute inset-0 bg-[linear-gradient(180deg,rgba(2,6,23,0.72)_0%,rgba(2,6,23,0.84)_38%,rgba(5,46,22,0.92)_100%)]"></div>
    <div class="absolute inset-x-0 bottom-0 h-[58%] bg-[radial-gradient(ellipse_at_bottom,#22c55e_0%,#15803d_45%,#14532d_78%,#052e16_100%)] opacity-80"></div>

    <img
        src="{{ asset('images/cricket/bat.png') }}"
        alt="Cricket bat"
        class="pointer-events-none absolute -left-8 bottom-0 hidden h-[380px] opacity-40 drop-shadow-2xl lg:block"
    >
    <img
        src="{{ asset('images/cricket/ball.png') }}"
        alt="Cricket ball"
        class="pointer-events-none absolute right-6 top-8 hidden h-20 w-20 rotate-[-16deg] opacity-80 drop-shadow-2xl md:block"
    >

    <div class="relative mx-auto max-w-6xl">
        <header class="theme-panel mb-4 rounded-2xl border border-cyan-100/20 bg-slate-900/70 p-4 shadow-2xl backdrop-blur-sm sm:mb-6 sm:p-5">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-full border border-amber-300/40 bg-amber-300/10 text-amber-200">
                        <i class="fa-solid fa-baseball-bat-ball text-xl"></i>
                    </span>
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-cyan-200/80" style="font-family: 'Rajdhani', sans-serif;">Rain Interruption Tool</p>
                        <h1 class="text-[clamp(2rem,9vw,3.4rem)] leading-none text-white" style="font-family: 'Bebas Neue', cursive;">DLS Calculator</h1>
                    </div>
                </div>

                <div class="flex items-center gap-2 rounded-full border border-emerald-300/30 bg-emerald-300/10 px-4 py-2 text-emerald-100">
                    <i class="fa-solid fa-cloud-rain text-sm"></i>
                    <span class="text-sm font-semibold uppercase tracking-widest" style="font-family: 'Rajdhani', sans-serif;">Live Match Mode</span>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 gap-4 sm:gap-6 lg:grid-cols-[1.25fr_1fr]">
            <section class="theme-panel rounded-2xl border border-slate-200/10 bg-slate-900/75 p-4 shadow-2xl backdrop-blur-sm sm:p-6">
                <h2 class="mb-4 flex items-center gap-2 text-[clamp(1.1rem,4.5vw,1.35rem)] text-cyan-100 sm:mb-5" style="font-family: 'Rajdhani', sans-serif;">
                    <i class="fa-solid fa-list-check text-cyan-300"></i>
                    Innings State
                </h2>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <label class="block">
                        <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Current Runs</span>
                        <input
                            type="number"
                            min="0"
                            wire:model.live="currentRuns"
                            class="h-14 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-4 text-[clamp(1rem,4.3vw,1.2rem)] text-cyan-50 placeholder:text-cyan-200/35 focus:border-cyan-300 focus:outline-none touch-manipulation"
                            style="font-family: 'Rajdhani', sans-serif;"
                        >
                        <div class="mt-2 grid grid-cols-2 gap-2">
                            <button
                                type="button"
                                wire:click="adjust('currentRuns', -1)"
                                class="touch-manipulation rounded-xl border border-cyan-100/25 bg-slate-950/80 px-3 py-3 text-sm font-semibold uppercase tracking-wide text-cyan-100 transition active:scale-[0.98]"
                                style="font-family: 'Rajdhani', sans-serif;"
                            >
                                -1 Run
                            </button>
                            <button
                                type="button"
                                wire:click="adjust('currentRuns', 1)"
                                class="touch-manipulation rounded-xl border border-cyan-300/40 bg-cyan-400/10 px-3 py-3 text-sm font-semibold uppercase tracking-wide text-cyan-100 transition active:scale-[0.98]"
                                style="font-family: 'Rajdhani', sans-serif;"
                            >
                                +1 Run
                            </button>
                        </div>
                    </label>

                    <label class="block">
                        <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Wickets Lost</span>
                        <input
                            type="number"
                            min="0"
                            max="10"
                            wire:model.live="wickets"
                            class="h-14 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-4 text-[clamp(1rem,4.3vw,1.2rem)] text-cyan-50 placeholder:text-cyan-200/35 focus:border-cyan-300 focus:outline-none touch-manipulation"
                            style="font-family: 'Rajdhani', sans-serif;"
                        >
                        <div class="mt-2 grid grid-cols-2 gap-2">
                            <button
                                type="button"
                                wire:click="adjust('wickets', -1)"
                                class="touch-manipulation rounded-xl border border-cyan-100/25 bg-slate-950/80 px-3 py-3 text-sm font-semibold uppercase tracking-wide text-cyan-100 transition active:scale-[0.98]"
                                style="font-family: 'Rajdhani', sans-serif;"
                            >
                                -1 Wicket
                            </button>
                            <button
                                type="button"
                                wire:click="adjust('wickets', 1)"
                                class="touch-manipulation rounded-xl border border-cyan-300/40 bg-cyan-400/10 px-3 py-3 text-sm font-semibold uppercase tracking-wide text-cyan-100 transition active:scale-[0.98]"
                                style="font-family: 'Rajdhani', sans-serif;"
                            >
                                +1 Wicket
                            </button>
                        </div>
                    </label>

                    <label class="block">
                        <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Overs Done</span>
                        <input
                            type="text"
                            inputmode="decimal"
                            placeholder="12.3"
                            wire:model.live="oversDone"
                            class="h-14 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-4 text-[clamp(1rem,4.3vw,1.2rem)] text-cyan-50 placeholder:text-cyan-200/35 focus:border-cyan-300 focus:outline-none touch-manipulation"
                            style="font-family: 'Rajdhani', sans-serif;"
                        >
                    </label>

                    <label class="block">
                        <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Total Overs</span>
                        <input
                            type="text"
                            inputmode="decimal"
                            placeholder="20.0"
                            wire:model.live="totalOvers"
                            class="h-14 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-4 text-[clamp(1rem,4.3vw,1.2rem)] text-cyan-50 placeholder:text-cyan-200/35 focus:border-cyan-300 focus:outline-none touch-manipulation"
                            style="font-family: 'Rajdhani', sans-serif;"
                        >
                    </label>

                    <label class="block sm:col-span-2">
                        <span class="mb-1 block text-xs font-semibold uppercase tracking-widest text-cyan-200/80">Original Target Score</span>
                        <input
                            type="number"
                            min="0"
                            wire:model.live="targetScore"
                            class="h-14 w-full rounded-xl border border-cyan-100/25 bg-slate-950/70 px-4 text-[clamp(1rem,4.3vw,1.2rem)] text-cyan-50 placeholder:text-cyan-200/35 focus:border-cyan-300 focus:outline-none touch-manipulation"
                            style="font-family: 'Rajdhani', sans-serif;"
                        >
                        <div class="mt-2 grid grid-cols-2 gap-2">
                            <button
                                type="button"
                                wire:click="adjust('targetScore', -5)"
                                class="touch-manipulation rounded-xl border border-cyan-100/25 bg-slate-950/80 px-3 py-3 text-sm font-semibold uppercase tracking-wide text-cyan-100 transition active:scale-[0.98]"
                                style="font-family: 'Rajdhani', sans-serif;"
                            >
                                -5 Target
                            </button>
                            <button
                                type="button"
                                wire:click="adjust('targetScore', 5)"
                                class="touch-manipulation rounded-xl border border-cyan-300/40 bg-cyan-400/10 px-3 py-3 text-sm font-semibold uppercase tracking-wide text-cyan-100 transition active:scale-[0.98]"
                                style="font-family: 'Rajdhani', sans-serif;"
                            >
                                +5 Target
                            </button>
                        </div>
                    </label>
                </div>

                <div class="mt-4 grid grid-cols-1 gap-2 sm:mt-5 sm:grid-cols-2">
                    <button
                        type="button"
                        wire:click="loadSampleT20"
                        class="touch-manipulation rounded-xl border border-emerald-300/40 bg-emerald-400/20 px-4 py-3.5 text-base font-semibold uppercase tracking-wider text-emerald-100 transition active:scale-[0.98]"
                        style="font-family: 'Rajdhani', sans-serif;"
                    >
                        Load Sample Match
                    </button>
                    <button
                        type="button"
                        wire:click="resetCalculator"
                        class="touch-manipulation rounded-xl border border-rose-300/40 bg-rose-400/20 px-4 py-3.5 text-base font-semibold uppercase tracking-wider text-rose-100 transition active:scale-[0.98]"
                        style="font-family: 'Rajdhani', sans-serif;"
                    >
                        Reset Calculator
                    </button>
                </div>
            </section>

            <section class="theme-panel rounded-2xl border border-amber-300/25 bg-slate-900/80 p-4 shadow-2xl backdrop-blur-sm sm:p-6">
                <h2 class="mb-4 flex items-center gap-2 text-[clamp(1.1rem,4.5vw,1.35rem)] text-amber-100 sm:mb-5" style="font-family: 'Rajdhani', sans-serif;">
                    <i class="fa-solid fa-table-list text-amber-300"></i>
                    Scoreboard
                </h2>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-1">
                    <article class="rounded-xl border border-amber-300/20 bg-slate-950/75 p-4 shadow-[inset_0_0_0_1px_rgba(253,224,71,0.08)]">
                        <p class="text-xs uppercase tracking-[0.2em] text-amber-200/75">Overs Remaining</p>
                        <p class="mt-1 flex items-center gap-2 text-[clamp(1.9rem,8.8vw,2.45rem)] leading-none text-lime-300" style="font-family: 'Bebas Neue', cursive;">
                            <i class="fa-regular fa-clock text-lg"></i>
                            {{ number_format($this->oversRemaining(), 1) }}
                        </p>
                    </article>

                    <article class="rounded-xl border border-amber-300/20 bg-slate-950/75 p-4 shadow-[inset_0_0_0_1px_rgba(253,224,71,0.08)]">
                        <p class="text-xs uppercase tracking-[0.2em] text-amber-200/75">Runs Remaining</p>
                        <p class="mt-1 flex items-center gap-2 text-[clamp(1.9rem,8.8vw,2.45rem)] leading-none text-lime-300" style="font-family: 'Bebas Neue', cursive;">
                            <i class="fa-solid fa-baseball text-lg"></i>
                            {{ $this->runsRemaining() }}
                        </p>
                    </article>

                    <article class="rounded-xl border border-amber-300/20 bg-slate-950/75 p-4 shadow-[inset_0_0_0_1px_rgba(253,224,71,0.08)]">
                        <p class="text-xs uppercase tracking-[0.2em] text-amber-200/75">Required Run Rate</p>
                        <p class="mt-1 flex items-center gap-2 text-[clamp(1.9rem,8.8vw,2.45rem)] leading-none text-lime-300" style="font-family: 'Bebas Neue', cursive;">
                            <i class="fa-solid fa-gauge-high text-lg"></i>
                            {{ number_format($this->requiredRunRate(), 2) }}
                        </p>
                    </article>

                    <article class="rounded-xl border border-amber-300/20 bg-slate-950/75 p-4 shadow-[inset_0_0_0_1px_rgba(253,224,71,0.08)]">
                        <p class="text-xs uppercase tracking-[0.2em] text-amber-200/75">Resource %</p>
                        <p class="mt-1 flex items-center gap-2 text-[clamp(1.9rem,8.8vw,2.45rem)] leading-none text-lime-300" style="font-family: 'Bebas Neue', cursive;">
                            <i class="fa-solid fa-chart-pie text-lg"></i>
                            {{ number_format($this->resourcePercentage(), 2) }}%
                        </p>
                    </article>

                    <article class="rounded-xl border border-emerald-300/30 bg-emerald-950/70 p-4 shadow-[inset_0_0_0_1px_rgba(74,222,128,0.15)] sm:col-span-2 lg:col-span-1">
                        <div class="flex items-center gap-2 text-emerald-100">
                            <i class="fa-solid fa-bullseye"></i>
                            <p class="text-xs uppercase tracking-[0.2em]">Adjusted Target</p>
                        </div>
                        <p class="mt-2 text-[clamp(2.2rem,10vw,3rem)] leading-none text-emerald-300" style="font-family: 'Bebas Neue', cursive;">{{ $this->adjustedTarget() }}</p>
                    </article>
                </div>
            </section>
        </div>
    </div>
</div>
