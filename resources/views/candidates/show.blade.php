<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del Recluta - ZIMA</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-tactical-surface { background-color: #1a202c; }
        .bg-tactical-surface\/50 { background-color: rgba(26, 32, 44, 0.5); }
        .bg-tactical-surface\/80 { background-color: rgba(26, 32, 44, 0.8); }
        .bg-tactical-surface\/30 { background-color: rgba(26, 32, 44, 0.3); }
        .border-tactical-border { border-color: #2d3748; }
        .border-tactical-border\/50 { border-color: rgba(45, 55, 72, 0.5); }
        .text-tactical-text { color: #e2e8f0; }
        .text-tactical-text\/50 { color: rgba(226, 232, 240, 0.5); }
        .text-tactical-text\/70 { color: rgba(226, 232, 240, 0.7); }
        .text-tactical-text\/80 { color: rgba(226, 232, 240, 0.8); }
        .text-tactical-accent { color: #4299e1; }
        .border-tactical-accent { border-color: #4299e1; }
        .bg-tactical-accent { background-color: #4299e1; }
        .bg-tactical-accent\/90 { background-color: rgba(66, 153, 225, 0.9); }
        .hover\:bg-tactical-accent:hover { background-color: #3182ce; }
        .focus\:ring-tactical-accent:focus { --tw-ring-color: rgba(66, 153, 225, 0.5); }
        .focus\:border-tactical-accent:focus { border-color: #4299e1; }
    </style>
</head>
<body class="bg-tactical-surface text-tactical-text min-h-screen">
    <div class="min-h-screen bg-tactical-pattern bg-cover bg-center bg-fixed">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-tactical-surface/50 border border-tactical-border rounded-md font-medium text-sm text-tactical-text/80 hover:bg-tactical-surface/70 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tactical-accent transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Volver al Cuadro de Mando
                </a>
            </div>
            
            <!-- Candidate Info -->
            <div class="bg-tactical-surface/50 border border-tactical-border rounded-lg overflow-hidden mb-4 shadow-lg">
                <div class="px-4 py-3 sm:px-5 border-b border-tactical-border/30">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div class="mb-1 sm:mb-0">
                            <div class="flex items-center">
                                <h3 class="text-lg leading-5 font-medium text-tactical-text">
                                    <i class="fas fa-user-secret text-tactical-accent mr-2"></i>Informe de Recluta
                                </h3>
                                @php
                                    $statusStyles = [
                                        'pending' => 'bg-yellow-500/90 text-white border-yellow-500',
                                        'accepted' => 'bg-green-500/90 text-white border-green-500',
                                        'rejected' => 'bg-red-500/90 text-white border-red-500',
                                        'default' => 'bg-gray-500/90 text-white border-gray-500'
                                    ];
                                    $statusTexts = [
                                        'pending' => 'Pendiente',
                                        'accepted' => 'Aceptado',
                                        'rejected' => 'Rechazado',
                                        'default' => ucfirst($candidate->status)
                                    ];
                                    $status = strtolower($candidate->status);
                                    $statusStyle = $statusStyles[$status] ?? $statusStyles['default'];
                                    $statusText = $statusTexts[$status] ?? $statusTexts['default'];
                                @endphp
                                <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusStyle }}">
                                    {{ $statusText }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-tactical-text/70 uppercase tracking-wider border-b border-tactical-border/30 pb-2">
                            <i class="fas fa-id-card text-tactical-accent mr-2"></i>Datos Personales
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <p class="text-xs text-tactical-text/50 uppercase">Nombre Completo</p>
                                <p class="text-tactical-text">{{ $candidate->first_name }} {{ $candidate->last_name }}</p>
                            </div>
                            @if($candidate->email)
                            <div>
                                <p class="text-xs text-tactical-text/50 uppercase">Correo Electrónico</p>
                                <p class="text-tactical-text">{{ $candidate->email }}</p>
                            </div>
                            @endif
                            @if($candidate->phone)
                            <div>
                                <p class="text-xs text-tactical-text/50 uppercase">Teléfono</p>
                                <p class="text-tactical-text">{{ $candidate->phone }}</p>
                            </div>
                            @endif
                            @if($candidate->date_of_birth)
                            <div>
                                <p class="text-xs text-tactical-text/50 uppercase">Fecha de Nacimiento</p>
                                <p class="text-tactical-text">{{ $candidate->date_of_birth->format('d/m/Y') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    </div>

                </div>

                <!-- Notes Section -->
                <div class="px-4 py-5 sm:p-6 border-t border-tactical-border/30">
                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-tactical-text/70 uppercase tracking-wider border-b border-tactical-border/30 pb-2">
                            <i class="fas fa-clipboard-list text-tactical-accent mr-2"></i>Informes y Notas
                        </h4>
                        <div class="bg-tactical-surface/30 border border-tactical-border/50 rounded-lg p-4">
                            <x-candidate-notes 
                                :candidate="$candidate" 
                                :notes="$candidate->notes ?? collect()" 
                                :skipEmptyState="true"
                            >
                                <div class="text-center py-6">
                                    <i class="fas fa-clipboard text-3xl text-tactical-text/30 mb-2"></i>
                                    <p class="text-tactical-text/70">No hay informes disponibles</p>
                                    <p class="text-xs text-tactical-text/50 mt-1">Añade el primer informe utilizando el formulario</p>
                                </div>
                            </x-candidate-notes>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
                <div class="text-sm text-tactical-text/60">
                    <span class="hidden sm:inline">ID:</span> #{{ $candidate->id }}
                    <span class="mx-2 hidden sm:inline">•</span>
                    <span>Última actualización: {{ $candidate->updated_at->diffForHumans() }}</span>
                </div>
                <div class="flex space-x-3 w-full sm:w-auto">
                    @can('update', $candidate)
                    <a href="{{ route('candidates.edit', $candidate) }}" 
                       class="inline-flex items-center px-4 py-2 bg-tactical-accent/80 border border-tactical-accent/70 rounded-md font-medium text-xs text-white uppercase tracking-wider hover:bg-tactical-accent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tactical-accent transition-colors">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</body>
</html>
