<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'ZIMA Airsoft Club' }}</title>

    <!-- Preload Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet"></noscript>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/tactical.css'])
    @stack('styles')
</head>
<body class="min-h-screen bg-tactical-bg text-tactical-text font-sans antialiased">
    <div class="min-h-screen flex flex-col bg-tactical-pattern">
        <!-- Navigation -->
        <nav class="bg-tactical-surface/80 backdrop-blur-sm border-b border-tactical-border shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="flex items-center space-x-2 group">
                            <div class="h-10 w-10 rounded-full bg-tactical-primary/10 flex items-center justify-center group-hover:bg-tactical-primary/20 transition-all duration-300">
                                <x-application-logo class="h-5 w-5 text-tactical-accent" />
                            </div>
                            <span class="font-orbitron text-xl font-bold text-tactical-accent tracking-wider">ZIMA</span>
                        </a>
                    </div>
                    @auth
                    <div class="flex items-center">
                        <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                            @csrf
                            <button type="submit" class="text-tactical-text/60 hover:text-tactical-accent transition-colors duration-200 p-2" title="Cerrar sesión">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="flex-grow flex items-center justify-center p-4">
            {{ $slot }}
        </main>

        <footer class="bg-military-darker text-military-light py-4 text-center text-sm">
            &copy; {{ date('Y') }} ZIMA Airsoft Club. All rights reserved.
        </footer>
    </div>
</body>
</html>
