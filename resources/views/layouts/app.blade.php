<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Airsoft ZIMA') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        
        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
        <link rel="alternate icon" type="image/png" href="{{ asset('images/logo.png') }}">
        <link rel="mask-icon" href="{{ asset('images/logo.svg') }}" color="#ffffff">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @stack('styles')
    </head>
    <body class="min-h-screen bg-tactical-bg text-tactical-text">
        <!-- Main Content Wrapper -->
        <main class="min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                @yield('content')
            </div>
        </main>

        @hasSection('sidebar')
            <aside class="lg:w-64 flex-shrink-0">
                @yield('sidebar')
            </aside>
        @endif

        @stack('modals')
        @stack('scripts')
        
        <script>
        // Global deleteNote function
        window.deleteNote = function(event, noteId) {
            event.preventDefault();
            
            if (!confirm('Are you sure you want to delete this note?')) {
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
        };
        </script>
    </body>
</html>
