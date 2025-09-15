@extends('layouts.app')

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                const expanded = this.getAttribute('aria-expanded') === 'true' || false;
                this.setAttribute('aria-expanded', !expanded);
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>
@endpush

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg mb-8 rounded-b-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="flex items-center">
                            <!-- Logo container (empty) -->
                        </div>
                    </div>
                    <div class="hidden sm:ml-10 sm:flex sm:space-x-6">
                        <a href="{{ route('dashboard') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                            <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="#" class="text-blue-100 hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                            <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Evaluaciones
                        </a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                    <div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                        <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-800 focus:ring-white transition-colors duration-150" :class="{ 'bg-blue-700': open }">
                            <div class="h-9 w-9 rounded-full bg-blue-700 flex items-center justify-center text-white font-medium">
                                {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                            </div>
                            <span class="ml-2 text-white font-medium">{{ $user->first_name }}</span>
                            <svg class="ml-1 h-4 w-4 text-blue-200 transition-transform duration-200 transform" :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1 z-10"
                             style="display: none;">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                <i class="fas fa-user mr-2 w-4 text-center"></i>Tu perfil
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                <i class="fas fa-cog mr-2 w-4 text-center"></i>Configuración
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                    <i class="fas fa-sign-out-alt mr-2 w-4 text-center"></i>Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Mobile menu button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-blue-200 hover:text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition-colors duration-200" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Abrir menú</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden hidden bg-blue-700" id="mobile-menu">
            <div class="pt-2 pb-3 space-y-1 px-2">
                <a href="{{ route('dashboard') }}" class="bg-blue-800 text-white group flex items-center px-3 py-2 rounded-md text-base font-medium">
                    <svg class="h-5 w-5 mr-3 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="#" class="text-blue-100 hover:bg-blue-600 group flex items-center px-3 py-2 rounded-md text-base font-medium">
                    <svg class="h-5 w-5 mr-3 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Evaluaciones
                </a>
            </div>
            <div class="pt-4 pb-3 border-t border-blue-800">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-medium">
                            {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-white">{{ $user->first_name }} {{ $user->last_name }}</div>
                        <div class="text-sm font-medium text-blue-200">{{ $user->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-blue-100 hover:text-white hover:bg-blue-600">
                        <svg class="inline-block h-5 w-5 mr-2 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Tu perfil
                    </a>
                    <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-blue-100 hover:text-white hover:bg-blue-600">
                        <svg class="inline-block h-5 w-5 mr-2 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Configuración
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-blue-100 hover:text-white hover:bg-blue-600">
                            <svg class="inline-block h-5 w-5 mr-2 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-light text-white">Hola, {{ $user->first_name }}</h1>
        <p class="text-gray-300 text-sm mt-1">
            {{ $user->roles->isNotEmpty() ? ucfirst($user->roles->first()->name) : 'Sin rol asignado' }}
        </p>
    </div>

    @if($user->hasRole('member'))
    <!-- Add Candidate Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-8 overflow-hidden">
        <div class="p-6">
            <form action="{{ route('candidates.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1">
                        <label for="first_name" class="text-sm text-gray-600">Nombre</label>
                        <input type="text" name="first_name" id="first_name" required
                               class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:border-gray-400">
                    </div>
                    <div class="space-y-1">
                        <label for="last_name" class="text-sm text-gray-600">Apellidos</label>
                        <input type="text" name="last_name" id="last_name" required
                               class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:border-gray-400">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1">
                        <label for="email" class="text-sm text-gray-600">Correo Electrónico</label>
                        <input type="email" name="email" id="email" required
                               class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:border-gray-400">
                    </div>
                    <div class="space-y-1">
                        <label for="phone" class="text-sm text-gray-600">Teléfono</label>
                        <input type="tel" name="phone" id="phone"
                               class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:border-gray-400">
                    </div>
                </div>
                <div class="space-y-1">
                    <label for="notes" class="text-sm text-gray-600">Notas</label>
                    <textarea name="notes" id="notes" rows="2"
                             class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:border-gray-400"></textarea>
                </div>
                <div class="pt-2">
                    <button type="submit"
                            class="w-full md:w-auto px-6 py-2 bg-black text-white text-sm font-medium rounded hover:bg-gray-800 transition-colors">
                        Añadir Candidato
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Candidates List -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-medium text-gray-900">Candidatos</h2>
                <span class="text-sm text-gray-500">{{ count($candidates) }} total</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="relative px-4 py-3">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($candidates as $candidate)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">
                                        {{ $candidate->first_name }} {{ $candidate->last_name }}
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $candidate->email }}</div>
                                    @if($candidate->phone)
                                        <div class="text-sm text-gray-500">{{ $candidate->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">
                                    No hay candidatos registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
