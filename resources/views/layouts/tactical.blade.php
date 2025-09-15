<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Airsoft ZIMA' }}</title>

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
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-tactical-surface/90 backdrop-blur-sm border-b border-tactical-border shadow-lg sticky top-0 z-50">
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
                    
                    <div class="hidden md:flex items-center space-x-6">
                        @if (isset($header))
                            {{ $header }}
                        @else
                            <div class="flex items-center space-x-1">
                                <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-tactical-accent' : 'text-tactical-text/80 hover:text-tactical-accent' }}">
                                    Panel
                                </a>
                                @can('viewAny', App\Models\User::class)
                                <a href="{{ route('admin.users.index') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'text-tactical-accent' : 'text-tactical-text/80 hover:text-tactical-accent' }}">
                                    Usuarios
                                </a>
                                @endcan
                            </div>
                            
                            <div class="flex items-center ml-6">
                                <div class="relative">
                                    <button class="flex items-center space-x-2 focus:outline-none">
                                        <div class="h-8 w-8 rounded-full bg-tactical-primary/10 flex items-center justify-center">
                                            <i class="fas fa-user text-tactical-accent"></i>
                                        </div>
                                        <span class="text-sm font-medium text-tactical-text/80">
                                            {{ Auth::user()->first_name }}
                                        </span>
                                        <i class="fas fa-chevron-down text-xs text-tactical-text/50"></i>
                                    </button>
                                    
                                    <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-tactical-surface/95 backdrop-blur-sm border border-tactical-border py-1 z-50 hidden group-hover:block">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-tactical-text/80 hover:bg-tactical-primary/10 hover:text-tactical-accent">
                                                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="-mr-2 flex items-center md:hidden">
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-tactical-text/80 hover:text-tactical-accent focus:outline-none">
                            <i class="fas fa-bars" x-show="!open"></i>
                            <i class="fas fa-times" x-show="open"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div class="md:hidden" x-show="open" @click.away="open = false">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium {{ request()->routeIs('dashboard') ? 'bg-tactical-primary/10 text-tactical-accent' : 'text-tactical-text/80 hover:bg-tactical-primary/10 hover:text-tactical-accent' }}">
                        Panel
                    </a>
                    @can('viewAny', App\Models\User::class)
                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-base font-medium {{ request()->routeIs('admin.users.*') ? 'bg-tactical-primary/10 text-tactical-accent' : 'text-tactical-text/80 hover:bg-tactical-primary/10 hover:text-tactical-accent' }}">
                        Usuarios
                    </a>
                    @endcan
                </div>
                <div class="pt-4 pb-3 border-t border-tactical-border">
                    <div class="flex items-center px-4">
                        <div class="h-10 w-10 rounded-full bg-tactical-primary/10 flex items-center justify-center">
                            <i class="fas fa-user text-tactical-accent"></i>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-tactical-text">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-tactical-text/60">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-tactical-text/80 hover:bg-tactical-primary/10 hover:text-tactical-accent">
                                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-tactical-surface/80 backdrop-blur-sm border-t border-tactical-border mt-12">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-tactical-text/60">
                    &copy; {{ date('Y') }} Airsoft ZIMA. Todos los derechos reservados.
                </p>
            </div>
        </footer>
    </div>

    @vite('resources/js/app.js')
    @stack('scripts')
    
    <script>
        // Mobile menu toggle
        document.addEventListener('alpine:init', () => {
            Alpine.data('mobileMenu', () => ({
                open: false,
                toggle() {
                    this.open = !this.open;
                }
            }));
        });
    </script>
</body>
</html>
