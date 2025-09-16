<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Reclutas Patrocinados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <a href="{{ route('sponsor.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Patrocinar Nuevo Recluta') }}
                        </a>
                    </div>

                    @if($candidates->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notas</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($candidates as $candidate)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $candidate->first_name }} {{ $candidate->last_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $candidate->email }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $candidate->pivot->status === 'active' ? 'bg-green-100 text-green-800' : 
                                                       ($candidate->pivot->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($candidate->pivot->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $candidate->pivot->notes ?? 'No notes' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button onclick="event.preventDefault(); 
                                                    if(confirm('Are you sure you want to remove this sponsorship?')) { 
                                                        document.getElementById('delete-form-{{ $candidate->pivot->id }}').submit(); 
                                                    }" 
                                                    class="text-red-600 hover:text-red-900">
                                                    {{ __('Ver') }}
                                                </button>
                                                <form id="delete-form-{{ $candidate->pivot->id }}" 
                                                    action="{{ route('sponsor.destroy', $candidate->pivot->id) }}" 
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <p>{{ __('No se encontraron reclutas.') }}</p>
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('You are not sponsoring any candidates yet.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
