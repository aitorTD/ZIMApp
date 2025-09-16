<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patrocinar Nuevo Recluta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('error'))
                        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sponsor.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-label for="candidate_id" :value="__('Seleccionar Recluta')" />
                            <select id="candidate_id" name="candidate_id" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">-- Seleccionar Recluta --</option>
                                @foreach($candidates as $candidate)
                                    <option value="{{ $candidate->id }}">
                                        {{ $candidate->first_name }} {{ $candidate->last_name }} ({{ $candidate->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('candidate_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-label for="notes" :value="__('Notas (Opcional)')" />
                            <textarea id="notes" name="notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('sponsor.my-candidates') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Patrocinar Recluta') }}
                            </a>
                            <x-button>
                                {{ __('Send Sponsorship Request') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
