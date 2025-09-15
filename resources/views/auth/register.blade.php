<x-auth-layout>
    <div class="max-w-md w-full mx-auto px-4 py-8">
        <div class="card p-8 relative overflow-hidden">
            <!-- Tactical background elements -->
            <div class="absolute inset-0 -z-10 opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDQwIDQwIj48cGF0dGVybiBpZD0icGF0dGVybiIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIiBwYXR0ZXJuVHJhbnNmb3JtPSJyb3RhdGUoNDUpIHNjYWxlKDAuNSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0iIzE2MTYxYSIvPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgeD0iMjAiIHk9IjAiIGZpbGw9IiMxNjE2MWEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjcGF0dGVybikiLz48L3N2Zz4=');"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-tactical-primary/5 to-transparent"></div>
            </div>
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-tactical-primary/10 flex items-center justify-center">
                    <i class="fas fa-user-plus text-2xl text-tactical-accent"></i>
                </div>
                <h2 class="text-2xl font-orbitron font-bold text-tactical-text">OPERATOR REGISTRATION</h2>
                <p class="text-tactical-text/70 mt-1">Join the ZIMA tactical network</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- First Name -->
                <div class="space-y-2">
                    <label for="first_name" class="input-label">
                        <i class="fas fa-id-card mr-2"></i>First Name
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-tactical-text/50"></i>
                        </div>
                        <input id="first_name" class="input-field pl-10" type="text" name="first_name" 
                               value="{{ old('first_name') }}" required autofocus autocomplete="given-name" 
                               placeholder="Operator's first name">
                    </div>
                    @error('first_name')
                        <p class="text-tactical-accent/80 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="space-y-2">
                    <label for="last_name" class="input-label">
                        <i class="fas fa-id-card mr-2"></i>Last Name
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user-tag text-tactical-text/50"></i>
                        </div>
                        <input id="last_name" class="input-field pl-10" type="text" name="last_name" 
                               value="{{ old('last_name') }}" required autocomplete="family-name" 
                               placeholder="Operator's last name">
                    </div>
                    @error('last_name')
                        <p class="text-tactical-accent/80 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="input-label">
                        <i class="fas fa-envelope mr-2"></i>Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-at text-tactical-text/50"></i>
                        </div>
                        <input id="email" class="input-field pl-10" type="email" name="email" 
                               value="{{ old('email') }}" required autocomplete="email" 
                               placeholder="operator@zima.ops">
                    </div>
                    @error('email')
                        <p class="text-tactical-accent/80 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="input-label">
                        <i class="fas fa-key mr-2"></i>Access Code
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-tactical-text/50"></i>
                        </div>
                        <input id="password" class="input-field pl-10" type="password" name="password" 
                               required autocomplete="new-password" placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="text-tactical-accent/80 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="input-label">
                        <i class="fas fa-shield-alt mr-2"></i>Confirm Access Code
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-tactical-text/50"></i>
                        </div>
                        <input id="password_confirmation" class="input-field pl-10" type="password" 
                               name="password_confirmation" required autocomplete="new-password" 
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-primary w-full flex items-center justify-center py-2.5">
                        <i class="fas fa-user-plus mr-2"></i> COMPLETE REGISTRATION
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-tactical-border text-center">
                <p class="text-sm text-tactical-text/70">
                    Already have an operator account? 
                    <a href="{{ route('login') }}" class="font-medium text-tactical-primary hover:text-tactical-accent transition-colors">
                        Authenticate Here
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-auth-layout>
