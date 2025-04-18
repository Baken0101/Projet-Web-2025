<!DOCTYPE html>
<html lang="fr" class="h-full" data-theme="true" data-theme-mode="light">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="follow, index">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- CSRF token for AJAX requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Coding Tool Box')</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('media/icon.png') }}"/>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>

    {{-- Metronic styles --}}
    <link rel="stylesheet" href="{{ asset('metronic/vendors/apexcharts/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('metronic/vendors/keenicons/styles.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('metronic/css/styles.css') }}">

    {{-- Your app.css compiled by Laravel Mix --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    {{-- Alpine.js (deferred) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased flex h-full text-base text-gray-700
             bg-[--tw-page-bg:#F6F6F9] dark:bg-[--tw-page-bg-dark:var(--tw-coal-200)]
             [--tw-content-bg:var(--tw-light)] dark:[--tw-content-bg-dark:var(--tw-coal-500)]
             [--tw-content-scrollbar-color:#e8e8e8]
             [--tw-header-height:60px] [--tw-sidebar-width:270px]
             lg:overflow-hidden">

{{-- Theme Mode Script --}}
<script>
    const defaultThemeMode = 'light'; // light|dark|system
    let themeMode = localStorage.getItem('theme')
        || document.documentElement.getAttribute('data-theme-mode')
        || defaultThemeMode;

    if (themeMode === 'system') {
        themeMode = window.matchMedia('(prefers-color-scheme: dark)')
            .matches ? 'dark' : 'light';
    }
    document.documentElement.classList.add(themeMode);
</script>
{{-- End Theme Mode --}}

<div class="flex grow">
    {{-- Header component --}}
    <x-main.header />

    <div class="flex flex-col lg:flex-row grow pt-[--tw-header-height] lg:pt-0">
        {{-- Sidebar component --}}
        <x-main.sidebar />

        {{-- Main content wrapper --}}
        <div class="flex flex-col grow items-stretch rounded-xl
                            bg-[--tw-content-bg] dark:bg-[--tw-content-bg-dark]
                            border border-gray-300 dark:border-gray-200
                            lg:ms-[--tw-sidebar-width] mt-0 lg:mt-[15px] m-[15px]">

            <div class="flex flex-col grow lg:scrollable-y-auto
                                lg:[scrollbar-width:auto]
                                lg:light:[--tw-scrollbar-thumb-color:var(--tw-content-scrollbar-color)]
                                pt-5" id="scrollable_content">

                <main class="grow" role="content">
                    {{-- Toolbar --}}
                    <div class="pb-5">
                        <div class="container-fixed flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center flex-wrap gap-1 lg:gap-5">
                                {{-- Page header passed via @section('header') --}}
                                {!! $header ?? '' !!}
                            </div>
                        </div>
                    </div>

                    {{-- Page content passed via @section('content') --}}
                    <div class="container-fixed">
                        {!! $slot ?? '' !!}
                    </div>
                </main>
            </div>

            {{-- Footer component --}}
            <x-main.footer />
        </div>
    </div>
</div>

{{-- Metronic core scripts --}}
<script src="{{ asset('metronic/js/core.bundle.js') }}"></script>
<script src="{{ asset('metronic/vendors/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('metronic/js/widgets/general.js') }}"></script>

{{-- Your app.js compiled by Laravel Mix (deferred) --}}
<script src="{{ mix('js/app.js') }}" defer></script>

{{-- Stack for page-specific scripts (@push('scripts')) --}}
@stack('scripts')
</body>
</html>
