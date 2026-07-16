#!/bin/bash
set -e

echo "=== MEMULAI DEPLOYMENT CEPAT DI VPS ==="

# 1. Pull code terbaru
echo "--> Mengambil kode terbaru dari GitHub..."
git pull origin main

# 2. Migrasi database
echo "--> Menjalankan migrasi database..."
php artisan migrate --force

# 3. Bersihkan cache Laravel
echo "--> Membersihkan cache..."
php artisan cache:clear

echo "=== DEPLOYMENT SELESAI! ==="
