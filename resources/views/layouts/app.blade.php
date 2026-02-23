<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="description" content="Cricket DLS Pro is a mobile-friendly Duckworth-Lewis calculator for revised targets, required run rate, and match resource tracking.">
        <meta name="keywords" content="Cricket DLS Pro, DLS calculator, Duckworth Lewis, cricket target calculator, required run rate">
        <meta name="author" content="Cricket DLS Pro">
        <meta name="robots" content="index, follow">
        <meta name="application-name" content="Cricket DLS Pro">
        <meta name="theme-color" content="#0f172a">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="Cricket DLS Pro">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Cricket DLS Pro">
        <meta property="og:title" content="{{ $title ?? 'Cricket DLS Pro' }}">
        <meta property="og:description" content="Cricket DLS Pro helps you quickly calculate revised DLS targets and required run rate.">
        <meta property="og:image" content="{{ asset('icons/icon-512.png') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $title ?? 'Cricket DLS Pro' }}">
        <meta name="twitter:description" content="Quick DLS target and required run-rate calculator for cricket matches.">
        <meta name="twitter:image" content="{{ asset('icons/icon-512.png') }}">

        <title>{{ isset($title) ? $title . ' | Cricket DLS Pro' : 'Cricket DLS Pro' }}</title>

        <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
        <link rel="canonical" href="{{ url()->current() }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/icon-192.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/icon-192.png') }}">
        <link rel="shortcut icon" href="{{ asset('icons/icon-192.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('icons/apple-touch-icon.png') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script>
            (function () {
                const saved = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = saved ? saved === 'dark' : prefersDark;
                document.documentElement.classList.toggle('dark', isDark);
                document.documentElement.classList.toggle('theme-light', !isDark);
            })();
        </script>
        <style>
            .theme-light .cricket-theme .theme-overlay {
                background-image: linear-gradient(180deg, rgba(241, 245, 249, 0.58) 0%, rgba(226, 232, 240, 0.75) 40%, rgba(220, 252, 231, 0.82) 100%);
            }

            .theme-light .cricket-theme .theme-panel,
            .theme-light .cricket-theme .bg-slate-950\/70,
            .theme-light .cricket-theme .bg-slate-950\/75,
            .theme-light .cricket-theme .bg-slate-950\/80 {
                background-color: rgba(255, 255, 255, 0.88);
            }

            .theme-light .cricket-theme .text-cyan-50,
            .theme-light .cricket-theme .text-cyan-100,
            .theme-light .cricket-theme .text-amber-100,
            .theme-light .cricket-theme .text-emerald-100,
            .theme-light .cricket-theme .text-white {
                color: rgb(15 23 42);
            }

            .theme-light .cricket-theme .text-lime-300 {
                color: rgb(22 101 52);
            }

            .theme-light .cricket-theme .text-emerald-300 {
                color: rgb(21 128 61);
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
        <button
            id="theme-toggle"
            type="button"
            class="fixed right-3 top-3 z-50 inline-flex h-12 w-12 items-center justify-center rounded-full border border-slate-300/70 bg-white/90 text-slate-700 shadow-lg backdrop-blur transition hover:scale-105 dark:border-slate-700 dark:bg-slate-900/90 dark:text-slate-100"
            aria-label="Toggle dark mode"
            title="Toggle dark mode"
        >
            <i id="theme-toggle-icon" class="fa-solid fa-moon"></i>
        </button>

        <main>
            @yield('content')
        </main>

        @livewireScripts
    </body>
</html>
