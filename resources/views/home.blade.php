@extends('layouts.app')

@section('content')
    @php($activeTab = $activeTab ?? 'dls')
    <div class="fixed left-1/2 top-4 z-40 w-[calc(100%-1.5rem)] max-w-3xl -translate-x-1/2">
        <nav class="rounded-xl border border-cyan-100/25 bg-slate-900/80 p-2 shadow-2xl backdrop-blur-sm">
            <div class="grid grid-cols-3 gap-2 text-center text-xs font-semibold uppercase tracking-wider sm:text-sm">
                <a href="{{ route('dls.calculator') }}" class="rounded-lg px-2 py-3 {{ $activeTab === 'dls' ? 'bg-cyan-500/25 text-cyan-100 border border-cyan-300/40' : 'bg-slate-950/70 text-cyan-200 border border-cyan-100/20' }}">
                    DLS Calculator
                </a>
                <a href="{{ route('nrr.calculator') }}" class="rounded-lg px-2 py-3 {{ $activeTab === 'nrr' ? 'bg-cyan-500/25 text-cyan-100 border border-cyan-300/40' : 'bg-slate-950/70 text-cyan-200 border border-cyan-100/20' }}">
                    NRR Calculator
                </a>
                <a href="{{ route('nrr.predictor') }}" class="rounded-lg px-2 py-3 {{ $activeTab === 'nrr-predictor' ? 'bg-cyan-500/25 text-cyan-100 border border-cyan-300/40' : 'bg-slate-950/70 text-cyan-200 border border-cyan-100/20' }}">
                    NRR Predictor
                </a>
            </div>
        </nav>
    </div>

    <div class="pt-20">
        @if($activeTab === 'nrr')
            <livewire:nrr-calculator />
        @elseif($activeTab === 'nrr-predictor')
            <livewire:nrr-predictor />
        @else
            <livewire:dls-calculator />
        @endif
    </div>
@endsection
