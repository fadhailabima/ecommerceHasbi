<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    👨‍💼 {{ __('Admin Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Overview of your e-commerce platform</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="mb-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
                <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-blue-100">Here's what's happening with your store today.</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users Card -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <div class="p-6 bg-gradient-to-br from-blue-50 to-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Total Users</p>
                                <p class="text-4xl font-bold text-gray-900 mt-2">{{ $stats['total_users'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">Registered</p>
                            </div>
                            <div class="bg-blue-100 rounded-full p-4">
                                <span class="text-4xl">👥</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 px-6 py-3">
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-700 font-semibold hover:text-blue-900 transition">
                            View all users →
                        </a>
                    </div>
                </div>

                <!-- Total Products Card -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <div class="p-6 bg-gradient-to-br from-green-50 to-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-green-600 uppercase tracking-wide">Total Products</p>
                                <p class="text-4xl font-bold text-gray-900 mt-2">{{ $stats['total_products'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">Active items</p>
                            </div>
                            <div class="bg-green-100 rounded-full p-4">
                                <span class="text-4xl">📦</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 px-6 py-3">
                        <a href="{{ route('admin.products.index') }}" class="text-sm text-green-700 font-semibold hover:text-green-900 transition">
                            Manage products →
                        </a>
                    </div>
                </div>

                <!-- Total Orders Card -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <div class="p-6 bg-gradient-to-br from-purple-50 to-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-purple-600 uppercase tracking-wide">Total Orders</p>
                                <p class="text-4xl font-bold text-gray-900 mt-2">{{ $stats['total_orders'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">All time</p>
                            </div>
                            <div class="bg-purple-100 rounded-full p-4">
                                <span class="text-4xl">🛒</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-50 px-6 py-3">
                        <a href="{{ route('admin.orders.index') }}" class="text-sm text-purple-700 font-semibold hover:text-purple-900 transition">
                            View all orders →
                        </a>
                    </div>
                </div>

                <!-- Pending Orders Card -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <div class="p-6 bg-gradient-to-br from-orange-50 to-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-orange-600 uppercase tracking-wide">Pending Orders</p>
                                <p class="text-4xl font-bold text-gray-900 mt-2">{{ $stats['pending_orders'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">Needs attention</p>
                            </div>
                            <div class="bg-orange-100 rounded-full p-4">
                                <span class="text-4xl">⏳</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-orange-50 px-6 py-3">
                        <a href="{{ route('admin.orders.index') }}" class="text-sm text-orange-700 font-semibold hover:text-orange-900 transition">
                            Process orders →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Revenue Card -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-xl p-8 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-100 text-sm font-semibold uppercase tracking-wide">Total Revenue</p>
                        <p class="text-5xl font-bold mt-2">
                            Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                        </p>
                        <p class="text-indigo-100 text-sm mt-2">From all completed orders</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-6">
                        <span class="text-6xl">💰</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
                    <h3 class="text-xl font-bold text-gray-900">⚡ Quick Actions</h3>
                    <p class="text-sm text-gray-600 mt-1">Perform common administrative tasks</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('admin.products.create') }}" 
                           class="flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                            <span class="mr-2">➕</span> Add New Product
                        </a>
                        <a href="{{ route('admin.products.index') }}" 
                           class="flex items-center justify-center bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-6 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                            <span class="mr-2">📦</span> Manage Products
                        </a>
                        <a href="{{ route('admin.orders.index') }}" 
                           class="flex items-center justify-center bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-4 px-6 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                            <span class="mr-2">📋</span> View All Orders
                        </a>
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center justify-center bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold py-4 px-6 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                            <span class="mr-2">👥</span> Manage Users
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">📋 Recent Orders</h3>
                            <p class="text-sm text-gray-600 mt-1">Latest customer transactions</p>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                            View All
                        </a>
                    </div>
                </div>

                @if($recent_orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Order Number
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Items
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Total Amount
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Date
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recent_orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-xs bg-gray-100 text-gray-800 px-3 py-1 rounded-full font-mono font-semibold">
                                            {{ $order->order_number }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($order->user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $order->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">{{ $order->orderItems->count() }} items</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusConfig = match($order->status) {
                                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => '⏳'],
                                            'processing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => '⚙️'],
                                            'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => '✅'],
                                            'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => '❌'],
                                            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => '📦']
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                        <span class="mr-1">{{ $statusConfig['icon'] }}</span>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="p-12 text-center">
                    <div class="text-gray-400 text-6xl mb-4">📭</div>
                    <p class="text-gray-500 text-lg font-semibold">No orders yet</p>
                    <p class="text-gray-400 text-sm mt-2">Orders will appear here once customers start purchasing</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
