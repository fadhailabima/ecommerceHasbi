# 📂 Struktur Direktori Anda di cPanel

Berdasarkan output `ls`, struktur Anda:

```
/home/u672201335/hasbi.store/
├── app/
├── artisan
├── bootstrap/
├── composer.json
├── composer.lock
├── config/
├── database/
├── deploy.sh
├── DEVELOPMENT_GUIDE.md
├── DO_NOT_UPLOAD_HERE
├── node_modules/
├── package.json
├── package-lock.json
├── phpunit.xml
├── postcss.config.js
├── public_html/          ← Folder public (domain root)
│   ├── .htaccess
│   ├── index.php
│   ├── build/
│   └── ... (file public lainnya)
├── README.md
├── resources/
├── routes/
├── storage/
│   └── app/
│       └── public/       ← Target symlink
├── tailwind.config.js
├── tests/
├── vendor/
└── vite.config.js
```

## ✅ Path yang Benar untuk Symlink:

- **Target:** `/home/u672201335/hasbi.store/storage/app/public`
- **Link:** `/home/u672201335/hasbi.store/public_html/storage`

## 📝 File yang Sudah Disesuaikan:

### 1. **`public/create-symlink.php`**
```php
$target = '/home/u672201335/hasbi.store/storage/app/public';
$link = '/home/u672201335/hasbi.store/public_html/storage';
```

### 2. **`public/index.cpanel.php`**
Path sudah diubah ke struktur baru:
```php
__DIR__.'/../storage/framework/maintenance.php'
__DIR__.'/../vendor/autoload.php'
__DIR__.'/../bootstrap/app.php'
```

Karena `public_html` ada di dalam `hasbi.store/`, maka `../` akan naik ke folder `hasbi.store/`

## 🚀 Langkah Selanjutnya:

### 1. **Copy index.php**
Di server, jalankan:
```bash
cd /home/u672201335/hasbi.store
cp public/index.cpanel.php public_html/index.php
```

Atau manual via File Manager:
- Copy isi `public/index.cpanel.php`
- Paste ke `public_html/index.php` (overwrite)

### 2. **Upload & Jalankan create-symlink.php**
```bash
# Upload create-symlink.php ke public_html/
# Lalu akses via browser:
```
Buka: `https://hasbi.store/create-symlink.php`

### 3. **Hapus File Setelah Berhasil**
```bash
rm /home/u672201335/hasbi.store/public_html/create-symlink.php
```

## ✅ Verifikasi:

Cek symlink berhasil:
```bash
ls -la /home/u672201335/hasbi.store/public_html/storage
```

Output seharusnya:
```
lrwxrwxrwx ... storage -> /home/u672201335/hasbi.store/storage/app/public
```

---

**Semua file sudah disesuaikan dengan struktur direktori Anda!** 🎉
