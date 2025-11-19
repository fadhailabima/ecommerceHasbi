<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * Display products for shopping
     */
    public function index()
    {
        $products = Product::active()
            ->latest()
            ->paginate(12);

        return view('shop.index', compact('products'));
    }

    /**
     * Display single product
     */
    public function show(Product $product)
    {
        // Check if product is active
        if (!$product->is_active) {
            return redirect()->route('shop.index')
                ->with('error', 'Produk tidak tersedia.');
        }

        return view('shop.show', compact('product'));
    }

    /**
     * Display user's orders
     */
    public function orders()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $orders = $user->orders()
            ->with('orderItems.product')
            ->latest()
            ->paginate(10);

        return view('shop.orders', compact('orders'));
    }

    /**
     * Create new order (checkout)
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($validated['product_id']);
            
            // Check if product is active
            if (!$product->is_active) {
                throw new \Exception("Produk tidak tersedia.");
            }

            // Check stock availability
            if ($product->stock < $validated['quantity']) {
                throw new \Exception("Stok produk tidak mencukupi. Stok tersedia: {$product->stock}");
            }

            // Calculate amounts
            $subtotal = $product->price * $validated['quantity'];

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $subtotal,
                'status' => 'pending',
            ]);

            // Create order item
            $order->orderItems()->create([
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
            ]);

            // Reduce stock
            $product->decrement('stock', $validated['quantity']);

            DB::commit();

            return redirect()->route('shop.orders')
                ->with('success', "Order berhasil dibuat! Nomor order: {$order->order_number}");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Gagal membuat order: ' . $e->getMessage())
                ->withInput();
        }
    }
}
