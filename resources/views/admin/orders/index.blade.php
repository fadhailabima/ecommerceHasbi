<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    📋 {{ __('Manage Orders') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">View and manage all customer orders</p>
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
                    <h3 class="text-lg font-bold text-gray-900">All Orders</h3>
                    <p class="text-sm text-gray-600 mt-1">Track and manage customer orders</p>
                </div>

                <div class="p-6">
                    @if($orders->count() > 0)
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
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($orders as $order)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-xs bg-gray-100 text-gray-800 px-3 py-1 rounded-full font-mono font-semibold">
                                            {{ $order->order_number }}
                                        </span>
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
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" 
                                                    class="text-xs border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $orders->links() }}
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
    </div>
</x-app-layout>
