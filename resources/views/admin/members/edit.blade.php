<x-admin>
    <form action="{{ route('admin.members.update', $user) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-tactical-text flex items-center">
                    <i class="fas fa-user-edit text-tactical-accent mr-3"></i>
                    Editar Operador: {{ $user->full_name }}
                </h2>
                <p class="text-sm text-tactical-text/60 mt-1">Actualiza la información del operador y sus roles.</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.members.index') }}" class="inline-flex items-center px-4 py-2 border border-tactical-border/50 bg-tactical-surface/50 hover:bg-tactical-surface/70 text-tactical-text rounded-md font-medium text-sm transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-tactical-accent hover:bg-tactical-accent/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tactical-accent transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i> Guardar Cambios
                </button>
            </div>
        </div>

        @include('admin.members.form', ['member' => $user, 'roles' => $roles])
    </form>
</x-admin>
