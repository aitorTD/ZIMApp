@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">User Management</h2>
                </div>

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @foreach ($user->roles as $role)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="editUser({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this user?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                <!-- Edit Form (Hidden by default) -->
                                <tr id="edit-form-{{ $user->id }}" class="hidden bg-gray-50">
                                    <td colspan="4" class="px-6 py-4">
                                        <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                                                    <input type="text" name="first_name" value="{{ $user->first_name }}" required
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                                    <input type="text" name="last_name" value="{{ $user->last_name }}" required
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                                    <input type="email" name="email" value="{{ $user->email }}" required
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">New Password (leave blank to keep current)</label>
                                                    <input type="password" name="password"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                                <div class="col-span-2">
                                                    <label class="block text-sm font-medium text-gray-700">Roles</label>
                                                    <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-2">
                                                        @foreach ($roles as $role)
                                                            <div class="flex items-center">
                                                                <input id="role-{{ $user->id }}-{{ $role->id }}" name="roles[]" type="checkbox" value="{{ $role->id }}"
                                                                    {{ $user->roles->contains($role->id) ? 'checked' : '' }}
                                                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                                <label for="role-{{ $user->id }}-{{ $role->id }}" class="ml-2 block text-sm text-gray-900">
                                                                    {{ ucfirst($role->name) }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 flex justify-end space-x-3">
                                                <button type="button" onclick="cancelEdit({{ $user->id }})" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Update User
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function editUser(userId) {
        // Hide all other open forms
        document.querySelectorAll('[id^=edit-form-]').forEach(form => {
            form.classList.add('hidden');
        });
        // Show the selected form
        document.getElementById('edit-form-' + userId).classList.remove('hidden');
        // Scroll to the form
        document.getElementById('edit-form-' + userId).scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function cancelEdit(userId) {
        document.getElementById('edit-form-' + userId).classList.add('hidden');
    }
</script>
@endpush
@endsection
