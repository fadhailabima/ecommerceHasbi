#!/bin/bash

echo "🚀 Deploying Djoki Shop to Production..."
echo ""

# 1. Pull latest code
echo "📥 Pulling latest code..."
git pull origin main

# 2. Install/Update dependencies
echo "📦 Installing dependencies..."
composer install --optimize-autoloader --no-dev
npm install --production

# 3. Build assets
echo "🎨 Building frontend assets..."
npm run build

# 4. Clear and optimize caches
echo "🧹 Optimizing application..."
php artisan down
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 5. Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

# 6. Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 7. Set permissions
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 8. Bring application back up
php artisan up

echo ""
echo "✅ Deployment completed successfully!"
echo "🌐 Your application is now live!"
