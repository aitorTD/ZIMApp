<x-admin>
    <form action="{{ route('admin.candidates.store') }}" method="POST">
        @csrf
        <div class="tactical-card overflow-hidden border border-tactical-border/50">
            <div class="px-6 py-5 border-b border-tactical-border/30">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-tactical-text flex items-center">
                            <i class="fas fa-user-plus text-tactical-accent mr-3"></i>
                            Nuevo Recluta
                        </h2>
                        <p class="text-sm text-tactical-text/60 mt-1">Añade un nuevo recluta al sistema</p>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-6 space-y-8">
                @include('admin.candidates.form')
            </div>
        </div>
    </form>
</x-admin>
