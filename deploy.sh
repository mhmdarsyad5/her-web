#!/bin/bash
set -e

echo "=== MEMULAI DEPLOYMENT DI VPS ==="

# 1. Pull code terbaru
echo "--> Mengambil kode terbaru dari GitHub..."
git pull origin main

# 2. Install dependensi composer
echo "--> Menginstal/update dependensi Composer..."
composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 3. Migrasi database
echo "--> Menjalankan migrasi database..."
php artisan migrate --force

# 4. Install & build frontend assets
echo "--> Membangun aset frontend..."
npm install
npm run build

# 5. Membersihkan & optimasi cache Laravel
echo "--> Membersihkan & mengoptimasi cache Laravel..."
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Memastikan symlink storage aktif
echo "--> Membuat symlink storage jika belum ada..."
php artisan storage:link

echo "=== DEPLOYMENT SELESAI DENGAN SUKSES! ==="
