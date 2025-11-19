<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@ecommerce.com',
            'phone' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Create Sample Regular Users
        User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'phone' => '081234567891',
            'role' => 'user',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'username' => 'janesmith',
            'email' => 'jane@example.com',
            'phone' => '081234567892',
            'role' => 'user',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create Sample Products
        $products = [
            [
                'name' => 'Laptop Gaming ASUS ROG',
                'slug' => 'laptop-gaming-asus-rog',
                'description' => 'Laptop gaming dengan spesifikasi tinggi, RAM 16GB, SSD 512GB',
                'price' => 15000000,
                'stock' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Mouse Logitech G502',
                'slug' => 'mouse-logitech-g502',
                'description' => 'Mouse gaming dengan sensor presisi tinggi',
                'price' => 750000,
                'stock' => 25,
                'is_active' => true,
            ],
            [
                'name' => 'Keyboard Mechanical RGB',
                'slug' => 'keyboard-mechanical-rgb',
                'description' => 'Keyboard mechanical dengan RGB lighting',
                'price' => 1200000,
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Monitor LG 27 inch 4K',
                'slug' => 'monitor-lg-27-inch-4k',
                'description' => 'Monitor 4K dengan refresh rate 144Hz',
                'price' => 5500000,
                'stock' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Headset Gaming HyperX Cloud',
                'slug' => 'headset-gaming-hyperx-cloud',
                'description' => 'Headset gaming dengan audio berkualitas tinggi',
                'price' => 1500000,
                'stock' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Webcam Logitech C920',
                'slug' => 'webcam-logitech-c920',
                'description' => 'Webcam Full HD 1080p untuk streaming',
                'price' => 1800000,
                'stock' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'SSD Samsung 1TB',
                'slug' => 'ssd-samsung-1tb',
                'description' => 'SSD NVMe dengan kecepatan baca/tulis tinggi',
                'price' => 2000000,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'RAM Corsair 16GB DDR4',
                'slug' => 'ram-corsair-16gb-ddr4',
                'description' => 'RAM DDR4 3200MHz untuk gaming',
                'price' => 1200000,
                'stock' => 25,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

