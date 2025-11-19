# 🛒 Djoki Shop - E-Commerce Platform

![Laravel](https://img.shields.io/badge/Laravel-11.x-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-cyan)

Modern e-commerce platform dengan role-based access control, product management, dan secure checkout system.

---

## 🚀 Quick Start

```bash
# 1. Install dependencies
composer install && npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Configure database di .env
DB_DATABASE=ecommerce_djoki
DB_USERNAME=root
DB_PASSWORD=root

# 4. Setup database
php artisan migrate:fresh --seed
php artisan storage:link

# 5. Run application
php artisan serve  # Terminal 1
npm run dev        # Terminal 2
```

Visit: **http://127.0.0.1:8000**

---

## ✨ Features

### 🛍️ Customer
- Browse & search products
- Product detail with image
- Checkout system
- Order tracking

### 👨‍💼 Admin
- Dashboard statistics
- Product CRUD with image upload
- Order management
- User management

### 🔒 Security
- Role-based access control
- CSRF & XSS protection
- Rate limiting
- File upload validation
- Password hashing (bcrypt)

---

## 📚 Full Documentation

👉 **See [DEVELOPMENT_GUIDE.md](DEVELOPMENT_GUIDE.md)** for complete documentation:
- Setup instructions
- Project structure
- API routes
- Database schema
- Troubleshooting
- Production deployment
- Testing checklist

---

## 👥 Demo Accounts (Development Only)

⚠️ **For local testing only-f API_DOCUMENTATION.md CHEATSHEET.md DOCS_INDEX.md INSTALLATION.md PRESENTATION_CHECKLIST.md PRODUCTION.md PRODUCTION_READY.md PRODUCTION_UI_CHECKLIST.md PROJECT_COMPLETE.md PROJECT_DOCUMENTATION.md QUICK_REFERENCE.md README_PROJECT.md SECURITY_BEST_PRACTICES.md SUMMARY.md TESTING_GUIDE.md UI_PRODUCTION_SUMMARY.md* Check `database/seeders/DatabaseSeeder.php` for credentials.

**Never use demo accounts in production!**

---

## 🔧 Common Commands

```bash
# Development
php artisan serve              # Start server
npm run dev                    # Watch assets
php artisan optimize:clear     # Clear all caches

# Production
npm run build                  # Build assets
php artisan optimize           # Cache everything
```

---

## 🎯 Requirements Met

✅ E-Commerce features (products, orders, checkout)  
✅ User/Admin roles with access control  
✅ Username/Password authentication  
✅ User ID system (auto-generated)  
✅ Access control middleware  

---

## 📖 Tech Stack

- **Laravel 11** - Backend framework
- **Tailwind CSS 3** - Styling
- **Alpine.js** - Interactive components
- **MySQL 8** - Database
- **Vite** - Asset bundling

---

## 🆘 Need Help?

Check **[DEVELOPMENT_GUIDE.md](DEVELOPMENT_GUIDE.md)** for:
- Complete setup guide
- Troubleshooting solutions
- Database structure
- API documentation
- Production deployment

---

**Built with ❤️ using Laravel 11**
