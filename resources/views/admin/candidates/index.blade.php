<x-admin>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-tactical-text flex items-center">
                <i class="fas fa-user-plus text-tactical-accent mr-3"></i>
                Gestión de Reclutas
            </h2>
            <p class="text-sm text-tactical-text/60 mt-1">Administra los reclutas y sus estados</p>
        </div>
        <a href="{{ route('admin.candidates.create') }}" class="inline-flex items-center px-4 py-2.5 bg-tactical-accent hover:bg-tactical-accent/90 border border-transparent rounded-md font-semibold text-xs text-tactical-bg uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-tactical-accent focus:ring-offset-2 focus:ring-offset-tactical-surface transition-all duration-200">
            <i class="fas fa-plus mr-2"></i> Nuevo Recluta
        </a>
    </div>

    <div class="tactical-card overflow-hidden border border-tactical-border/50">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-tactical-border/30">
                <thead class="bg-tactical-surface/30">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-tactical-text/70 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-user-tag mr-2 text-tactical-accent/80"></i>
                                Nombre
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-tactical-text/70 uppercase tracking-wider">
                            <i class="fas fa-envelope mr-2 text-tactical-accent/80"></i>
                            Correo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-tactical-text/70 uppercase tracking-wider">
                            <i class="far fa-calendar-alt mr-2 text-tactical-accent/80"></i>
                            Fecha de Registro
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-tactical-text/70 uppercase tracking-wider">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-tactical-border/20">
                    @forelse($candidates as $candidate)
                        <tr class="hover:bg-tactical-surface/30 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-tactical-accent/20 flex items-center justify-center text-tactical-accent font-medium">
                                        {{ strtoupper(substr($candidate->first_name, 0, 1)) }}{{ strtoupper(substr($candidate->last_name, 0, 1)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-tactical-text">{{ $candidate->first_name }} {{ $candidate->last_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-tactical-text/90">
                                <div class="flex items-center">
                                    <i class="far fa-envelope mr-2 text-tactical-text/40"></i>
                                    {{ $candidate->email }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-tactical-text/70">
                                <div class="flex items-center">
                                    <i class="far fa-calendar-alt mr-2 text-tactical-text/40"></i>
                                    {{ $candidate->created_at->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-3">
                                    <a 
                                        href="{{ route('admin.candidates.edit', $candidate) }}" 
                                        class="text-tactical-text/60 hover:text-tactical-accent transition-colors duration-150"
                                        data-tooltip="Editar"
                                    >
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este recluta?');">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="text-tactical-text/60 hover:text-red-500 transition-colors duration-150"
                                            data-tooltip="Eliminar"
                                        >
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-tactical-text/50">
                                    <i class="fas fa-user-slash text-4xl mb-3"></i>
                                    <p class="text-lg font-medium">No se encontraron reclutas</p>
                                    <p class="text-sm mt-1">Comienza agregando un nuevo recluta</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-tactical-surface/30 px-4 py-3 flex items-center justify-between border-t border-tactical-border/30">
            <div class="flex-1 flex justify-between sm:hidden">
                {{ $candidates->onEachSide(1)->links('pagination::simple-tailwind') }}
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-tactical-text/70">
                        Mostrando
                        <span class="font-medium text-tactical-text">{{ $candidates->firstItem() }}</span>
                        a
                        <span class="font-medium text-tactical-text">{{ $candidates->lastItem() }}</span>
                        de
                        <span class="font-medium text-tactical-text">{{ $candidates->total() }}</span>
                        resultados
                    </p>
                </div>
                <div class="ml-4">
                    {{ $candidates->onEachSide(1)->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-admin>
