# 🚀 Panduan Deploy Laravel ke cPanel (hasbi.store)

## 📋 Persiapan Sebelum Deploy

### 1. Requirement Server
- PHP >= 8.2
- MySQL/MariaDB
- Composer
- Node.js & NPM (untuk build assets)
- Apache dengan mod_rewrite

### 2. Build Production Assets (Di Lokal)
```bash
npm install
npm run build
```

### 3. Optimize Laravel (Di Lokal)
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📦 Tahap 1: Upload File ke cPanel

### A. Struktur Folder di cPanel
```
/home/username/
├── public_html/           # Domain root (hasbi.store akan point ke sini)
│   ├── .htaccess         # File Laravel public/.htaccess
│   ├── index.php         # File Laravel public/index.php (MODIFIED)
│   ├── favicon.ico
│   ├── robots.txt
│   └── build/            # Vite assets hasil npm run build
│       └── assets/
│           ├── app-*.css
│           └── app-*.js
│
└── laravel/              # Folder Laravel utama (DI LUAR public_html)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── public/           # JANGAN upload folder ini, isinya sudah di public_html
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .env              # File production environment
    ├── artisan
    ├── composer.json
    └── composer.lock
```

### B. Upload Langkah demi Langkah

1. **Buat Database di cPanel**
   - Masuk ke cPanel → MySQL Databases
   - Buat database baru: `hasbistore_db`
   - Buat user baru: `hasbistore_user` dengan password kuat
   - Assign user ke database dengan ALL PRIVILEGES

2. **Upload File**
   - Buat folder `laravel` di luar `public_html`
   - Upload SEMUA file Laravel ke folder `/home/username/laravel/` KECUALI folder `public/`
   - Upload isi folder `public/` ke `/home/username/public_html/`

3. **Upload via FTP atau File Manager**
   - Gunakan FileZilla atau cPanel File Manager
   - Compress dulu jadi .zip untuk upload lebih cepat
   - Extract di server

---

## ⚙️ Tahap 2: Konfigurasi File

### A. Edit `public_html/index.php`

File ini perlu dimodifikasi karena struktur folder berbeda:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// UBAH PATH INI - sesuaikan dengan lokasi folder laravel
if (file_exists($maintenance = __DIR__.'/../laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

// UBAH PATH INI - sesuaikan dengan lokasi folder laravel
require __DIR__.'/../laravel/vendor/autoload.php';

// UBAH PATH INI - sesuaikan dengan lokasi folder laravel
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

$app->handleRequest(Request::capture());
```

**PENTING:** Ganti `../laravel/` dengan path absolut jika tidak berfungsi:
```php
// Contoh path absolut:
$maintenance = '/home/username/laravel/storage/framework/maintenance.php';
require '/home/username/laravel/vendor/autoload.php';
$app = require_once '/home/username/laravel/bootstrap/app.php';
```

### B. Setup `.env` Production

Upload file `.env.production` ke folder `laravel/` dan rename jadi `.env`:

**Sesuaikan nilai berikut:**
```env
DB_DATABASE=hasbistore_db          # Nama database dari cPanel
DB_USERNAME=hasbistore_user        # Username database dari cPanel
DB_PASSWORD=your_password_here     # Password database dari cPanel
```

### C. Verifikasi `.htaccess` di `public_html/`

File sudah benar, pastikan isinya seperti ini:
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Handle X-XSRF-Token Header
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

## 🔐 Tahap 3: Set Permissions (Penting!)

Via SSH atau Terminal di cPanel:

```bash
cd /home/username/laravel

# Set ownership (optional, tergantung server)
# chown -R username:username .

# Set permissions untuk storage dan bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Set permissions untuk folder public_html
cd /home/username/public_html
chmod -R 755 .
```

**Via File Manager cPanel:**
- Klik kanan folder `storage` → Change Permissions → 775 (recursive)
- Klik kanan folder `bootstrap/cache` → Change Permissions → 775 (recursive)

---

## 🗄️ Tahap 4: Setup Database

### Via SSH (Jika tersedia):

```bash
cd /home/username/laravel
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

### Via cPanel (Tanpa SSH):

1. **Import Database Manual**
   - Di lokal, export database: `php artisan migrate:fresh --seed`
   - Export database dari phpMyAdmin lokal
   - Import ke phpMyAdmin di cPanel

2. **Storage Link Manual**
   Jika tidak bisa pakai `php artisan storage:link`, buat symlink manual:
   - Di File Manager, masuk ke `public_html/`
   - Buat symlink bernama `storage` yang point ke `../laravel/storage/app/public`
   
   Atau buat file PHP sementara di `public_html/create-symlink.php`:
   ```php
   <?php
   symlink('/home/username/laravel/storage/app/public', '/home/username/public_html/storage');
   echo 'Storage linked!';
   ```
   Akses via browser: `https://hasbi.store/create-symlink.php`
   Lalu hapus file tersebut setelah selesai.

---

## 🔧 Tahap 5: Optimize Production

Jika punya akses SSH:

```bash
cd /home/username/laravel

# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Cache untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## ✅ Tahap 6: Testing & Verifikasi

1. **Cek Homepage**
   - Buka: `https://hasbi.store`
   - Seharusnya muncul halaman welcome/home

2. **Test Login**
   - Buka: `https://hasbi.store/login`
   - Login dengan akun admin yang sudah dibuat

3. **Test Upload Gambar**
   - Coba upload produk dengan gambar
   - Pastikan gambar muncul di halaman shop

4. **Cek Error Log**
   - cPanel → Errors
   - Atau lihat file: `/home/username/laravel/storage/logs/laravel.log`

---

## 🚨 Troubleshooting

### Error 500 Internal Server Error
```bash
# Cek error log
tail -f /home/username/laravel/storage/logs/laravel.log

# Pastikan permissions benar
chmod -R 775 storage bootstrap/cache

# Clear cache
php artisan config:clear
php artisan cache:clear
```

### Blank Page / White Screen
- Pastikan path di `index.php` sudah benar
- Cek PHP version di cPanel (harus >= 8.2)
- Pastikan `APP_DEBUG=false` di production

### Assets (CSS/JS) Tidak Load
- Pastikan folder `public_html/build/` ada dan berisi file hasil `npm run build`
- Cek `APP_URL` di `.env` sudah benar: `https://hasbi.store`
- Clear browser cache

### Gambar Tidak Muncul
- Pastikan storage link sudah dibuat
- Cek permissions folder `storage/app/public/`
- Verifikasi symlink: `ls -la public_html/storage`

### Database Connection Error
- Cek kredensial database di `.env`
- Pastikan database user punya privileges
- Coba koneksi manual via phpMyAdmin

---

## 📝 Checklist Deploy

- [ ] Database dibuat di cPanel
- [ ] File Laravel uploaded ke `/laravel/`
- [ ] File public uploaded ke `/public_html/`
- [ ] `index.php` sudah dimodifikasi dengan path yang benar
- [ ] `.env` production sudah dikonfigurasi
- [ ] Permissions `storage/` dan `bootstrap/cache/` = 775
- [ ] Database migrated & seeded
- [ ] Storage link dibuat
- [ ] Config cached
- [ ] Test login berhasil
- [ ] Test upload gambar berhasil
- [ ] SSL certificate aktif (HTTPS)

---

## 🔒 Security Checklist

- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] Database password kuat (minimal 16 karakter)
- [ ] File `.env` TIDAK bisa diakses public
- [ ] Folder `laravel/` di luar `public_html/`
- [ ] `composer install --no-dev` (tanpa dev dependencies)
- [ ] HTTPS/SSL aktif
- [ ] Disable directory listing
- [ ] Regular backup database & files

---

## 📞 Support

Jika ada masalah:
1. Cek error log: `/home/username/laravel/storage/logs/laravel.log`
2. Cek cPanel error log
3. Aktifkan debug sementara: `APP_DEBUG=true` (jangan lupa matikan lagi!)
4. Contact hosting support untuk PHP version/extensions

---

**🎉 Selamat! Aplikasi HasbiStore siap online di https://hasbi.store**
