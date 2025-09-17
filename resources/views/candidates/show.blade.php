<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Datos del Recluta - ZIMA</title>

    <!-- Preload Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet"></noscript>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    <link rel="alternate icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="mask-icon" href="{{ asset('images/logo.svg') }}" color="#ffffff">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/fonts.css'])
    <style>
        .tactical-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.03) 0%, transparent 15%),
                radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.03) 0%, transparent 15%);
            z-index: 1;
            pointer-events: none;
        }
        .bg-tactical-pattern {
            background: #1a1a1a;
        }
    </style>
</head>
<body class="bg-tactical-bg text-tactical-text font-sans antialiased min-h-screen">
    <div class="min-h-screen bg-tactical-pattern bg-cover bg-center bg-fixed relative">
        <div class="tactical-overlay"></div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 relative z-10">
            <!-- Header -->
            <header class="mb-10">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <a href="{{ route('dashboard') }}" class="group inline-flex items-center text-tactical-text/80 hover:text-tactical-text transition-colors">
                        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-0.5 transition-transform"></i>
                        <span class="text-sm font-medium">Volver al Cuadro de Mando</span>
                    </a>
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo.svg') }}" alt="ZIMA Logo" class="h-6 w-auto" style="filter: brightness(0) invert(1);">
                        <span class="font-iori text-xl font-bold text-tactical-text tracking-wider opacity-90">ZIMA</span>
                    </div>
                </div>
                <h1 class="mt-8 text-2xl md:text-3xl font-light text-tactical-text/90">
                    <span class="font-medium">{{ $candidate->first_name }} {{ $candidate->last_name }}</span>
                    <span class="ml-3 inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium {{ [
                        'pending' => 'bg-yellow-500/20 text-yellow-400',
                        'accepted' => 'bg-green-500/20 text-green-400',
                        'rejected' => 'bg-red-500/20 text-red-400',
                        'default' => 'bg-gray-500/20 text-gray-400'
                    ][strtolower($candidate->status)] ?? 'bg-gray-500/20 text-gray-400' }}">
                        {{ [
                            'pending' => 'Pendiente',
                            'accepted' => 'Aceptado',
                            'rejected' => 'Rechazado',
                            'default' => ucfirst($candidate->status)
                        ][strtolower($candidate->status)] ?? ucfirst($candidate->status) }}
                    </span>
                </h1>
                <p class="mt-1 text-sm text-tactical-text/60">
                    ID: {{ $candidate->id }} • Última actualización: {{ $candidate->updated_at->diffForHumans() }}
                </p>
            </header>
            
            <!-- Candidate Info -->
            <div class="bg-tactical-surface/40 backdrop-blur-sm rounded-xl overflow-hidden mb-8">
                <div class="p-6">
                    <div class="mb-6">
                        <h2 class="text-sm font-medium text-tactical-text/70 uppercase tracking-wider mb-4 flex items-center">
                            <i class="fas fa-id-card text-tactical-accent mr-2"></i>
                            <span>Datos Personales</span>
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-tactical-text/50 uppercase tracking-wider">Nombre Completo</p>
                                <p class="text-tactical-text/90">{{ $candidate->first_name }} {{ $candidate->last_name }}</p>
                            </div>
                            @if($candidate->email)
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-tactical-text/50 uppercase tracking-wider">Correo Electrónico</p>
                                <a href="mailto:{{ $candidate->email }}" class="text-tactical-accent hover:underline">{{ $candidate->email }}</a>
                            </div>
                            @endif
                            @if($candidate->phone)
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-tactical-text/50 uppercase tracking-wider">Teléfono</p>
                                <a href="tel:{{ $candidate->phone }}" class="text-tactical-text/90 hover:underline">{{ $candidate->phone }}</a>
                            </div>
                            @endif
                            @if($candidate->date_of_birth)
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-tactical-text/50 uppercase tracking-wider">Fecha de Nacimiento</p>
                                <p class="text-tactical-text/90">{{ $candidate->date_of_birth->format('d/m/Y') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if($candidate->address || $candidate->city || $candidate->country || $candidate->postal_code)
                    <div class="pt-6 border-t border-tactical-border/10">
                        <h3 class="text-sm font-medium text-tactical-text/70 uppercase tracking-wider mb-4 flex items-center">
                            <i class="fas fa-map-marker-alt text-tactical-accent mr-2"></i>
                            <span>Dirección</span>
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @if($candidate->address)
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-tactical-text/50 uppercase tracking-wider">Dirección</p>
                                <p class="text-tactical-text/90">{{ $candidate->address }}</p>
                            </div>
                            @endif
                            @if($candidate->city)
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-tactical-text/50 uppercase tracking-wider">Ciudad</p>
                                <p class="text-tactical-text/90">{{ $candidate->city }}</p>
                            </div>
                            @endif
                            @if($candidate->country)
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-tactical-text/50 uppercase tracking-wider">País</p>
                                <p class="text-tactical-text/90">{{ $candidate->country }}</p>
                            </div>
                            @endif
                            @if($candidate->postal_code)
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-tactical-text/50 uppercase tracking-wider">Código Postal</p>
                                <p class="text-tactical-text/90">{{ $candidate->postal_code }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Notes Section -->
            <div class="mb-10">
                <h2 class="text-lg font-light text-tactical-text/90 flex items-center mb-4">
                    <i class="fas fa-clipboard-list text-tactical-accent mr-2"></i>
                    <span>Informes y Notas</span>
                </h2>

                <div class="space-y-4">
                    <x-candidate-notes 
                        :candidate="$candidate" 
                        :notes="$candidate->notes ?? collect()" 
                        :skipEmptyState="true"
                    >
                        <div class="bg-tactical-surface/30 rounded-xl p-8 text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-tactical-surface/50 mb-3">
                                <i class="fas fa-clipboard text-tactical-text/50 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-tactical-text/90 mb-1">No hay notas disponibles</h3>
                            <p class="text-tactical-text/60 text-sm max-w-md mx-auto">
                                Añade la primera nota para este recluta haciendo clic en el botón "Nueva Nota"
                            </p>
                        </div>
                    </x-candidate-notes>
                </div>
            </div>

            <!-- Footer -->
            <div class="pt-6 border-t border-tactical-border/10 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
                <p class="text-sm text-tactical-text/50">
                    ZIMA • {{ now()->format('Y') }}
                </p>
                @can('update', $candidate)
                <div class="flex space-x-3">
                    <a href="{{ route('candidates.edit', $candidate) }}" 
                       class="inline-flex items-center px-4 py-2 border border-tactical-border/30 rounded-md text-sm font-medium text-tactical-text/80 hover:bg-tactical-surface/50 hover:text-tactical-text transition-colors">
                        <i class="fas fa-edit mr-2"></i>Editar Recluta
                    </a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</body>
</html>
