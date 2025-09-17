<x-admin>
    <div class="tactical-card overflow-hidden border border-tactical-border/50">
        <form action="{{ route('admin.members.store') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Header -->
            <div class="px-6 py-5 border-b border-tactical-border/30">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-tactical-text flex items-center">
                            <i class="fas fa-user-plus text-tactical-accent mr-3"></i>
                            Nuevo Miembro del Escuadrón
                        </h2>
                        <p class="text-sm text-tactical-text/60 mt-1">Registra un nuevo operador en el sistema</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.members.index') }}" class="inline-flex items-center px-4 py-2 border border-tactical-border rounded-md shadow-sm text-sm font-medium text-tactical-text bg-tactical-surface hover:bg-tactical-surface/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tactical-accent/50 transition-all duration-150">
                            <i class="fas fa-arrow-left mr-2"></i> Volver
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-tactical-accent hover:bg-tactical-accent/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tactical-accent transition-all duration-150">
                            <i class="fas fa-save mr-2"></i> Guardar Operador
                        </button>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="px-6 pb-6">
                @include('admin.members.form', ['roles' => $roles])
            </div>
        </form>
    </div>
</x-admin>
