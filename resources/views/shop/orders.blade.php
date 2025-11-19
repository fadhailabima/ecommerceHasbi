<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    📦 {{ __('My Orders') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Track and view your order history</p>
            </div>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                🛍️ Continue Shopping
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($orders->count() > 0)
                <div class="space-y-6">
                    @foreach($orders as $order)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                        <!-- Order Header -->
                        <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
                            <div class="flex flex-wrap justify-between items-center gap-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Order #{{ $order->order_number }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">Placed on {{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">Total Amount</p>
                                        <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                    @php
                                        $statusConfig = match($order->status) {
                                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => '⏳'],
                                            'processing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => '⚙️'],
                                            'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => '✅'],
                                            'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => '❌'],
                                            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => '📦']
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                        <span class="mr-2 text-lg">{{ $statusConfig['icon'] }}</span>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="p-6">
                            <h4 class="text-md font-bold text-gray-900 mb-4">Order Items</h4>
                            <div class="space-y-4">
                                @foreach($order->orderItems as $item)
                                <div class="flex items-center justify-between border-b border-gray-100 pb-4 last:border-b-0">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0 h-16 w-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                            <span class="text-2xl">📦</span>
                                        </div>
                                        <div>
                                            <h5 class="font-semibold text-gray-900">{{ $item->product->name }}</h5>
                                            <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                            <p class="text-sm text-gray-600">Price: Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-md p-16 text-center">
                    <div class="text-gray-400 text-8xl mb-4">📭</div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">No Orders Yet</h3>
                    <p class="text-gray-500 text-lg mb-6">You haven't placed any orders yet.</p>
                    <a href="{{ route('shop.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:from-indigo-700 hover:to-purple-700 transition">
                        🛍️ Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
