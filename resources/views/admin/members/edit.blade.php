<x-admin>
    <form action="{{ route('admin.members.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Member: {{ $user->full_name }}</h3>
                    <p class="mt-1 text-sm text-gray-500">Update member information and roles.</p>
                </div>

                @include('admin.members.form', ['member' => $user, 'roles' => $roles])
            </div>
        </div>
    </form>
</x-admin>
