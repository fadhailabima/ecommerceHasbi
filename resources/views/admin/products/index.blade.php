<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    📦 {{ __('Manage Products') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Add, edit, or remove products from your catalog</p>
            </div>
            <a href="{{ route('admin.products.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                <span class="mr-2">➕</span> Add New Product
            </a>
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
                    <h3 class="text-lg font-bold text-gray-900">Product Catalog</h3>
                    <p class="text-sm text-gray-600 mt-1">Manage your entire product inventory</p>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Product Name
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Stock
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($products as $product)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold text-gray-900">{{ $product->id }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center">
                                                <span class="text-xl">📦</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                                <div class="text-xs text-gray-500">{{ Str::limit($product->description, 40) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->stock > 10)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                <span class="mr-1">✓</span> {{ $product->stock }} units
                                            </span>
                                        @elseif($product->stock > 0)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                                <span class="mr-1">⚠</span> {{ $product->stock }} units
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                <span class="mr-1">✗</span> Out of stock
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->is_active)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                <span class="mr-1">●</span> Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                <span class="mr-1">●</span> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                               class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-150">
                                                <span class="mr-1">✏️</span> Edit
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" 
                                                  method="POST" class="inline"
                                                  onsubmit="return confirmDelete('Are you sure you want to delete {{ addslashes($product->name) }}? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-150">
                                                    <span class="mr-1">🗑️</span> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
