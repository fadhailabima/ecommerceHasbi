<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    🛍️ {{ __('Shop') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Discover amazing products</p>
            </div>
            <a href="{{ route('shop.orders') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                📦 My Orders
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="mb-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <h1 class="text-3xl font-bold mb-2">Welcome, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-indigo-100">Browse our collection and find your favorite products below.</p>
            </div>

            @if($products->count() > 0)
                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                        <!-- Product Image -->
                        <div class="h-56 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden relative">
                            @if($product->image)
                                @php
                                    $imageUrl = url('storage/' . $product->image);
                                @endphp
                                <img src="{{ $imageUrl }}" 
                                     alt="{{ $product->name }}" 
                                     class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-300"
                                     onload="console.log('Image loaded:', this.src)"
                                     onerror="console.error('Image failed to load:', this.src, 'Path:', '{{ $product->image }}');">
                            @else
                                <div class="flex flex-col items-center justify-center h-full">
                                    <span class="text-gray-400 text-6xl">📦</span>
                                    <p class="text-xs text-gray-500 mt-2">No image</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition">
                                {{ $product->name }}
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ Str::limit($product->description, 80) }}
                            </p>
                            
                            <!-- Price and Stock -->
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <span class="text-2xl font-bold text-indigo-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-gray-500 block">Stock</span>
                                    <span class="text-sm font-semibold {{ $product->stock > 10 ? 'text-green-600' : 'text-orange-600' }}">
                                        {{ $product->stock }} units
                                    </span>
                                </div>
                            </div>
                            
                            <!-- View Details Button -->
                            <a href="{{ route('shop.show', $product) }}" 
                               class="block w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-center font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                View Details
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-md p-16 text-center">
                    <div class="text-gray-400 text-8xl mb-4">🏪</div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">No Products Available</h3>
                    <p class="text-gray-500 text-lg">Check back soon for new arrivals!</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
