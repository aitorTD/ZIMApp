<nav x-data="{ open: false }" class="bg-tactical-surface/80 backdrop-blur-sm border-b border-tactical-border shadow-lg fixed w-full z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                        <div class="h-10 w-10 rounded-full bg-tactical-primary/10 flex items-center justify-center group-hover:bg-tactical-primary/20 transition-colors duration-300">
                            <x-application-logo class="h-6 w-6 text-tactical-accent" />
                        </div>
                        <span class="font-orbitron text-xl font-bold text-tactical-accent tracking-wider">ZIMA</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-tactical-primary/10 hover:text-tactical-accent transition-colors duration-200">
                        <i class="fas fa-tachometer-alt mr-2"></i>{{ __('Dashboard') }}
                    </x-nav-link>
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-tactical-primary/10 hover:text-tactical-accent transition-colors duration-200">
                                <i class="fas fa-users-cog mr-2"></i>{{ __('Manage Users') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-tactical-border rounded-md text-sm font-medium text-tactical-text hover:bg-tactical-primary/10 hover:text-tactical-accent focus:outline-none transition duration-150 ease-in-out">
                            <div class="flex items-center">
                                <span class="mr-2">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content" class="bg-tactical-surface border border-tactical-border rounded-md shadow-lg py-1">
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center px-4 py-2 text-sm text-tactical-text hover:bg-tactical-primary/10 hover:text-tactical-accent">
                            <i class="fas fa-user-cog mr-2"></i>{{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="flex items-center px-4 py-2 text-sm text-tactical-text hover:bg-tactical-primary/10 hover:text-tactical-accent">
                                <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-tactical-text hover:text-tactical-accent hover:bg-tactical-primary/10 focus:outline-none transition duration-150 ease-in-out">
                    <i class="fas fa-bars text-xl" x-show="!open"></i>
                    <i class="fas fa-times text-xl" x-show="open" style="display: none;"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" @click.away="open = false" class="sm:hidden bg-tactical-surface/95 backdrop-blur-sm border-t border-tactical-border">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="block px-4 py-2 text-base font-medium hover:bg-tactical-primary/10 hover:text-tactical-accent">
                <i class="fas fa-tachometer-alt mr-2"></i>{{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="block px-4 py-2 text-base font-medium hover:bg-tactical-primary/10 hover:text-tactical-accent">
                        <i class="fas fa-users-cog mr-2"></i>{{ __('Manage Users') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Mobile Settings -->
        <div class="pt-4 pb-3 border-t border-tactical-border">
            <div class="px-4">
                <div class="text-base font-medium text-tactical-text">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-tactical-text/70">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="block px-4 py-2 text-base font-medium hover:bg-tactical-primary/10 hover:text-tactical-accent">
                    <i class="fas fa-user-cog mr-2"></i>{{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="block px-4 py-2 text-base font-medium hover:bg-tactical-primary/10 hover:text-tactical-accent">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
