<x-admin>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Admin Dashboard</h2>
        <p class="mt-1 text-sm text-gray-500">Welcome back, {{ auth()->user()->first_name }}! Here's what's happening with your application.</p>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Members Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Members</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $membersCount }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.members.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                        View all members
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Candidates Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <i class="fas fa-user-graduate text-white text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Candidates</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $candidatesCount }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.candidates.index') }}" class="text-sm font-medium text-green-600 hover:text-green-500">
                        View all candidates
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Members -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Members</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Recently registered members and sponsors.</p>
            </div>
            <div class="bg-white overflow-hidden">
                <ul class="divide-y divide-gray-200">
                    @forelse($recentMembers as $member)
                        <li class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium">
                                    {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $member->full_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $member->email }}</div>
                                </div>
                                <div class="ml-auto">
                                    @foreach($member->roles as $role)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $role->name === 'admin' ? 'bg-purple-100 text-purple-800' : ($role->name === 'sponsor' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-4 text-center text-sm text-gray-500">
                            No members found.
                        </li>
                    @endforelse
                </ul>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <a href="{{ route('admin.members.index') }}" class="font-medium text-blue-600 hover:text-blue-500">View all</a>
            </div>
        </div>

        <!-- Recent Candidates -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Candidates</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Recently registered candidates.</p>
            </div>
            <div class="bg-white overflow-hidden">
                <ul class="divide-y divide-gray-200">
                    @forelse($recentCandidates as $candidate)
                        <li class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-medium">
                                    {{ strtoupper(substr($candidate->first_name, 0, 1)) }}{{ strtoupper(substr($candidate->last_name, 0, 1)) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $candidate->full_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $candidate->email }}</div>
                                </div>
                                <div class="ml-auto">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending Review
                                    </span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-4 text-center text-sm text-gray-500">
                            No candidates found.
                        </li>
                    @endforelse
                </ul>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <a href="{{ route('admin.candidates.index') }}" class="font-medium text-green-600 hover:text-green-500">View all</a>
            </div>
        </div>
    </div>
</x-admin>
