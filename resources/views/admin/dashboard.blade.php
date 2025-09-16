<x-admin>
    <div class="min-h-[calc(100vh-8rem)] flex flex-col">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 flex-grow">
        <!-- Members Card -->
        <div class="tactical-card overflow-hidden border-t-4 border-tactical-accent hover:shadow-lg transition-all duration-300 hover:border-opacity-80 flex flex-col h-full">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-tactical-accent/90 rounded-md p-3 shadow-lg">
                        <i class="fas fa-users text-tactical-bg text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-tactical-text/70 uppercase tracking-wider">Escuadrón</dt>
                            <dd class="flex items-baseline">
                                <div class="text-3xl font-bold text-tactical-text">{{ $membersCount }}</div>
                                <div class="ml-3 text-sm font-medium text-tactical-accent">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-tactical-accent/20 text-tactical-accent">
                                        <i class="fas fa-check-circle mr-1"></i> Activos
                                    </span>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-5">
                    <a href="{{ route('admin.members.index') }}" class="inline-flex items-center text-sm font-medium text-tactical-accent hover:text-tactical-accent/80 transition-colors duration-200">
                        Ver todo el escuadrón
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Candidates Card -->
        <div class="tactical-card overflow-hidden border-t-4 border-green-500/80 hover:shadow-lg transition-all duration-300 hover:border-opacity-80 flex flex-col h-full">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500/90 rounded-md p-3 shadow-lg">
                        <i class="fas fa-user-graduate text-tactical-bg text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-tactical-text/70 uppercase tracking-wider">Reclutas</dt>
                            <dd class="flex items-baseline">
                                <div class="text-3xl font-bold text-tactical-text">{{ $candidatesCount }}</div>
                                <div class="ml-3 text-sm font-medium text-green-400">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                        <i class="fas fa-user-plus mr-1"></i> En Proceso
                                    </span>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-5">
                    <a href="{{ route('admin.candidates.index') }}" class="inline-flex items-center text-sm font-medium text-green-400 hover:text-green-300 transition-colors duration-200">
                        Ver todos los reclutas
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</x-admin>
