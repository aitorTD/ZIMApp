<x-admin>
    <div class="tactical-card overflow-hidden border border-tactical-border/50">
        <!-- Header -->
        <div class="px-6 py-5 border-b border-tactical-border/30">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div>
                    <h2 class="text-2xl font-bold text-tactical-text flex items-center">
                        <i class="fas fa-users text-tactical-accent mr-3"></i>
                        Gestión del Escuadrón
                    </h2>
                    <p class="text-sm text-tactical-text/60 mt-1">Administra los miembros del escuadrón</p>
                </div>
                <a href="{{ route('admin.members.create') }}" class="inline-flex items-center px-4 py-2.5 bg-tactical-accent hover:bg-tactical-accent/90 border border-transparent rounded-md font-semibold text-xs text-tactical-bg uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-tactical-accent focus:ring-offset-2 focus:ring-offset-tactical-surface transition-all duration-200 mt-4 sm:mt-0">
                    <i class="fas fa-plus mr-2"></i> Nuevo Miembro
                </a>
            </div>
        </div>


        <!-- Members Table -->
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
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-tactical-text/70 uppercase tracking-wider">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-tactical-border/20">
                    @forelse($members as $member)
                    <tr class="hover:bg-tactical-surface/20 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-tactical-accent/20 flex items-center justify-center text-tactical-accent font-medium">
                                    {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-tactical-text">{{ $member->first_name }} {{ $member->last_name }}</div>
                                    <div class="text-xs text-tactical-text/60">Miembro desde {{ $member->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-tactical-text/90">
                            <div class="flex items-center">
                                <i class="far fa-envelope mr-2 text-tactical-text/40"></i>
                                {{ $member->email }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-3">
                                <a 
                                    href="{{ route('admin.members.edit', $member) }}" 
                                    class="text-tactical-text/60 hover:text-tactical-accent transition-colors duration-150"
                                    data-tooltip="Editar"
                                >
                                    <i class="far fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.members.destroy', $member) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este miembro?');">
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
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-tactical-text/90">
                            No se encontraron miembros.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($members->hasPages())
        <div class="bg-tactical-surface/30 px-4 py-3 flex items-center justify-between border-t border-tactical-border/30">
            <div class="flex-1 flex justify-between sm:hidden">
                {{ $members->onEachSide(1)->links('pagination::simple-tailwind') }}
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-tactical-text/70">
                        Mostrando
                        <span class="font-medium text-tactical-text">{{ $members->firstItem() }}</span>
                        a
                        <span class="font-medium text-tactical-text">{{ $members->lastItem() }}</span>
                        de
                        <span class="font-medium text-tactical-text">{{ $members->total() }}</span>
                        resultados
                    </p>
                </div>
                <div class="ml-4">
                    {{ $members->onEachSide(1)->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</x-admin>
