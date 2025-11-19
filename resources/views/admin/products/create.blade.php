<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    ➕ {{ __('Add New Product') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Create a new product for your store</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                ← Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Product Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Product Name *</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @else border-gray-300 @enderror"
                                   placeholder="Enter product name">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Product Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description *</label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="4"
                                      required
                                      class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @else border-gray-300 @enderror"
                                      placeholder="Enter product description">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price and Stock -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price (Rp) *</label>
                                <input type="number" 
                                       name="price" 
                                       id="price" 
                                       value="{{ old('price') }}"
                                       min="0"
                                       step="0.01"
                                       required
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('price') border-red-500 @else border-gray-300 @enderror"
                                       placeholder="0.00">
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stock -->
                            <div>
                                <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">Stock *</label>
                                <input type="number" 
                                       name="stock" 
                                       id="stock" 
                                       value="{{ old('stock') }}"
                                       min="0"
                                       required
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('stock') border-red-500 @else border-gray-300 @enderror"
                                       placeholder="0">
                                @error('stock')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Product Image -->
                        <div>
                            <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Product Image</label>
                            <input type="file" 
                                   name="image" 
                                   id="image" 
                                   accept="image/*"
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('image') border-red-500 @else border-gray-300 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Accepted formats: JPG, PNG, GIF. Max size: 2MB</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm font-semibold text-gray-700">Product is Active</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500">Inactive products will not be visible to customers</p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.products.index') }}" 
                               class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg shadow-md hover:from-indigo-700 hover:to-purple-700 transition">
                                Create Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
