<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    👥 {{ __('Manage Users') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">View and manage all registered users</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-900 px-6 py-4 rounded-lg shadow-md mb-6">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">✅</span>
                        <div>
                            <p class="font-semibold">Success!</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-bold text-gray-900">All Users</h3>
                    <p class="text-sm text-gray-600 mt-1">Manage user accounts and roles</p>
                </div>

                <div class="p-6">
                    @if($users->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Username
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Phone
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Orders
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Joined Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900 font-medium">{{ $user->username }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $user->phone ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->role === 'admin')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                                <span class="mr-1">👑</span> Admin
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                <span class="mr-1">👤</span> User
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-sm font-semibold text-gray-900">{{ $user->orders->count() }}</span>
                                            <span class="ml-1 text-xs text-gray-500">orders</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                    @else
                    <div class="p-12 text-center">
                        <div class="text-gray-400 text-6xl mb-4">👥</div>
                        <p class="text-gray-500 text-lg font-semibold">No users found</p>
                        <p class="text-gray-400 text-sm mt-2">Users will appear here when they register</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
