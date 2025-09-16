@props(['candidate' => null])

<div class="space-y-6">
    <div class="bg-tactical-surface/30 border border-tactical-border/30 rounded-lg p-6">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label for="first_name" class="block text-sm font-medium text-tactical-text/80">
                        <i class="fas fa-id-card mr-2 text-tactical-accent/80"></i>
                        Nombre
                    </label>
                    <input type="text" 
                           name="first_name" 
                           id="first_name" 
                           value="{{ old('first_name', $candidate?->first_name) }}" 
                           required
                           class="mt-1 block w-full bg-tactical-surface/50 border-tactical-border/50 text-tactical-text rounded-md shadow-sm focus:ring-tactical-accent focus:border-tactical-accent sm:text-sm">
                </div>

                <div class="space-y-1">
                    <label for="last_name" class="block text-sm font-medium text-tactical-text/80">
                        <i class="fas fa-id-card mr-2 text-tactical-accent/80"></i>
                        Apellidos
                    </label>
                    <input type="text" 
                           name="last_name" 
                           id="last_name" 
                           value="{{ old('last_name', $candidate?->last_name) }}" 
                           required
                           class="mt-1 block w-full bg-tactical-surface/50 border-tactical-border/50 text-tactical-text rounded-md shadow-sm focus:ring-tactical-accent focus:border-tactical-accent sm:text-sm">
                </div>

                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-tactical-text/80">
                        <i class="fas fa-envelope mr-2 text-tactical-accent/80"></i>
                        Correo Electrónico
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $candidate?->email) }}" 
                           required
                           class="mt-1 block w-full bg-tactical-surface/50 border-tactical-border/50 text-tactical-text rounded-md shadow-sm focus:ring-tactical-accent focus:border-tactical-accent sm:text-sm">
                </div>

                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-tactical-text/80">
                        <i class="fas fa-lock mr-2 text-tactical-accent/80"></i>
                        {{ $candidate ? 'Nueva Contraseña' : 'Contraseña' }}
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           {{ $candidate ? '' : 'required' }}
                           class="mt-1 block w-full bg-tactical-surface/50 border-tactical-border/50 text-tactical-text rounded-md shadow-sm focus:ring-tactical-accent focus:border-tactical-accent sm:text-sm">
                </div>

                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-sm font-medium text-tactical-text/80">
                        <i class="fas fa-check-circle mr-2 text-tactical-accent/80"></i>
                        {{ $candidate ? 'Confirmar Nueva Contraseña' : 'Confirmar Contraseña' }}
                    </label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           {{ $candidate ? '' : 'required' }}
                           class="mt-1 block w-full bg-tactical-surface/50 border-tactical-border/50 text-tactical-text rounded-md shadow-sm focus:ring-tactical-accent focus:border-tactical-accent sm:text-sm">
                </div>

                @if($candidate)
                <div class="space-y-1">
                    <label for="status" class="block text-sm font-medium text-tactical-text/80">
                        <i class="fas fa-flag mr-2 text-tactical-accent/80"></i>
                        Estado
                    </label>
                    <select id="status" 
                            name="status" 
                            required
                            class="mt-1 block w-full bg-tactical-surface/50 border-tactical-border/50 text-tactical-text rounded-md shadow-sm focus:ring-tactical-accent focus:border-tactical-accent sm:text-sm">
                        <option value="pending" {{ old('status', $candidate->status) === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="accepted" {{ old('status', $candidate->status) === 'accepted' ? 'selected' : '' }}>Aceptado</option>
                        <option value="rejected" {{ old('status', $candidate->status) === 'rejected' ? 'selected' : '' }}>Rechazado</option>
                    </select>
                </div>
                @else
                    <input type="hidden" name="status" value="pending">
                @endif
            </div>
        </div>
    </div>

    <div class="flex justify-end space-x-3 pt-4 border-t border-tactical-border/30">
        <a href="{{ route('admin.candidates.index') }}" class="px-4 py-2 border border-tactical-border/50 bg-tactical-surface/50 text-tactical-text/80 rounded-md text-sm font-medium hover:bg-tactical-surface/70 transition-colors duration-200">
            <i class="fas fa-times mr-2"></i>Cancelar
        </a>
        <button type="submit" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-tactical-bg bg-tactical-accent hover:bg-tactical-accent/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tactical-accent/50 transition-colors duration-200">
            <i class="fas fa-{{ $candidate ? 'save' : 'plus' }} mr-2"></i>{{ $candidate ? 'Actualizar' : 'Crear' }} Recluta
        </button>
    </div>
</div>
