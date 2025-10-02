#!/bin/bash

echo "🚀 Starting Attendance System Setup..."

# Copy environment file
cp .env.example .env

# Install dependencies
composer install

# Generate application key
php artisan key:generate

# Publish vendor files
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Generate storage link
php artisan storage:link

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear

echo "✅ Setup completed successfully!"
echo "📧 Admin Login: admin@sekolah.id / password"
echo "👨‍🏫 Guru Login: guru.matematika@sekolah.id / password"
echo "🌐 Run: php artisan serve"