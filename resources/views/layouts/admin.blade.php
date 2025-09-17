<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ZIMA') }} - Mando Central</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    
    <style>
        body {
            background-color: #0a0f1f;
            color: #e0e0e0;
        }
        .tactical-nav {
            background: linear-gradient(90deg, #0a0f1f 0%, #131b33 100%);
            border-bottom: 1px solid rgba(30, 77, 140, 0.5);
        }
        .tactical-card {
            background: rgba(19, 27, 51, 0.7);
            border: 1px solid rgba(30, 77, 140, 0.5);
            border-radius: 0.5rem;
            box-shadow: 0 0 15px rgba(226, 176, 7, 0.3);
        }
        .tactical-btn {
            background: #e2b007;
            color: #0a0f1f;
            transition: all 0.3s ease;
        }
        .tactical-btn:hover {
            background: #f0c14b;
            transform: translateY(-1px);
        }
        .tactical-nav-link {
            color: #a0a0a0;
            transition: all 0.3s ease;
        }
        .tactical-nav-link:hover, .tactical-nav-link.active {
            color: #e2b007;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="tactical-nav shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="font-orbitron font-bold text-xl text-tactical-accent">
                            <i class="fas fa-shield-alt mr-2"></i> Mando Central
                        </a>
                        <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                            <a href="{{ route('dashboard') }}" class="tactical-nav-link {{ request()->routeIs('dashboard') ? 'text-tactical-accent' : '' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                            </a>
                            <a href="{{ route('admin.members.index') }}" class="tactical-nav-link {{ request()->routeIs('admin.members*') ? 'text-tactical-accent' : '' }} inline-flex items-center px-1 pt-1 text-sm font-medium ml-6">
                                <i class="fas fa-users mr-1"></i> Escuadrón
                            </a>
                            <a href="{{ route('admin.candidates.index') }}" class="tactical-nav-link {{ request()->routeIs('admin.candidates*') ? 'text-tactical-accent' : '' }} inline-flex items-center px-1 pt-1 text-sm font-medium ml-6">
                                <i class="fas fa-user-plus mr-1"></i> Reclutamiento
                            </a>
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-tactical-accent">
                                <div class="h-8 w-8 rounded-full bg-tactical-accent/90 flex items-center justify-center text-tactical-bg font-medium">
                                    {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
                                </div>
                                <span class="ml-2 text-tactical-text font-medium">{{ Auth::user()->first_name }}</span>
                                <i class="fas fa-chevron-down ml-1 text-xs text-tactical-text/60"></i>
                            </button>
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-tactical-surface border border-tactical-border/50 py-1 z-10"
                                 style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-tactical-text hover:bg-tactical-accent/10">
                                    <i class="fas fa-user-circle mr-2 w-4 text-center"></i> Perfil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-tactical-text hover:bg-tactical-accent/10">
                                        <i class="fas fa-sign-out-alt mr-2 w-4 text-center"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-tactical-text/80 hover:text-tactical-accent hover:bg-tactical-surface/50 focus:outline-none focus:ring-2 focus:ring-tactical-accent">
                            <span class="sr-only">Menú principal</span>
                            <svg class="block h-6 w-6" :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="h-6 w-6" :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div x-show="mobileMenuOpen" class="sm:hidden bg-tactical-surface/90 border-t border-tactical-border/50" id="mobile-menu">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-base font-medium {{ request()->routeIs('dashboard') ? 'text-tactical-accent bg-tactical-accent/10' : 'text-tactical-text/80 hover:bg-tactical-accent/10' }}">
                        <i class="fas fa-tachometer-alt w-6 text-center mr-2"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="flex items-center px-4 py-3 text-base font-medium {{ request()->routeIs('admin.members*') ? 'text-tactical-accent bg-tactical-accent/10' : 'text-tactical-text/80 hover:bg-tactical-accent/10' }}">
                        <i class="fas fa-users w-6 text-center mr-2"></i> Escuadrón
                    </a>
                    <a href="{{ route('admin.candidates.index') }}" class="flex items-center px-4 py-3 text-base font-medium {{ request()->routeIs('admin.candidates*') ? 'text-tactical-accent bg-tactical-accent/10' : 'text-tactical-text/80 hover:bg-tactical-accent/10' }}">
                        <i class="fas fa-user-plus w-6 text-center mr-2"></i> Reclutamiento
                    </a>
                </div>
                <div class="pt-4 pb-3 border-t border-tactical-border/50">
                    <div class="flex items-center px-4">
                        <div class="h-10 w-10 rounded-full bg-tactical-accent/90 flex items-center justify-center text-tactical-bg font-medium">
                            {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-tactical-text">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                            <div class="text-sm font-medium text-tactical-text/60">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-base font-medium text-tactical-text/80 hover:bg-tactical-accent/10">
                            <i class="fas fa-user-circle w-6 text-center mr-2"></i> Tu perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full text-left px-4 py-3 text-base font-medium text-tactical-text/80 hover:bg-tactical-accent/10">
                                <i class="fas fa-sign-out-alt w-6 text-center mr-2"></i> Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1 py-6 px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-md bg-green-900/30 border border-green-800 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-100">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-md bg-red-900/30 border border-red-800 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-100">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Se encontraron {{ $errors->count() }} {{ Str::plural('error', $errors->count()) }} al enviar el formulario
                            </h3>
                            <div class="mt-2 text-sm text-red-200">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="tactical-card p-6">
                {{ $slot }}
            </div>
        </main>
    </div>

    @stack('scripts')
    <script>
        // Initialize Alpine.js for mobile menu
        document.addEventListener('alpine:init', () => {
            Alpine.data('app', () => ({
                mobileMenuOpen: false
            }));
        });
    </script>
</body>
</html>
