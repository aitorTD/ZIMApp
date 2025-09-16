@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="bg-tactical-surface/70 border border-tactical-border/50 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-tactical-border/30 bg-tactical-surface/50">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-tactical-text">Añadir Nuevo Recluta</h2>
                <a href="{{ route('dashboard') }}" class="text-tactical-text/60 hover:text-tactical-accent transition-colors">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </div>
        
        <div class="p-6">
            <form action="{{ route('candidates.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-tactical-text/80 mb-1">Nombre</label>
                        <input type="text" name="first_name" id="first_name" required
                            class="w-full bg-tactical-surface/80 border-tactical-border rounded-md shadow-sm focus:ring-tactical-accent focus:border-tactical-accent text-tactical-text"
                            value="{{ old('first_name') }}">
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-tactical-text/80 mb-1">Apellidos</label>
                        <input type="text" name="last_name" id="last_name" required
                            class="w-full bg-tactical-surface/80 border-tactical-border rounded-md shadow-sm focus:ring-tactical-accent focus:border-tactical-accent text-tactical-text"
                            value="{{ old('last_name') }}">
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-tactical-text/80 mb-1">Correo Electrónico</label>
                        <input type="email" name="email" id="email" required
                            class="w-full bg-tactical-surface/80 border-tactical-border rounded-md shadow-sm focus:ring-tactical-accent focus:border-tactical-accent text-tactical-text"
                            value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-tactical-text/80 mb-1">Teléfono</label>
                        <input type="tel" name="phone" id="phone"
                            class="w-full bg-tactical-surface/80 border-tactical-border rounded-md shadow-sm focus:ring-tactical-accent focus:border-tactical-accent text-tactical-text"
                            value="{{ old('phone') }}">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-tactical-border/30">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-tactical-border rounded-md text-sm font-medium text-tactical-text/80 hover:bg-tactical-surface/50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 bg-tactical-accent/90 hover:bg-tactical-accent border border-tactical-accent/70 rounded-md text-sm font-medium text-white transition-colors">
                        <i class="fas fa-save mr-1"></i> Guardar Recluta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
