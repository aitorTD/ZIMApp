<x-auth-layout>
    <div class="max-w-5xl w-full mx-auto px-4 py-6">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-orbitron font-bold text-tactical-text mb-1">Bienvenido, <span class="text-tactical-accent">{{ auth()->user()->nickname ?? auth()->user()->first_name }}</span></h1>
            <p class="text-sm text-tactical-text/60">{{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Quick Actions -->
        <div class="mb-6 flex flex-wrap justify-center gap-2">
            @if(auth()->user()->hasAnyRole(['admin', 'member']))
            <a href="{{ route('candidates.create') }}" class="inline-flex items-center px-3 py-1.5 bg-tactical-accent/10 hover:bg-tactical-accent/20 border border-tactical-accent/30 text-tactical-text rounded-md text-sm transition-colors">
                <i class="fas fa-user-plus mr-1.5 text-xs"></i> Añadir Recluta
            </a>
            @endif
            @if(auth()->user()->hasRole('sponsor'))
            <a href="{{ route('sponsor.my-candidates') }}" class="inline-flex items-center px-3 py-1.5 bg-tactical-surface/50 hover:bg-tactical-surface/70 border border-tactical-border text-tactical-text rounded-md text-sm transition-colors">
                <i class="fas fa-users mr-1.5 text-xs"></i> Mis Reclutas
            </a>
            @endif
            @if(auth()->user()->hasRole('admin'))
            <a href="{{ url('/admin') }}" class="inline-flex items-center px-3 py-1.5 bg-tactical-surface/50 hover:bg-tactical-surface/70 border border-tactical-border text-tactical-text rounded-md text-sm transition-colors">
                <i class="fas fa-shield-alt mr-2 text-xs"></i>Panel
            </a>
            @endif
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
            <div class="bg-tactical-surface/50 border border-tactical-border/50 rounded p-3 text-center">
                <div class="text-xl font-semibold text-tactical-text">{{ $totalCandidates ?? 0 }}</div>
                <div class="text-xs text-tactical-text/60">TOTAL</div>
            </div>
            <div class="bg-tactical-surface/50 border border-yellow-500/20 rounded p-3 text-center">
                <div class="text-xl font-semibold text-yellow-500">{{ $pendingCandidates ?? 0 }}</div>
                <div class="text-xs text-tactical-text/60">EN PROCESO</div>
            </div>
            <div class="bg-tactical-surface/50 border border-green-500/20 rounded p-3 text-center">
                <div class="text-xl font-semibold text-green-500">{{ $acceptedCandidates ?? 0 }}</div>
                <div class="text-xs text-tactical-text/60">ACEPTADOS</div>
            </div>
            <div class="bg-tactical-surface/50 border border-red-500/20 rounded p-3 text-center">
                <div class="text-xl font-semibold text-red-500">{{ $rejectedCandidates ?? 0 }}</div>
                <div class="text-xs text-tactical-text/60">RECHAZADOS</div>
            </div>
        </div>

        <!-- Recent Candidates -->
        <div class="bg-tactical-surface/70 border border-tactical-border/50 rounded-lg overflow-hidden">
            <div class="p-4 border-b border-tactical-border/30 flex justify-between items-center bg-tactical-surface/50">
                <h2 class="text-base font-semibold text-white">ÚLTIMOS RECLUTAS</h2>
                <span class="text-sm text-tactical-text/70">{{ count($candidates ?? []) }} registros</span>
            </div>
            
            @if(count($candidates ?? []) > 0)
                <div class="divide-y divide-tactical-border/30">
                    @foreach($candidates as $candidate)
                        <a href="{{ route('candidates.show', $candidate) }}" class="block hover:bg-tactical-surface/40 transition-colors">
                            <div class="p-4 flex items-center justify-between">
                                <div class="flex items-center min-w-0">
                                    <div class="h-10 w-10 rounded-full bg-tactical-surface/80 border border-tactical-border flex items-center justify-center mr-3 flex-shrink-0">
                                        <i class="fas fa-user text-sm text-tactical-accent"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-base font-medium text-white">{{ $candidate->first_name }} {{ $candidate->last_name }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @php
                                        $statusStyles = [
                                            'pending' => 'background-color: #eab308; color: white; border-color: #eab308;',
                                            'accepted' => 'background-color: #22c55e; color: white; border-color: #22c55e;',
                                            'rejected' => 'background-color: #ef4444; color: white; border-color: #ef4444;',
                                            'default' => 'background-color: #6b7280; color: white; border-color: #6b7280;'
                                        ];
                                        $statusTexts = [
                                            'pending' => 'Pendiente',
                                            'accepted' => 'Aceptado',
                                            'rejected' => 'Rechazado',
                                            'default' => ucfirst($candidate->status)
                                        ];
                                        $status = strtolower($candidate->status);
                                        $style = $statusStyles[$status] ?? $statusStyles['default'];
                                        $text = $statusTexts[$status] ?? $statusTexts['default'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border border-opacity-100" style="{{ $style }}">
                                        {{ $text }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                @if($candidates->hasPages())
                    <div class="p-2 border-t border-tactical-border/30">
                        {{ $candidates->links() }}
                    </div>
                @endif
            @else
                <div class="p-6 text-center">
                    <i class="fas fa-inbox text-2xl text-tactical-text/20 mb-2"></i>
                    <p class="text-sm text-tactical-text/50">No hay reclutas recientes</p>
                </div>
            @endif
        </div>
    </div>
</x-auth-layout>
