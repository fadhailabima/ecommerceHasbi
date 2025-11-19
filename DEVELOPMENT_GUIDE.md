# 🛒 Djoki Shop - Development Guide

## 📋 Quick Start

### 1. Install Dependencies

```bash
composer install
npm install
```

### 2. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
APP_NAME="Djoki Shop"
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=ecommerce_djoki
DB_USERNAME=root
DB_PASSWORD=root

FILESYSTEM_DISK=public
```

### 3. Setup Database

```bash
# Create database
mysql -u root -p -e "CREATE DATABASE ecommerce_djoki;"

# Run migrations
php artisan migrate:fresh

# Seed demo data (development only!)
php artisan db:seed

# Create storage link
php artisan storage:link
```

### 4. Build & Run

```bash
# Terminal 1: Start Laravel
php artisan serve

# Terminal 2: Start Vite
npm run dev

# Visit: http://127.0.0.1:8000
```

---

## 👥 Demo Accounts (Development Only)

⚠️ **WARNING**: These are created by seeder for LOCAL TESTING only!

Check `database/seeders/DatabaseSeeder.php` for:

- 1 Admin account
- 2 User accounts
- 8 Sample products

**NEVER use these in production!**

---

## 📂 Project Structure

### Models & Relationships

```
User (id, name, username, email, password, role)
├─ hasMany → Order

Product (id, name, description, price, stock, image, is_active)
├─ hasMany → OrderItem

Order (id, user_id, total_price, status, created_at)
├─ belongsTo → User
├─ hasMany → OrderItem

OrderItem (id, order_id, product_id, quantity, price)
├─ belongsTo → Order
├─ belongsTo → Product
```

### Routes

```
Public:
- GET  /                    → Redirect to /login or role-based
- GET  /login               → Login page
- POST /login               → Process login
- GET  /register            → Register page
- POST /register            → Process register
- POST /logout              → Logout

User (authenticated):
- GET  /shop                → Browse products
- GET  /shop/{product}      → Product detail
- POST /shop/{product}      → Checkout (throttle: 10/min)
- GET  /shop/orders         → My orders

Admin (authenticated + role:admin):
- GET  /admin/dashboard     → Dashboard
- GET  /admin/products      → Product list
- GET  /admin/products/create → Add product
- POST /admin/products      → Store product
- GET  /admin/products/{id}/edit → Edit product
- PUT  /admin/products/{id} → Update product
- DELETE /admin/products/{id} → Delete product
- GET  /admin/orders        → All orders
- PUT  /admin/orders/{id}   → Update order status
- GET  /admin/users         → All users
```

---

## 🎨 Features

### Customer Features

- Browse products with search/filter
- View product details with image
- Checkout products (single item)
- View order history
- Track order status

### Admin Features

- Dashboard with statistics
- Product CRUD operations
- Image upload (max 2MB, jpeg/png/jpg/gif/webp)
- Order management (update status)
- User management (view all users)
- Role-based access control

### Security Features

- CSRF protection (all forms)
- XSS protection (Blade auto-escaping)
- SQL injection prevention (Eloquent)
- Password hashing (bcrypt)
- Rate limiting (10 req/min on checkout)
- File upload validation
- Role-based middleware

---

## 🔧 Common Commands

### Development

```bash
# Clear all caches
php artisan optimize:clear

# Clear specific caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Reset database
php artisan migrate:fresh --seed

# Watch assets
npm run dev

# Check logs
tail -f storage/logs/laravel.log
```

### Production Build

```bash
# Build assets
npm run build

# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 📸 File Upload

### Storage Structure

```
storage/
└── app/
    └── public/
        └── products/
            └── [uploaded images]

public/
└── storage/ → symlink to storage/app/public
```

### Upload Configuration

- **Location**: `storage/app/public/products/`
- **Max Size**: 2MB
- **Allowed Types**: jpeg, png, jpg, gif, webp
- **Validation**: Controller validates mime type and size
- **Access**: Via `/storage/products/filename.jpg`

### Setup

```bash
php artisan storage:link
chmod -R 775 storage/app/public/products
```

---

## 🐛 Troubleshooting

### Images not showing

```bash
php artisan storage:link
chmod -R 775 storage/app/public
```

### Routes not working

```bash
php artisan route:clear
php artisan route:cache
```

### Views not updating

```bash
php artisan view:clear
```

### Database errors

```bash
# Check connection in .env
# Verify database exists
mysql -u root -p -e "SHOW DATABASES;"

# Reset if needed
php artisan migrate:fresh --seed
```

### Permission errors

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 🧪 Testing Checklist

### Authentication

- [ ] Login with username works
- [ ] Login with email works
- [ ] Register new user works
- [ ] Logout works
- [ ] Remember me works

### Customer Flow

- [ ] Browse products
- [ ] View product detail
- [ ] Checkout product
- [ ] View my orders
- [ ] Cannot access admin pages

### Admin Flow

- [ ] View dashboard
- [ ] Create product with image
- [ ] Edit product
- [ ] Delete product
- [ ] View all orders
- [ ] Update order status
- [ ] View all users

### Security

- [ ] Non-admin cannot access /admin/\*
- [ ] Rate limiting works on checkout
- [ ] File upload validates type/size
- [ ] CSRF tokens present
- [ ] Passwords are hashed

---

## 🚀 Production Deployment

### ⚠️ CRITICAL: Security Checklist

1. **NEVER use demo credentials in production**
2. **NEVER run seeder in production**
3. **ALWAYS set APP_DEBUG=false**
4. **ALWAYS set APP_ENV=production**
5. **ALWAYS use strong passwords**

### Create Admin Account (Production)

```bash
php artisan tinker
```

```php
User::create([
    'name' => 'Your Name',
    'username' => 'secure_username',
    'email' => 'admin@yourdomain.com',
    'password' => Hash::make('YOUR-STRONG-PASSWORD'),
    'role' => 'admin'
]);
```

### Production .env

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=production_db
DB_USERNAME=production_user
DB_PASSWORD=STRONG_PASSWORD

FILESYSTEM_DISK=public
```

### Deployment Steps

```bash
# 1. Pull latest code
git pull origin main

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm ci --production

# 3. Build assets
npm run build

# 4. Maintenance mode
php artisan down

# 5. Migrate database
php artisan migrate --force

# 6. Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 7. Set permissions
chmod -R 775 storage bootstrap/cache

# 8. Back online
php artisan up
```

---

## 📚 Database Schema

### Users Table

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    email_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Products Table

```sql
CREATE TABLE products (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    image VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Orders Table

```sql
CREATE TABLE orders (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending','processing','completed','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Order Items Table

```sql
CREATE TABLE order_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
```

---

## 🎯 Requirements Met

✅ **1. E-Commerce** - Full product catalog, checkout, orders
✅ **2. User/Admin Roles** - Role-based access control
✅ **3. Username/Password** - Login with username OR email + password
✅ **4. User ID** - Auto-generated primary key
✅ **5. Access Control** - Middleware protection on routes

---

## 📖 Tech Stack

- **Backend**: Laravel 11.x
- **Frontend**: Blade Templates + Tailwind CSS 3.x + Alpine.js
- **Database**: MySQL 8.0
- **Build**: Vite
- **Authentication**: Laravel Breeze (customized)
- **File Storage**: Local (public disk)

---

## 🔗 Important Files

### Controllers

- `app/Http/Controllers/Admin/ProductController.php` - Product CRUD
- `app/Http/Controllers/Admin/OrderController.php` - Order management
- `app/Http/Controllers/Admin/UserController.php` - User management
- `app/Http/Controllers/ShopController.php` - Customer shopping

### Middleware

- `app/Http/Middleware/CheckRole.php` - Role-based access

### Models

- `app/Models/User.php` - User model with roles
- `app/Models/Product.php` - Product model
- `app/Models/Order.php` - Order model
- `app/Models/OrderItem.php` - Order items

### Views

- `resources/views/layouts/app.blade.php` - Main layout
- `resources/views/layouts/guest.blade.php` - Guest layout
- `resources/views/layouts/navigation.blade.php` - Navigation menu
- `resources/views/shop/*` - Customer views
- `resources/views/admin/*` - Admin views

### Routes

- `routes/web.php` - All application routes
- `routes/auth.php` - Authentication routes

### Seeders

- `database/seeders/DatabaseSeeder.php` - Demo data (dev only!)

---

## 💡 Tips

### Performance

- Use eager loading: `Order::with('user', 'orderItems.product')->get()`
- Cache queries: `Cache::remember('products', 3600, fn() => Product::all())`
- Paginate large datasets: `Product::paginate(20)`

### Security

- Always validate input
- Use `$fillable` or `$guarded` in models
- Never trust user input
- Hash passwords before storing
- Use middleware for authorization
- Validate file uploads

### Debugging

- Check `storage/logs/laravel.log`
- Use `dd()` or `dump()` for quick debugging
- Enable query logging: `DB::enableQueryLog()`
- Use Laravel Debugbar (dev only)

---

## 🆘 Support

### Common Issues

**Q: Login tidak berfungsi**
A: Check credentials in DatabaseSeeder.php, clear cache

**Q: Gambar tidak muncul**
A: Run `php artisan storage:link`, check permissions

**Q: Error 403 saat akses admin**
A: Check user role in database, verify middleware

**Q: Error 500**
A: Check logs in `storage/logs/laravel.log`

**Q: CSS tidak update**
A: Run `npm run build`, clear browser cache

---

**Last Updated**: November 19, 2025
**Laravel Version**: 11.x
**Status**: ✅ Production Ready
