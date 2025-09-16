@props([
    'candidate',
    'notes' => null,
    'emptyState' => null
])

@php
    // If notes weren't passed, try to get them from the candidate
    $notes = $notes ?? $candidate->notes ?? collect();
    
    // Ensure we have a collection
    $notes = $notes instanceof \Illuminate\Database\Eloquent\Collection 
        ? $notes 
        : collect($notes);
@endphp

<div class="space-y-6">
    <!-- Add Note Form -->
    <div class="bg-tactical-surface/50 border border-tactical-border rounded-lg p-4">
        <h3 class="text-lg font-medium text-tactical-text mb-3">Añadir Informe</h3>
        <form id="addNoteForm" action="{{ route('candidates.notes.store', $candidate) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <textarea 
                    id="content" 
                    name="content" 
                    rows="3" 
                    class="w-full bg-tactical-surface/80 border-tactical-border rounded-md shadow-sm focus:ring-tactical-accent focus:border-tactical-accent text-tactical-text"
                    placeholder="Escribe aquí tu informe..."
                    required
                ></textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-tactical-accent/90 border border-tactical-accent/70 rounded-md font-medium text-xs text-white uppercase tracking-wider hover:bg-tactical-accent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tactical-accent transition-colors"
                >
                    <i class="fas fa-save mr-2"></i>Guardar Informe
                </button>
            </div>
        </form>
    </div>

    <!-- Notes List -->
    <div class="space-y-3">
        @if($notes->isNotEmpty())
            <h3 class="text-lg font-medium text-tactical-text mb-2">Historial de Informes</h3>
            @foreach($notes as $note)
            <div id="note-{{ $note->id }}" class="border-l-4 {{ $note->is_private ? 'border-yellow-500/80 bg-yellow-500/10' : 'border-tactical-accent/80 bg-tactical-surface/30' }} p-4 rounded-r shadow-sm">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-tactical-surface/80 border border-tactical-border flex items-center justify-center mr-3 mt-0.5">
                                <i class="fas fa-user text-xs text-tactical-accent"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-tactical-text">{{ $note->content }}</p>
                                <div class="mt-2 flex flex-wrap items-center text-xs">
                                    <span class="text-tactical-text/70">{{ $note->user ? $note->user->first_name . ' ' . $note->user->last_name : 'Usuario Desconocido' }}</span>
                                    <span class="mx-2 text-tactical-text/30">•</span>
                                    <span class="text-tactical-text/60">{{ $note->created_at->format('d/m/Y H:i') }}</span>
                                    @if($note->is_private)
                                        <span class="mx-2 text-tactical-text/30">•</span>
                                        <span class="inline-flex items-center text-yellow-400">
                                            <i class="fas fa-lock text-xs mr-1"></i>
                                            <span class="text-tactical-text/70">Confidencial</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @can('delete', $note)
                        <form id="delete-note-{{ $note->id }}" action="{{ route('candidates.notes.destroy', [$candidate, $note]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button type="button" 
                                onclick="event.preventDefault(); 
                                       if(confirm('¿Estás seguro de que deseas eliminar este informe?')) { 
                                           document.getElementById('delete-note-{{ $note->id }}').submit(); 
                                       }"
                                class="text-tactical-text/50 hover:text-red-400 transition-colors ml-2"
                                title="Eliminar informe"
                        >
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    @endcan
                </div>
            </div>
            @endforeach
        @elseif(empty($skipEmptyState))
            <div class="text-center py-8 border-2 border-dashed border-tactical-border/50 rounded-lg">
                <i class="fas fa-clipboard text-3xl text-tactical-text/30 mb-2"></i>
                <h3 class="mt-2 text-sm font-medium text-tactical-text/70">No hay informes aún</h3>
                <p class="mt-1 text-xs text-tactical-text/50">Añade tu primer informe utilizando el formulario superior.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Make deleteNote function globally available
    window.deleteNote = function(event, noteId) {
        event.preventDefault();
        
        if (!confirm('¿Estás seguro de que deseas eliminar este informe?')) {
            return;
        }
        
        const form = document.getElementById('delete-note-' + noteId);
        if (!form) {
            console.error('Delete form not found');
            return;
        }
        
        // Show loading state
        const deleteButton = event.target.closest('button');
        const originalHtml = deleteButton.innerHTML;
        deleteButton.disabled = true;
        deleteButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-HTTP-Method-Override': 'DELETE'
            },
            credentials: 'same-origin',
            body: new FormData(form)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Server error');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Remove the note from the DOM
                const noteElement = document.getElementById('note-' + noteId);
                if (noteElement) {
                    noteElement.remove();
                    
                    // If no notes left, show empty message
                    if (document.querySelectorAll('[id^="note-"]').length === 0) {
                        const notesContainer = document.querySelector('.space-y-4');
                        if (notesContainer) {
                            notesContainer.innerHTML = '<p class="text-gray-500 text-center py-4">No notes yet. Add your first note above.</p>';
                        }
                    }
                }
                // Show success message
                alert('Note deleted successfully');
            } else {
                throw new Error(data.message || 'Failed to delete note');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + (error.message || 'Failed to delete note'));
        })
        .finally(() => {
            // Reset button state
            if (deleteButton) {
                deleteButton.disabled = false;
                deleteButton.innerHTML = originalHtml;
            }
        });
    }

    // Handle form submission with AJAX
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('addNoteForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                
                // Show loading state
                const submitButton = form.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.innerHTML;
                submitButton.disabled = true;
                submitButton.innerHTML = 'Saving...';
                
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData,
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to show the new note
                        window.location.reload();
                    } else {
                        throw new Error(data.message || 'Failed to save note');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + (error.message || 'Failed to save note'));
                })
                .finally(() => {
                    // Reset button state
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                });
            });
        }
    });
</script>
@endpush