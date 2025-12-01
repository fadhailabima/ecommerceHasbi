# 🔧 Troubleshooting Database Connection Error

## Error yang Terjadi:
```
Access denied for user 'hasbistore_user'@'localhost' (using password: YES)
```

## Penyebab Umum:

### 1. **Username atau Password Salah**
Periksa kembali kredensial di `.env`:
```env
DB_DATABASE=nama_database_dari_cpanel
DB_USERNAME=username_database_dari_cpanel  
DB_PASSWORD=password_database_dari_cpanel
```

### 2. **User Belum Diberi Privileges ke Database**
Di cPanel → MySQL Databases:
- Pastikan user sudah di-assign ke database
- Klik "Add User To Database"
- Pilih user: `hasbistore_user`
- Pilih database: `hasbistore_db`
- Centang **ALL PRIVILEGES**
- Klik "Make Changes"

### 3. **Format Username Salah**
Di cPanel, username database biasanya punya prefix:
```env
# ❌ SALAH
DB_USERNAME=hasbistore_user

# ✅ BENAR (dengan prefix cpanel username)
DB_USERNAME=cpanel_hasbistore_user
# atau
DB_USERNAME=u672201335_hasbistore_user
```

**PENTING:** Cek di cPanel → MySQL Databases untuk melihat username LENGKAP dengan prefix!

---

## 🛠️ Cara Fix:

### Opsi 1: Pakai Database & User yang Sudah Ada

1. **Cek Database yang Tersedia**
   - Login cPanel
   - Ke MySQL Databases
   - Lihat "Current Databases" - catat nama lengkapnya

2. **Cek User yang Tersedia**
   - Lihat "Current Users" - catat username lengkapnya
   - Format biasanya: `cpanel_username_dbuser`

3. **Update `.env`**
   ```env
   DB_DATABASE=u672201335_hasbidb  # contoh (ganti dengan yang sebenarnya)
   DB_USERNAME=u672201335_hasbiuser # contoh (ganti dengan yang sebenarnya)
   DB_PASSWORD=password_asli_dari_cpanel
   ```

4. **Test Koneksi**
   ```bash
   php artisan config:clear
   php artisan migrate
   ```

### Opsi 2: Buat Database & User Baru di cPanel

1. **Buat Database Baru**
   - cPanel → MySQL Databases
   - "Create New Database"
   - Nama: `hasbidb` (akan jadi `u672201335_hasbidb`)
   - Klik "Create Database"

2. **Buat User Baru**
   - Di bagian "MySQL Users"
   - "Add New User"
   - Username: `hasbiuser` (akan jadi `u672201335_hasbiuser`)
   - Password: (buat password kuat, catat!)
   - Klik "Create User"

3. **Assign User ke Database**
   - Di bagian "Add User To Database"
   - User: pilih user yang baru dibuat
   - Database: pilih database yang baru dibuat
   - Klik "Add"
   - Centang **ALL PRIVILEGES**
   - Klik "Make Changes"

4. **Update `.env` dengan Kredensial yang BENAR**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=u672201335_hasbidb      # nama lengkap dari cpanel
   DB_USERNAME=u672201335_hasbiuser    # username lengkap dari cpanel
   DB_PASSWORD=password_yang_baru_dibuat
   ```

5. **Clear Cache & Migrate**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan migrate --force
   ```

---

## 🧪 Test Koneksi Database

Buat file test di `public_html/test-db.php`:

```php
<?php
// test-db.php - HAPUS FILE INI SETELAH TESTING!

$host = 'localhost';
$dbname = 'u672201335_hasbidb';      // ganti dengan database Anda
$username = 'u672201335_hasbiuser';  // ganti dengan username Anda
$password = 'password_anda';          // ganti dengan password Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Database connection successful!<br>";
    echo "Database: $dbname<br>";
    echo "User: $username<br>";
} catch(PDOException $e) {
    echo "❌ Connection failed:<br>";
    echo $e->getMessage();
}
?>
```

Akses: `https://hasbi.store/test-db.php`

**PENTING:** Hapus file `test-db.php` setelah testing berhasil!

---

## 📝 Checklist Verifikasi:

- [ ] Database sudah dibuat di cPanel MySQL Databases
- [ ] User sudah dibuat di cPanel MySQL Databases  
- [ ] User sudah di-assign ke database dengan ALL PRIVILEGES
- [ ] Username di `.env` LENGKAP dengan prefix (contoh: `u672201335_hasbiuser`)
- [ ] Database di `.env` LENGKAP dengan prefix (contoh: `u672201335_hasbidb`)
- [ ] Password di `.env` sudah benar (case-sensitive!)
- [ ] `DB_HOST=localhost` (bukan 127.0.0.1)
- [ ] `DB_PORT=3306`
- [ ] Config cache sudah di-clear: `php artisan config:clear`

---

## 🔍 Debug Info

Untuk melihat kredensial yang sedang digunakan Laravel:

```bash
php artisan tinker
```

Lalu ketik:
```php
config('database.connections.mysql.database');
config('database.connections.mysql.username');
```

Keluar: `exit`

---

## ⚠️ Catatan Penting:

1. **Username SELALU ada prefix** di shared hosting cPanel
   - Prefix biasanya: username cPanel atau ID user
   - Contoh: `u672201335_` atau `cpanelusername_`

2. **Password Case-Sensitive**
   - Pastikan tidak ada spasi di awal/akhir
   - Copy-paste langsung dari cPanel untuk menghindari typo

3. **After Update `.env`**
   - Selalu jalankan: `php artisan config:clear`
   - Jangan lupa clear browser cache juga

---

Setelah fix, jalankan:
```bash
php artisan config:clear
php artisan migrate --force
php artisan db:seed --force
```
