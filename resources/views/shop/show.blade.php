<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ $product->name }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Product details and information</p>
            </div>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                ← Back to Shop
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                    <!-- Product Image -->
                    <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl overflow-hidden flex items-center justify-center" style="min-height: 400px;">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-gray-400 text-9xl">📦</span>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="flex flex-col justify-between">
                        <div>
                            <!-- Product Name -->
                            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                            
                            <!-- Product Price -->
                            <div class="mb-6">
                                <span class="text-5xl font-bold text-indigo-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Stock Info -->
                            <div class="mb-6">
                                @if($product->stock > 10)
                                    <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-lg">
                                        <span class="mr-2 text-xl">✓</span>
                                        <div>
                                            <p class="font-semibold">In Stock</p>
                                            <p class="text-sm">{{ $product->stock }} units available</p>
                                        </div>
                                    </div>
                                @elseif($product->stock > 0)
                                    <div class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-800 rounded-lg">
                                        <span class="mr-2 text-xl">⚠</span>
                                        <div>
                                            <p class="font-semibold">Limited Stock</p>
                                            <p class="text-sm">Only {{ $product->stock }} units left!</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="inline-flex items-center px-4 py-2 bg-red-100 text-red-800 rounded-lg">
                                        <span class="mr-2 text-xl">✗</span>
                                        <div>
                                            <p class="font-semibold">Out of Stock</p>
                                            <p class="text-sm">Product currently unavailable</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Description -->
                            <div class="mb-8">
                                <h3 class="text-xl font-bold text-gray-900 mb-3">Product Description</h3>
                                <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                            </div>

                            <!-- Product Specs -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-8">
                                <h3 class="text-lg font-bold text-gray-900 mb-3">Product Information</h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">SKU:</span>
                                        <span class="font-semibold text-gray-900">{{ $product->slug }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="font-semibold {{ $product->is_active ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Category:</span>
                                        <span class="font-semibold text-gray-900">General</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Purchase Form -->
                        @if($product->stock > 0 && $product->is_active)
                        <form action="{{ route('shop.checkout') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div>
                                <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-2">Quantity</label>
                                <input type="number" 
                                       name="quantity" 
                                       id="quantity" 
                                       min="1" 
                                       max="{{ $product->stock }}" 
                                       value="1"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-lg">
                                🛒 Add to Cart & Checkout
                            </button>
                        </form>
                        @else
                        <div class="bg-gray-100 text-gray-600 font-bold py-4 px-6 rounded-lg text-center">
                            Product Not Available
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
