@props([
    'member' => new \App\Models\User(),
    'roles' => []
])

<div class="space-y-8">
    <!-- Información del Operador -->
    <div class="bg-tactical-surface/30 rounded-lg border border-tactical-border/30 overflow-hidden">
        <div class="px-6 py-4 border-b border-tactical-border/30 bg-tactical-surface/50">
            <h3 class="text-lg font-medium text-tactical-text flex items-center">
                <i class="fas fa-id-card text-tactical-accent mr-2"></i>
                Información del Operador
            </h3>
            <p class="mt-1 text-sm text-tactical-text/60">Datos básicos del nuevo miembro del escuadrón.</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div class="space-y-1">
                    <label for="first_name" class="block text-sm font-medium text-tactical-text/90">
                        <i class="fas fa-user mr-1 text-tactical-accent/80"></i>
                        Nombre
                    </label>
                    <div class="mt-1">
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $member?->first_name) }}" required
                            class="block w-full rounded-md border-tactical-border/50 bg-tactical-surface/80 text-tactical-text placeholder-tactical-text/70 focus:ring-tactical-accent/50 focus:border-tactical-accent/50 sm:text-sm text-gray-900"
                            placeholder="Nombre">
                    </div>
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nickname -->
                <div class="space-y-1">
                    <label for="nickname" class="block text-sm font-medium text-tactical-text/90">
                        <i class="fas fa-user-secret mr-1 text-tactical-accent/80"></i>
                        Nickname
                    </label>
                    <div class="mt-1">
                        <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $member?->nickname) }}" required
                            class="block w-full rounded-md border-tactical-border/50 bg-tactical-surface/80 text-tactical-text placeholder-tactical-text/70 focus:ring-tactical-accent/50 focus:border-tactical-accent/50 sm:text-sm text-gray-900"
                            placeholder="Nickname">
                        <p class="mt-1 text-xs text-tactical-text/60">Tu alias en el campo de batalla</p>
                    </div>
                    @error('nickname')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-tactical-text/90">
                        <i class="fas fa-envelope mr-1 text-tactical-accent/80"></i>
                        Correo Electrónico
                    </label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" value="{{ old('email', $member?->email) }}" required
                            class="block w-full rounded-md border-tactical-border/50 bg-tactical-surface/80 text-tactical-text placeholder-tactical-text/70 focus:ring-tactical-accent/50 focus:border-tactical-accent/50 sm:text-sm text-gray-900"
                            placeholder="operador@ejemplo.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-tactical-text/90">
                        <i class="fas fa-key mr-1 text-tactical-accent/80"></i>
                        {{ $member ? 'Nueva Contraseña' : 'Contraseña' }}
                    </label>
                    <div class="mt-1">
                        <input type="password" name="password" id="password" {{ $member ? '' : 'required' }}
                            class="block w-full rounded-md border-tactical-border/50 bg-tactical-surface/80 text-tactical-text placeholder-tactical-text/70 focus:ring-tactical-accent/50 focus:border-tactical-accent/50 sm:text-sm text-gray-900"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-sm font-medium text-tactical-text/90">
                        <i class="fas fa-check-double mr-1 text-tactical-accent/80"></i>
                        Confirmar Contraseña
                    </label>
                    <div class="mt-1">
                        <input type="password" name="password_confirmation" id="password_confirmation" {{ $member ? '' : 'required' }}
                            class="block w-full rounded-md border-tactical-border/50 bg-tactical-surface/80 text-tactical-text placeholder-tactical-text/70 focus:ring-tactical-accent/50 focus:border-tactical-accent/50 sm:text-sm text-gray-900"
                            placeholder="••••••••">
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Roles y Permisos -->
    <div class="bg-tactical-surface/30 rounded-lg border border-tactical-border/30 overflow-hidden">
        <div class="px-6 py-4 border-b border-tactical-border/30 bg-tactical-surface/50">
            <h3 class="text-lg font-medium text-tactical-text flex items-center">
                <i class="fas fa-user-shield text-tactical-accent mr-2"></i>
                Roles y Permisos
            </h3>
            <p class="mt-1 text-sm text-tactical-text/60">Asigna los roles correspondientes al operador.</p>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($roles as $role)
                    <div class="flex items-start p-3 rounded-md hover:bg-tactical-surface/50 transition-colors duration-150">
                        <div class="flex items-center h-5 mt-0.5">
                            <input id="role-{{ $role->id }}" name="roles[]" type="checkbox" value="{{ $role->id }}"
                                {{ in_array($role->id, old('roles', $member ? $member->roles->pluck('id')->toArray() : [])) ? 'checked' : '' }}
                                class="h-4 w-4 text-tactical-accent border-tactical-border/50 rounded focus:ring-tactical-accent/50">
                        </div>
                        <div class="ml-3">
                            <label for="role-{{ $role->id }}" class="block text-sm font-medium text-tactical-text/90">
                                {{ ucfirst($role->name) }}
                            </label>
                            @if($role->description)
                                <p class="text-xs text-tactical-text/60 mt-0.5">{{ $role->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            @error('roles')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
