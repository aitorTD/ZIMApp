<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ZIMA Airsoft') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/military.css'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="bg-military-darker shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="flex items-center">
                            <svg class="h-8 w-8 text-military-tan" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"></path>
                                <path fill-rule="evenodd" d="M10 14a4 4 0 100-8 4 4 0 000 8zm0-2a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-2 text-xl font-bold text-military-tan">ZIMA</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-grow flex items-center justify-center bg-military-darker bg-opacity-90">
            {{ $slot }}
        </main>

        <footer class="bg-military-darker text-military-light py-4 text-center text-sm">
            &copy; {{ date('Y') }} ZIMA Airsoft Club. All rights reserved.
        </footer>
    </div>
</body>
</html>
