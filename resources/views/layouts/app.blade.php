<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Airsoft ZIMA') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/tactical.css', 'resources/js/app.js'])
        
        @stack('styles')
    </head>
    <body class="min-h-screen flex flex-col bg-tactical-bg text-tactical-text">
        <div class="tactical-overlay flex-1 flex flex-col">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="flex-1">
                @yield('content')
            </main>

            @hasSection('sidebar')
                <aside class="lg:w-64 flex-shrink-0">
                    @yield('sidebar')
                </aside>
            @endif
        </div>

        @stack('modals')
        @stack('scripts')
    </body>
</html>
