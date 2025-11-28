# Deployment Guide untuk Coolify

Panduan ini menjelaskan cara deploy aplikasi Laravel ini ke Coolify dari GitHub repository.

## Prerequisites

1. **GitHub Repository**: Pastikan kode sudah di-push ke GitHub
2. **Coolify Instance**: Pastikan Anda sudah memiliki Coolify yang terinstall dan running
3. **PostgreSQL Database**: Database PostgreSQL harus sudah tersedia (bisa di-host di Coolify atau external)

## Langkah-langkah Deployment

### 1. Persiapan Repository GitHub

Pastikan file-file berikut sudah ada di repository:
- `composer.json`
- `package.json`
- `vite.config.js`
- Semua file source code

### 2. Setup di Coolify

#### A. Buat Resource Baru
1. Login ke Coolify dashboard
2. Klik "New Resource" atau "Add New"
3. Pilih "Application" atau "Web Application"

#### B. Connect GitHub Repository
1. Pilih "GitHub" sebagai source
2. Authorize Coolify untuk mengakses GitHub (jika belum)
3. Pilih repository yang berisi aplikasi ini
4. Pilih branch (biasanya `main` atau `master`)

#### C. Konfigurasi Build Settings

**Build Pack**: Pilih "Laravel" atau "PHP"

**Build Command**:
```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan key:generate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Start Command**:
Coolify akan handle port exposure secara otomatis. Gunakan salah satu opsi berikut:

**Option 1: PHP Built-in Server** (untuk development/testing):
```bash
php artisan serve
```

**Option 2: PHP-FPM** (recommended untuk production):
```bash
php-fpm
```

**Catatan**: Coolify akan otomatis expose port dan handle routing. Tidak perlu specify `--host` atau `--port` secara manual.

**PHP Version**: Pilih PHP 8.2 atau sesuai dengan `composer.json`

### 3. Environment Variables

Tambahkan environment variables berikut di Coolify:

```env
APP_NAME="Safety Management System"
APP_ENV=production
APP_KEY=base64:... (akan di-generate otomatis atau set manual)
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=pgsql
DB_HOST=your-postgres-host
DB_PORT=5432
DB_DATABASE=your-database-name
DB_USERNAME=your-database-user
DB_PASSWORD=your-database-password

SESSION_DRIVER=database
SESSION_LIFETIME=120

QUEUE_CONNECTION=database
```

**Catatan Penting**:
- `APP_KEY`: Generate dengan `php artisan key:generate` atau set manual
- Database credentials: Sesuaikan dengan database PostgreSQL Anda
- `APP_URL`: Set ke domain yang akan digunakan

### 4. Database Setup

#### A. Buat Database PostgreSQL di Coolify
1. Di Coolify, buat resource baru "PostgreSQL"
2. Catat host, port, database name, username, dan password
3. Gunakan credentials ini untuk environment variables

#### B. Run Migrations
Setelah deployment pertama, jalankan migrations:

**Option 1: Via Coolify Console**
1. Buka aplikasi di Coolify
2. Klik "Execute Command" atau "Shell"
3. Jalankan:
```bash
php artisan migrate --force
```

**Catatan**: Data diisi menggunakan manual SQL query, bukan melalui seeder.

**Option 2: Via Build Command**
Tambahkan di build command (setelah `npm run build`):
```bash
php artisan migrate --force
```

### 5. Storage Link

Pastikan storage link sudah dibuat. Tambahkan di build command:
```bash
php artisan storage:link
```

### 6. File Permissions

Coolify biasanya handle ini otomatis, tapi jika ada masalah, tambahkan di build command:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 7. Deploy

1. Klik "Deploy" atau "Save & Deploy"
2. Coolify akan:
   - Clone repository
   - Install dependencies (composer & npm)
   - Build assets
   - Deploy aplikasi
3. Tunggu hingga deployment selesai

### 8. Post-Deployment

#### A. Verifikasi
1. Buka URL aplikasi yang diberikan Coolify
2. Test login dengan credentials yang ada di database
3. Pastikan semua fitur berfungsi

#### B. Setup Domain (Optional)
1. Di Coolify, tambahkan custom domain
2. Update `APP_URL` di environment variables
3. Setup SSL certificate (Coolify bisa handle ini otomatis)

## Troubleshooting

### Error: "APP_KEY is not set"
- Generate APP_KEY: `php artisan key:generate`
- Copy key yang di-generate ke environment variable `APP_KEY`

### Error: Database Connection Failed
- Pastikan database credentials benar
- Pastikan database sudah dibuat
- Pastikan network/security group mengizinkan koneksi

### Error: 500 Internal Server Error
- Check logs di Coolify
- Pastikan `APP_DEBUG=true` sementara untuk debugging
- Check file permissions

### Assets tidak muncul
- Pastikan `npm run build` berjalan dengan sukses
- Check apakah `public/build` folder ada
- Pastikan `APP_URL` sudah benar

## Production Checklist

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY` sudah di-set
- [ ] Database credentials benar
- [ ] Migrations sudah di-run
- [ ] Storage link sudah dibuat
- [ ] Assets sudah di-build
- [ ] SSL certificate sudah di-setup (jika pakai custom domain)
- [ ] Backup strategy sudah di-setup

## Monitoring

Coolify menyediakan:
- Application logs
- Resource usage (CPU, Memory)
- Health checks
- Automatic restarts

## Update Deployment

Untuk update aplikasi:
1. Push perubahan ke GitHub
2. Di Coolify, klik "Redeploy" atau "Deploy"
3. Coolify akan otomatis pull changes dan rebuild

## Support

Jika ada masalah:
1. Check logs di Coolify dashboard
2. Check Laravel logs: `storage/logs/laravel.log`
3. Pastikan semua environment variables sudah benar

