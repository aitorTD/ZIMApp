<x-auth-layout>
    <div class="max-w-md w-full mx-auto px-4 py-8">
        <div class="bg-tactical-surface/80 backdrop-blur-sm border border-tactical-border rounded-xl shadow-xl p-8 relative overflow-hidden">
            <!-- Tactical background elements -->
            <div class="absolute inset-0 -z-10 opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDQwIDQwIj48cGF0dGVybiBpZD0icGF0dGVybiIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIiBwYXR0ZXJuVHJhbnNmb3JtPSJyb3RhdGUoNDUpIHNjYWxlKDAuNSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0iIzE2MTYxYSIvPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgeD0iMjAiIHk9IjAiIGZpbGw9IiMxNjE2MWEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjcGF0dGVybikiLz48L3N2Zz4=');"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-tactical-primary/5 to-transparent"></div>
            </div>
            
            <!-- Header with ZIMA Logo -->
            <div class="text-center mb-8">
                <div class="logo-container flex flex-col items-center mb-6">
                    <img 
                        src="{{ asset('images/logo.svg') }}" 
                        alt="ZIMA Logo" 
                        class="logo-header"
                        style="height: 6rem; width: auto; max-width: 90%; filter: brightness(0) invert(1);"
                    >
                </div>
                <h2 class="text-2xl font-orbitron font-bold text-tactical-text mt-4">ACCESO DE OPERADOR</h2>
                <p class="text-tactical-text/70 mt-1">Accede al puesto de mando táctico</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Nickname -->
                <div class="space-y-2">
                    <label for="nickname" class="input-label">
                        <i class="fas fa-user-secret mr-2"></i>Nickname
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user-tag text-tactical-text/50"></i>
                        </div>
                        <input id="nickname" class="input-field pl-10" type="text" name="nickname" value="{{ old('nickname') }}" 
                               required autofocus autocomplete="username" placeholder="nickname">
                    </div>
                    @error('nickname')
                        <p class="text-tactical-accent/80 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-tactical-text/50"></i>
                        </div>
                        <input id="password" class="input-field pl-10" type="password" name="password" 
                               required autocomplete="current-password" placeholder="••••••••">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-tactical-text/50 hover:text-tactical-text/70" 
                                onclick="this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password'">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-tactical-accent/80 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                    @enderror
                    
                    <div class="flex items-center justify-between pt-2">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-tactical-border text-tactical-primary focus:ring-tactical-accent" name="remember">
                            <span class="ml-2 text-sm text-tactical-text/80">Recordar este dispositivo</span>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-primary w-full flex items-center justify-center py-2.5">
                        <i class="fas fa-fingerprint mr-2"></i> Autenticar
                    </button>
                </div>
            </form>

            @can('register-candidate')
                <div class="mt-6 pt-6 border-t border-tactical-border text-center">
                    <p class="text-sm text-tactical-text/70">
                        ¿Deseas registrar un nuevo recluta?
                        <a href="{{ route('candidates.register') }}" class="font-medium text-tactical-primary hover:text-tactical-accent transition-colors">
                            Registrar Recluta
                        </a>
                    </p>
                </div>
            @endcan
        </div>
    </div>
</x-auth-layout>
