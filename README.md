# 🍽️ Food Delivery & MLM Platform - Laravel Backend

### A full-stack Laravel 11 application combining a food delivery platform with an MLM member management system

[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![JWT](https://img.shields.io/badge/JWT-Auth-000000?style=for-the-badge&logo=jsonwebtokens&logoColor=white)](https://jwt.io)
[![License](https://img.shields.io/badge/License-MIT-yellow?style=for-the-badge)](LICENSE)

> A production-grade Laravel backend with two layers - a **Blade admin panel** for operations management and a **REST API** for the customer mobile app. Features OTP-based authentication, pincode-aware product delivery, kitchen stock management, and an MLM referral network with performance bonuses.

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Architecture](#-architecture)
- [Project Structure](#-project-structure)
- [Database Schema](#-database-schema)
- [API Documentation](#-api-documentation)
- [Getting Started](#-getting-started)
- [Environment Variables](#-environment-variables)

---

## 🔍 Overview

This is a dual-purpose backend built for a food business operating on an MLM (Multi-Level Marketing) model. It serves two clients simultaneously:

- **Admin Panel** (Blade/Web) - full operations dashboard for managing kitchens, members, products, stock, and MLM plans
- **Customer REST API** (JSON/JWT) - powers the mobile app with OTP login, pincode-based product discovery, and member dashboards

---

## ✨ Features

### 👥 MLM Member Management
- Member registration with sponsor referral chain - auto-generates sequential membership IDs
- Full KYC document management - PAN card, Aadhaar, bank documents, profile photo (multi-file upload)
- Genealogy tree view to visualise the referral network
- MLM plan configuration - TDS %, activation reward points, direct referral percentages
- Performance bonus tiers based on Business Volume (BV) ranges
- Bulk member actions - activate, deactivate, delete

### 🍽️ Kitchen & Food Operations
- Multi-kitchen setup - each kitchen mapped to pincodes for delivery zone management
- Kitchen manager assignment per kitchen
- Kitchen stock tracking per ingredient
- Ingredient management with product-ingredient linking
- Two product pricing modes - `qty` (fixed price) and `variant` (size-based variants with separate prices)
- Home page product curation with `isShowOnHome` flag

### 📱 Customer Mobile API
- OTP-based mobile login - no password required, 4-digit OTP with 10-min expiry
- JWT authentication with token invalidation on logout
- Pincode-aware dashboard - shows category-wise minimum prices for the user's delivery zone
- Smart product query - filters products by kitchen serving the user's pincode
- Subquery-based pricing engine that correctly handles both `qty` and `variant` pricing modes

### 🔐 Dual Authentication System
- **Admin** - session-based auth via Laravel Blade middleware (`admin.auth` / `admin.guest`)
- **Customer** - JWT tokens via `tymon/jwt-auth` with OTP verification flow
- Separate guards for `admin` and `member` users

---

## 🛠️ Tech Stack

| Category | Technology | Purpose |
|---|---|---|
| **Framework** | Laravel 11 | Application core |
| **Language** | PHP 8.2+ | Backend logic |
| **Database** | MySQL 8.0 | Primary data store |
| **Auth (Admin)** | Laravel Session | Web admin panel auth |
| **Auth (Customer)** | JWT (tymon/jwt-auth) | Mobile API auth |
| **Excel** | PHPSpreadsheet | Data export |
| **Frontend (Admin)** | Blade Templates + Vite | Server-rendered admin UI |
| **API Format** | JSON REST | Mobile app endpoints |

---

## 🏗️ Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                       Two Clients                            │
│                                                              │
│     Admin Browser                  Customer Mobile App       │
│     (Session Auth)                 (JWT Auth)                │
└────────────┬───────────────────────────────┬────────────────┘
             │                               │
             ▼                               ▼
┌────────────────────────┐     ┌─────────────────────────────┐
│      Web Routes        │     │         API Routes           │
│      /admin/*          │     │         /api/*               │
│      Blade Views       │     │         JSON Responses       │
│   admin.auth middleware│     │   JwtAuthenticate middleware  │
└────────────┬───────────┘     └──────────────┬──────────────┘
             │                                │
             └──────────────┬─────────────────┘
                            ▼
             ┌──────────────────────────────┐
             │         Controllers           │
             │   admin/      customer/       │
             └──────────────┬───────────────┘
                            │
                            ▼
             ┌──────────────────────────────┐
             │           Services            │
             │  MemberService                │
             │  ProductService               │
             │  KitchenService               │
             │  CustomerDashboardService     │
             │  ...                          │
             └──────────────┬───────────────┘
                            │
                            ▼
             ┌──────────────────────────────┐
             │       Models (Eloquent)       │
             │  Member, Product, Kitchen     │
             │  PlanSetting, PerformanceBonus│
             │  KitchenStock, Ingredient     │
             └──────────────┬───────────────┘
                            │
                            ▼
                    ┌───────────────┐
                    │     MySQL     │
                    └───────────────┘
```

**Design patterns used:**
- **DTO (Data Transfer Objects)** - all input mapped via DTOs before reaching the service layer
- **Service Layer** - zero business logic in controllers
- **BaseResponseDTO** - consistent JSON response envelope across all API endpoints

---

## 📁 Project Structure

```
app/
├── DTO/                            # Data Transfer Objects
│   ├── BaseResponseDTO.php         # Consistent API response wrapper {status, message, data}
│   ├── MemberRequestDTO.php        # Member create/update input mapping
│   ├── ProductDTO.php
│   ├── KitchenDTO.php
│   ├── PerformanceBonusDTO.php
│   └── ...
│
├── Http/
│   ├── Controllers/
│   │   ├── admin/                  # Admin panel controllers (Blade views)
│   │   │   ├── LoginController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── MemberController.php
│   │   │   ├── PlanController.php
│   │   │   ├── PerformanceBonusController.php
│   │   │   ├── KitchenController.php
│   │   │   ├── KitchenManagerController.php
│   │   │   ├── KitchenStockController.php
│   │   │   ├── ProductController.php
│   │   │   ├── ProductVariantController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── IngredientController.php
│   │   │   └── PincodeMasterController.php
│   │   └── customer/               # Customer REST API controllers (JSON)
│   │       ├── AuthController.php
│   │       └── DashboardController.php
│   └── Middleware/
│       ├── AdminAuthenticate.php   # Session-based admin guard
│       ├── AdminRedirect.php       # Guest redirect for admin routes
│       └── JwtAuthenticate.php     # JWT guard for customer API
│
├── Models/
│   ├── Member.php                  # MLM member (implements JWTSubject)
│   ├── PlanSetting.php             # MLM plan configuration
│   ├── PerformanceBonus.php        # BV-based bonus tiers
│   ├── Kitchen.php                 # Kitchen with pincode + manager relationships
│   ├── KitchenManager.php
│   ├── KitchenStock.php
│   ├── Product.php                 # Supports qty/variant pricing modes
│   ├── ProductVariant.php
│   ├── ProductIngredient.php
│   ├── Category.php
│   ├── Ingredient.php
│   ├── PincodeMaster.php
│   ├── UserOtp.php                 # OTP records with expiry
│   └── User.php                    # Admin user
│
└── Services/                       # All business logic lives here
    ├── MemberService.php
    ├── CustomerDashboardService.php
    ├── ProductService.php
    ├── KitchenService.php
    ├── KitchenStockService.php
    ├── PlanSettingService.php
    ├── PerformanceBonusService.php
    └── ...

routes/
├── web.php                         # Admin panel routes (session auth)
└── api.php                         # Customer REST API routes (JWT)

database/
└── migrations/                     # 17 migrations
```

---

## 🗄️ Database Schema

| Table | Purpose |
|---|---|
| `sk_registrations` | MLM members - KYC docs, bank details, sponsor chain |
| `mlm_plans` | Plan tiers with TDS and referral percentages |
| `mlm_performance_bonus` | BV range-based incentive tiers |
| `sk_kitchen_managers` | Kitchen manager profiles |
| `sk_pincode_master` | Serviceable pincodes |
| `sk_kitchen` | Kitchens mapped to pincode + manager |
| `sk_category` | Product categories |
| `sk_products` | Products with `qty`/`variant` pricing mode |
| `sk_product_variants` | Size/weight-based variants with separate prices |
| `sk_ingredients` | Ingredient master list |
| `sk_product_ingredients` | Product ↔ ingredient mapping |
| `sk_kitchen_stocks` | Per-kitchen ingredient stock levels |
| `user_otps` | OTP records with expiry for mobile auth |
| `users` | Admin users |

---

## 🖥️ Admin Panel Pages

**Base URL:** `http://your-domain.com/admin`

Admin panel is protected by session-based middleware. All routes redirect to `/admin/` login if unauthenticated.

| Page | Route | Description |
|------|-------|-------------|
| **Login** | `/admin/` | Session login for admin users |
| **Dashboard** | `/admin/home` | Stats - total members, kitchens, managers, pincodes |
| **Members** | `/admin/members/list` | Member listing with bulk actions |
| **Member Form** | `/admin/members/form` | Create / edit member with KYC docs |
| **Member Genealogy** | `/admin/member/genealogy` | Referral tree visualisation |
| **MLM Plan** | `/admin/plan/form` | Configure TDS %, referral %, reward points |
| **Performance Bonus** | `/admin/performanceBonus/list` | BV-range bonus tier management |
| **Pincode Master** | `/admin/pincodeMaster/list` | Manage serviceable pincodes |
| **Kitchen Managers** | `/admin/kitchenManager/list` | Kitchen manager profiles |
| **Kitchens** | `/admin/kitchen/list` | Kitchen setup with pincode + manager assignment |
| **Categories** | `/admin/category/list` | Product categories per kitchen |
| **Products** | `/admin/product/list` | Products with pricing mode - `qty` or `variant` |
| **Product Variants** | `/admin/productVariant/list` | Size/weight variants per product |
| **Kitchen Stock** | `/admin/kitchenStock/list` | Ingredient stock levels per kitchen |
| **Ingredients** | `/admin/ingredient/list` | Ingredient master list |

> Public pages: `/privacy-policy` and `/terms-and-conditions` (served via Blade, no auth required)

---

## 📚 API Documentation

**Base URL:** `http://your-domain.com/api`

All responses follow a consistent shape:
```json
{
  "status": "success | error",
  "message": "Human readable message",
  "data": {}
}
```

### Authentication Endpoints

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `POST` | `/register/customer` | ❌ | Register new member with sponsor ID |
| `POST` | `/login/customer` | ❌ | Request OTP to mobile number |
| `POST` | `/verifyotp` | ❌ | Verify OTP → returns JWT token + user info |
| `POST` | `/resendotp` | ❌ | Resend OTP (extends expiry if still active) |
| `POST` | `/logout` | 🔒 JWT | Invalidate JWT token |

### Customer Endpoints

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `POST` | `/dashboard` | ❌ | Pincode-aware home - category min prices + featured products |
| `GET` | `/pincode` | ❌ | List serviceable pincodes |
| `GET` | `/product` | ❌ | Product listing |

### OTP Login Flow

```
User enters mobile number
        │
        ▼
POST /login/customer  { mobile }
        │
        ▼
OTP generated (4-digit, 10 min expiry) & sent
        │
        ▼
POST /verifyotp  { mobile, otp_code }
        │
   ┌────┴────┐
   │         │
 Valid    Invalid / Expired
   │         │
   ▼         ▼
JWT token  400 Error
+ user info returned
```

### Dashboard Response Example
```json
{
  "status": "success",
  "data": {
    "catBasedPrice": [
      { "category_name": "Tiffin", "categoryid": 1, "min_price": 80, "min_mrp": 100 }
    ],
    "homePageProduct": [
      {
        "productid": 5,
        "name": "Dal Makhani",
        "ingredients": "Dal, Butter, Cream",
        "image_url": "https://yourdomain.com/uploads/dal.jpg",
        "final_price": 120,
        "final_mrp": 150,
        "variants": []
      }
    ]
  }
}
```

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js (for asset compilation)

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/6ixline/laravel-food-delivery-mlm.git
cd laravel-food-delivery-mlm

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install && npm run build

# 4. Set up environment
cp .env.example .env
php artisan key:generate

# 5. Configure .env with your DB credentials, then run migrations
php artisan migrate

# 6. Generate JWT secret
php artisan jwt:secret

# 7. Start the development server
php artisan serve
```

Open `http://localhost:8000/admin` in your browser for the admin panel.

---

## 🔧 Environment Variables

```env
APP_NAME=FoodDeliveryApp
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=food_delivery
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=
JWT_TTL=60
```

---

## 📄 License

This project is licensed under the MIT License.

---

<div align="center">

Built with ❤️ using Laravel & PHP

**[⬆ Back to top](#️-food-delivery--mlm-platform--laravel-backend)**

</div>