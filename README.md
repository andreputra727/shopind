# Shopind

Shopind is an electronics e-commerce web application built with Laravel. Customers can browse products, manage a shopping cart, top up and transfer an in-app balance, check out using that balance, and view their order history. Admins manage the product catalog from a dedicated panel.

Built as a course project for Information System Design Implementation (Implementasi Perancangan Sistem Informasi) at Universitas Brawijaya.

## Screenshots

> Add screenshots to a `screenshots/` folder and update the paths below.

| Home | Product Catalog |
| --- | --- |
| ![Home](screenshots/home.png) | ![Catalog](screenshots/catalog.png) |

| Cart & Checkout | Admin Panel |
| --- | --- |
| ![Cart](screenshots/cart.png) | ![Admin](screenshots/admin.png) |

## Features

**Customer**
- Register, log in, and manage profile (Laravel Breeze)
- Home page with featured products
- Product catalog with category filter and search
- Product detail page
- Shopping cart: add, update quantity, remove items
- Balance top-up and balance transfer to other users (database transaction with balance validation)
- Checkout paid with in-app balance, with insufficient-balance handling
- Order history

**Admin**
- Role-based access protected by a custom `admin` middleware
- Product management: create, edit, delete, with image upload

## Tech Stack

- **Backend:** PHP 8.2, Laravel 12, Laravel Breeze
- **Frontend:** Blade, Tailwind CSS, Alpine.js, Vite
- **Database:** MySQL
- **Data model:** users, products, carts, cart_items, orders, order_items

## Getting Started

### Requirements

- PHP 8.2+
- Composer
- Node.js and npm
- MySQL (e.g. via XAMPP)

### Installation

```bash
git clone https://github.com/andreputra727/shopind.git
cd shopind

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Create a MySQL database named `shopind`, then update the database section of `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shopind
DB_USERNAME=root
DB_PASSWORD=
```

Run the migrations, seed demo data, and link storage:

```bash
php artisan migrate
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=ProductSeeder
php artisan storage:link
```

Build the assets and start the server:

```bash
npm run build
php artisan serve
```

Open `http://127.0.0.1:8000` in your browser.

### Demo Accounts

| Role | Email | Password |
| --- | --- | --- |
| Admin | admin@shopind.com | password |
| Customer | customer@shopind.com | password |

## Author

**Andre Syaputra Siregar**, Information Technology, Universitas Brawijaya