@props([
    'member' => new \App\Models\User(),
    'roles' => []
])

<div class="space-y-6">
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Profile</h3>
                <p class="mt-1 text-sm text-gray-500">Basic member information.</p>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $member?->first_name) }}" required
                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $member?->last_name) }}" required
                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $member?->email) }}" required
                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">{{ $member ? 'New Password' : 'Password' }}</label>
                        <input type="password" name="password" id="password" {{ $member ? '' : 'required' }}
                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ $member ? 'Confirm New Password' : 'Confirm Password' }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" {{ $member ? '' : 'required' }}
                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Roles & Permissions</h3>
                <p class="mt-1 text-sm text-gray-500">Assign roles to this member.</p>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="space-y-4">
                    @foreach($roles as $role)
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="role-{{ $role->id }}" name="roles[]" type="checkbox" value="{{ $role->id }}"
                                    {{ in_array($role->id, old('roles', $member ? $member->roles->pluck('id')->toArray() : [])) ? 'checked' : '' }}
                                    class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="role-{{ $role->id }}" class="font-medium text-gray-700">{{ ucfirst($role->name) }}</label>
                                <p class="text-gray-500">{{ $role->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.members.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Cancel
        </a>
        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            {{ $member ? 'Update' : 'Create' }} Member
        </button>
    </div>
</div>
