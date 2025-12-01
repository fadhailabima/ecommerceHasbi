# 🔧 Troubleshooting Error 500 di Production

## Langkah 1: Cek Error Log

### A. Cek Laravel Log
```bash
cd /home/u672201335/domains/hasbi.store
tail -100 storage/logs/laravel.log
```

### B. Cek Apache Error Log
```bash
tail -100 /home/u672201335/domains/hasbi.store/logs/error_log
# atau
tail -100 /var/log/apache2/error_log
```

---

## Langkah 2: Verifikasi File Penting

### A. Cek index.php di public_html
```bash
cat public_html/index.php
```

Pastikan isinya seperti ini:
```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
```

### B. Cek .env File
```bash
cat .env | head -20
```

Pastikan:
- `APP_ENV=production`
- `APP_DEBUG=false` (ubah jadi `true` sementara untuk lihat error detail)
- Database credentials benar

---

## Langkah 3: Set Permissions

```bash
cd /home/u672201335/domains/hasbi.store

# Storage & cache harus writable
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Pastikan ownership benar
chown -R u672201335:u672201335 storage
chown -R u672201335:u672201335 bootstrap/cache
```

---

## Langkah 4: Clear All Caches

```bash
cd /home/u672201335/domains/hasbi.store

php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Rebuild cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Langkah 5: Aktifkan Debug Mode (Sementara)

Edit `.env`:
```bash
nano .env
```

Ubah:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

Lalu clear config:
```bash
php artisan config:clear
```

Akses website lagi di browser, error detail akan muncul.

**PENTING:** Setelah tahu errornya, kembalikan `APP_DEBUG=false`!

---

## Langkah 6: Cek File/Folder yang Mungkin Kurang

### A. Cek vendor folder
```bash
ls -la vendor/
```

Jika kosong atau tidak ada, install ulang:
```bash
composer install --no-dev --optimize-autoloader
```

### B. Cek .env file
```bash
ls -la .env
```

Jika tidak ada, copy dari .env.production:
```bash
cp .env.production .env
```

### C. Cek APP_KEY
```bash
grep APP_KEY .env
```

Jika kosong, generate:
```bash
php artisan key:generate
```

---

## Langkah 7: Cek PHP Version

```bash
php -v
```

Pastikan PHP >= 8.2

Jika versi salah, ubah di cPanel → Select PHP Version

---

## Common Issues & Solutions

### Issue 1: Vendor folder tidak ada
```bash
composer install --no-dev --optimize-autoloader
```

### Issue 2: Permissions salah
```bash
chmod -R 775 storage bootstrap/cache
```

### Issue 3: .env tidak ada atau APP_KEY kosong
```bash
cp .env.production .env
php artisan key:generate
php artisan config:clear
```

### Issue 4: Autoload files corrupt
```bash
composer dump-autoload
```

### Issue 5: Path di index.php salah
Pastikan path menggunakan `../` bukan `/home/u672201335/domains/hasbi.store/`

---

## Quick Fix Script

Jalankan ini untuk fix semua sekaligus:

```bash
cd /home/u672201335/domains/hasbi.store

# Set permissions
chmod -R 775 storage bootstrap/cache

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Rebuild
composer dump-autoload
php artisan config:cache

echo "Done! Cek website sekarang."
```

---

## Setelah Fix

1. Test akses: `https://hasbi.store`
2. Jika masih error, lihat log: `tail -50 storage/logs/laravel.log`
3. Share error message untuk troubleshooting lebih lanjut

---

**Mulai dari langkah 1 dan 5 dulu untuk melihat error detail!**
