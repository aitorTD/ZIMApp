<x-admin>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-light text-tactical-text/90">
                    <span class="font-medium">Panel de Control</span>
                </h1>
                <p class="mt-1 text-sm text-tactical-text/60">
                    Resumen general y estadísticas de la operación
                </p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Members Card -->
            <div class="bg-tactical-surface/50 backdrop-blur-sm rounded-xl border border-tactical-border/20 p-6 hover:border-tactical-accent/30 transition-colors duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-tactical-text/70 uppercase tracking-wider mb-1">Escuadrón</p>
                        <div class="flex items-baseline">
                            <p class="text-3xl font-bold text-tactical-text">{{ $membersCount }}</p>
                            <span class="ml-2 text-sm font-medium text-tactical-accent/90">
                                <i class="fas fa-check-circle mr-1"></i> Activos
                            </span>
                        </div>
                    </div>
                    <div class="h-12 w-12 rounded-lg bg-tactical-accent/10 flex items-center justify-center">
                        <i class="fas fa-users text-tactical-accent text-xl"></i>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.members.index') }}" class="inline-flex items-center text-sm font-medium text-tactical-accent hover:text-tactical-accent/80 transition-colors">
                        Ver todo el escuadrón
                        <i class="fas fa-arrow-right ml-1.5 text-xs mt-0.5"></i>
                    </a>
                </div>
            </div>

            <!-- Candidates Card -->
            <div class="bg-tactical-surface/50 backdrop-blur-sm rounded-xl border border-tactical-border/20 p-6 hover:border-green-500/30 transition-colors duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-tactical-text/70 uppercase tracking-wider mb-1">Reclutas</p>
                        <div class="flex items-baseline">
                            <p class="text-3xl font-bold text-tactical-text">{{ $candidatesCount }}</p>
                            <span class="ml-2 text-sm font-medium text-green-400/90">
                                <i class="fas fa-user-plus mr-1"></i> En Proceso
                            </span>
                        </div>
                    </div>
                    <div class="h-12 w-12 rounded-lg bg-green-500/10 flex items-center justify-center">
                        <i class="fas fa-user-graduate text-green-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.candidates.index') }}" class="inline-flex items-center text-sm font-medium text-green-400 hover:text-green-300 transition-colors">
                        Ver todos los reclutas
                        <i class="fas fa-arrow-right ml-1.5 text-xs mt-0.5"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8">
            <h2 class="text-lg font-light text-tactical-text/90 flex items-center mb-4">
                <i class="fas fa-bolt text-tactical-accent mr-2"></i>
                <span>Acciones Rápidas</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.members.create') }}" class="bg-tactical-surface/50 backdrop-blur-sm rounded-lg border border-tactical-border/20 p-4 hover:border-tactical-accent/30 transition-colors duration-300 group">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-lg bg-tactical-accent/10 flex items-center justify-center mr-3 group-hover:bg-tactical-accent/20 transition-colors">
                            <i class="fas fa-user-plus text-tactical-accent"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-tactical-text">Nuevo Miembro</h3>
                            <p class="text-xs text-tactical-text/60">Añadir al escuadrón</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('admin.candidates.create') }}" class="bg-tactical-surface/50 backdrop-blur-sm rounded-lg border border-tactical-border/20 p-4 hover:border-green-500/30 transition-colors duration-300 group">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-lg bg-green-500/10 flex items-center justify-center mr-3 group-hover:bg-green-500/20 transition-colors">
                            <i class="fas fa-user-edit text-green-400"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-tactical-text">Nuevo Recluta</h3>
                            <p class="text-xs text-tactical-text/60">Iniciar proceso</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-admin>
