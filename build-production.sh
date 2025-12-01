#!/bin/bash

# Script untuk prepare production build
# Jalankan script ini sebelum upload ke cPanel

echo "🚀 Preparing production build for hasbi.store..."
echo ""

# 1. Install dependencies
echo "📦 Installing Composer dependencies (production)..."
composer install --optimize-autoloader --no-dev

# 2. Build frontend assets
echo "🎨 Building frontend assets..."
npm install
npm run build

# 3. Optimize Laravel
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Clear unnecessary files
echo "🧹 Cleaning up..."
rm -rf node_modules
rm -rf .git
rm -rf tests

# 5. Create production archive
echo "📦 Creating production archive..."
cd ..
tar -czf hasbistore-production.tar.gz ecommerce-djoki/ \
    --exclude='ecommerce-djoki/node_modules' \
    --exclude='ecommerce-djoki/.git' \
    --exclude='ecommerce-djoki/storage/logs/*' \
    --exclude='ecommerce-djoki/storage/framework/cache/*' \
    --exclude='ecommerce-djoki/storage/framework/sessions/*' \
    --exclude='ecommerce-djoki/storage/framework/views/*'

echo ""
echo "✅ Production build ready!"
echo "📁 Archive: hasbistore-production.tar.gz"
echo ""
echo "Next steps:"
echo "1. Upload hasbistore-production.tar.gz to cPanel"
echo "2. Extract to /home/username/"
echo "3. Move folder 'public' to 'public_html'"
echo "4. Rename remaining folder to 'laravel'"
echo "5. Follow DEPLOYMENT_GUIDE.md"
