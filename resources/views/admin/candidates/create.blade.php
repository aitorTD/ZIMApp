<x-admin>
    <form action="{{ route('admin.candidates.store') }}" method="POST">
        @csrf
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Add New Candidate</h3>
                    <p class="mt-1 text-sm text-gray-500">Add a new candidate to the system.</p>
                </div>

                @include('admin.candidates.form')
            </div>
        </div>
    </form>
</x-admin>
