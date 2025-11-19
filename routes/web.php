<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('shop.index');
    }
    return redirect()->route('login');
});

// Routes untuk User (Customer)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('shop.index');
    })->name('dashboard');
    
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');
    Route::get('/my-orders', [ShopController::class, 'orders'])->name('shop.orders');
    Route::post('/checkout', [ShopController::class, 'checkout'])
        ->middleware('throttle:10,1')
        ->name('shop.checkout');
});

// Routes untuk Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    
    // Order Management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::patch('/orders/{order}', [AdminController::class, 'updateOrderStatus'])->name('orders.update');
    
    // Product Management
    Route::resource('products', AdminProductController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
