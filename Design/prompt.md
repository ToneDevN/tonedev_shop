# Project

- **Tonedev Shop** — Multi-role e-commerce platform (admin / owner / member / guest)

---

## System Prompt

> You are a senior Laravel developer and UI/UX designer with 10 years of experience building production-grade applications with Laravel and Tailwind CSS. You prioritise clean code, OWASP Top 10 security, performance, modern UI/UX and minimal style. You always follow Laravel conventions: Form Requests for validation, Policies/Gates for authorisation, service classes for business logic, Eloquent scopes for query reuse, and resource controllers wherever possible. You write Blade templates with Alpine.js for lightweight interactivity and Tailwind CSS for styling. You never leave security holes: always validate input, escape output, use CSRF tokens, guard routes with middleware, and avoid raw SQL.

---

## Tech Stack

| Layer | Technology |
| ------- | ----------- |
| Framework | Laravel 12 (PHP 8.2+) |
| Frontend | Blade, Tailwind CSS v3, Alpine.js, Vite |
| Auth | Laravel Breeze |
| Database | PostgreSQL + Eloquent ORM |
| Cache / Queue | Redis |
| Storage | Laravel filesystem (local / S3-compatible) |
| Dev environment | Laravel Sail + Docker |
| CI/CD | Jenkins (7-stage pipeline) |
| Web server | Nginx |
| VCS | Git |

---

## Design Principles

- **Clean Code** — expressive naming, single-responsibility, no magic numbers
- **Security** — OWASP Top 10, XSS output escaping, CSRF, SQL injection prevention via Eloquent, rate limiting, Form Request validation on every mutating endpoint
- **Performance** — eager loading to avoid N+1, Redis caching for hot reads, Vite asset bundling
- **Modern UI/UX** — responsive, accessible, consistent design language, theme(light/dark)

---

## Software Architecture

- MVC (Laravel conventions)
- Thin controllers → Form Requests → Service/Action classes → Eloquent Models
- Route groups: `public`, `auth`, `owner.*`, `admin.*`

---

## User Stories

### Guest

- As a guest, I want to browse products and view product detail pages without logging in.
- As a guest, I want to add products to a cart and proceed to checkout.
- As a guest, I want to track an order by order ID.
- As a guest, I want to register for an account.
- As a guest, I want to log in with my email and password.
- As a guest, I want to reset my password via email.
- As a guest, I want to search/filter products by keyword and filter by category and price range.

### Member

- As a member, I want to save products to wishlist.
- As a member, I want to complete checkout and place an order.
- As a member, I want to add promotion code to my order.
- As a member, I want to upload a payment slip to confirm my payment.
- As a member, I want to view my order history and status.
- As a member, I want to leave a review on a product I purchased.
- As a member, I want to return and refund order.
- As a member, I want to cancel order.
- As a member, I want to register to be a owner.
- As a member, I want to manage my profile and shipping addresses.
- As a member, I want to set default shipping address for faster checkout.
- As a member, I want to only review product and store that I have purchased, giving them a ratting from 1 to 5 and attach a photo.
- As a member, I want to receive notification when order status is changed.

### Owner

- As an owner, I want a dashboard showing key store metrics (sales, orders, revenue).
- As an owner, I want to add new product.
- As an owner, I want to add variant of product.
- As an owner, I want to hide or show product.
- As an owner, I want to manage incoming orders and update their status.
- As an owner, I want to view reports on my store's performance.
- As an owner, I want to receive notification when a product is low stock threshold.
- As an owner, I want to set percentage of stock for low stock threshold for each product.

### Admin

- As an admin, I want to manage all users (view, ban, verify).
- As an admin, I want to approve or reject store.
- As an admin, I want to manage all stores, categories, and content.
- As an admin, I want to view all orders and payments platform-wide.
- As an admin, I want to ban review and comment.
- As an admin, I want to add new category and sub category.
- As an admin, I want to create new promotion and promotion for store or product.
- As an admin, I want to add banner and manage the order of banner.
- As an admin, I want to view logs. (error, info, debug)
- As an admin, I want to view platform-level reports.

---

## Business Rules & Constraints

- **Order ID**: String primary key, format `ORD-{ddmmyy}{00001}`, sequence resets per calendar day.
- **Cart**: Session-based (no DB table). Keyed by `product_id`. Price snapshot is captured at add-time; price changes after adding are not reflected until the item is re-added.
- **Checkout**: Wraps Order + OrderItems + Payment creation in a single DB transaction. Cart is cleared on success.
- **Order statuses**: `pending → paid → shipped → completed | cancelled`
- **Payment method (current)**: `transfer` (slip upload). COD and QR Code are planned.
- **Owner panel**: No auth middleware currently applied — all `/owner/*` routes are publicly accessible until middleware is added.
- **Product slugs**: Used as route parameter instead of numeric IDs (`/product/{slug}`).
- **Soft deletes**: All domain models use `SoftDeletes`.
- **Roles**: `admin`, `owner`, `member`, `guest` — enforced via middleware/Gates (planned; not fully applied yet).

---

## Models

### Implemented

| # | Model | Key Fields |
| --- | ------- | ----------- |
| 1 | **User** | id, name, email, password, role, email_verified_at, remember_token, created_at, updated_at |
| 2 | **Address** | id, user_id, address, city, state, zip_code, country, soft deletes |
| 3 | **Category** | id, name, description, image, soft deletes |
| 4 | **Product** | id, name, description, short_description, sku, slug, content_blocks(jsonb), price, stock, soft deletes |
| 5 | **ProductImage** | id, product_id, image, is_primary, soft deletes |
| 6 | **Order** | id(string ORD-{ddmmyy}{00001}), user_id, customer_name, phone, status, subtotal, shipping_fee, tax_amount, total_amount, tracking_number, shipping_address, soft deletes |
| 7 | **OrderItem** | id, order_id, product_id, quantity, price, soft deletes |
| 8 | **Payment** | id, order_id, amount, status, method, slip_path, soft deletes |
| 9 | **Review** | id, product_id, user_id, rating, comment, soft deletes |

### Planned / Backlog

| # | Model | Key Fields |
| --- | ------- | ----------- |
| 10 | **SocialAccount** | id, user_id, provider, provider_id, soft deletes |
| 11 | **Store** | id, name, description, image, banner, setting(jsonb), user_id, soft deletes |
| 12 | **ProductVariant** | id, product_id, name, price, stock, soft deletes |
| 13 | **Promotion** | id, name, description, image, discount, start_date, end_date, store_id, soft deletes |
| 14 | **PromotionProduct** | id, promotion_id, product_id, soft deletes |
| 15 | **PromotionStore** | id, promotion_id, store_id, soft deletes |
| 16 | **CategoryLink** | id, category_id, parent_id, depth — closure table for nested categories |
| 17 | **Content** | id, title, description, image, user_id, soft deletes |
| 18 | **Report** | id, user_id, store_id, product_id, quantity, total_price, status, soft deletes |
| 19 | **Log** | id, user_id, action, created_at |
| 20 | **Notification** | id, user_id, message, read_at, created_at |
| 21 | **Communication** | id, user_id, store_id, message, soft deletes |
| 22 | **InventoryLog** | id, product_id, quantity, created_at |

---

## Redis Key Patterns

```
cart:{user_id}                        → hash  { product_id: {qty, price, store_id, added_at} }
wishlist:{user_id}                    → set   { product_id, ... }
session:{session_id}                  → (managed by Laravel session driver)
cache:product:{slug}                  → serialised Product with images (TTL 10 min)
cache:home:featured                   → serialised product collection (TTL 5 min)
```


---

## Routes

### Public (no auth)

| Method | URI | Name | Notes |
| -------- | ----- | ------ | ------- |
| GET | `/` | `home` | |
| GET | `/product/{slug}` | `products.show` | |
| GET/POST | `/cart` | `cart.index` | Session cart |
| POST | `/cart/add/{product}` | `cart.add` | |
| DELETE | `/cart/remove/{id}` | `cart.remove` | |
| GET | `/checkout` | `checkout.index` | |
| POST | `/checkout` | `checkout.store` | |
| GET/POST | `/track-order` | `orders.track` | |

### Auth (Breeze)

| Method | URI | Notes |
| -------- | ----- | ------- |
| GET/POST | `/login`, `/register`, `/forgot-password`, `/reset-password` | Breeze defaults |
| GET/POST | `/email/verify` | Email verification |

### Owner (no auth guard yet)

| Method | URI | Name |
| -------- | ----- | ------ |
| GET | `/owner` | `owner.dashboard` |
| POST | `/owner/products/create` | `owner.products.create` |
| GET | `/owner/orders` | `owner.orders.index` |
| GET | `/owner/orders/{order}` | `owner.orders.show` |
| PATCH | `/owner/orders/{order}/status` | `owner.orders.updateStatus` |

---

## Views

### Implemented

```
layouts/
  app.blade.php          ← authenticated layout (Breeze nav)
  guest.blade.php        ← unauthenticated layout
  simple.blade.php       ← minimal layout
  navigation.blade.php   ← nav partial

auth/
  login, register, forgot-password, reset-password, verify-email, confirm-password

home.blade.php
welcome.blade.php
dashboard.blade.php

products/show.blade.php
cart/index.blade.php
checkout/index.blade.php
checkout/success.blade.php
orders/track.blade.php

owner/
  dashboard.blade.php
  orders/index.blade.php
  products/create.blade.php

profile/
  edit.blade.php
  partials/ (update-profile, update-password, delete-user)

components/
  modal, avatar-placeholder, dropdown, nav-link, primary-button,
  secondary-button, danger-button, text-input, input-label,
  input-error, auth-session-status, application-logo
```

### Planned / Backlog

```
layouts/
  admin.blade.php        ← admin panel layout
  owner-full.blade.php   ← full owner sidebar layout

admin/
  dashboard, users/index, stores/index, categories/index,
  orders/index, payments/index, content/index, reports/index

owner/
  store-profile, inventory/index, reports/index

member/
  orders/index, orders/show, payment/upload-slip

components/
  product-card, rating, pagination, toast, breadcrumb
```

---

## Features

### Implemented

- Guest browsing (home, product detail, cart, track order)
- Session cart (add, remove, view)
- Checkout with slip-upload payment (`transfer`)
- Order tracking by order ID
- Owner dashboard (sales stats, recent orders)
- Owner order management (list, view, update status)
- Owner product creation
- Auth (register, login, logout, email verify, password reset) via Breeze
- Profile management (update info, change password, delete account)

### Planned / Backlog

- **Auth**: Role middleware applied to owner/admin routes; social login (OAuth)
- **Member**: Order history page, review submission, address book management
- **Owner**: Full store profile, inventory management, promotions, sales reports
- **Admin**: Full admin panel (users, stores, categories, content, reports)
- **Cart**: Redis-backed cart for logged-in users; wishlist
- **Payment**: COD and QR Code payment methods; payment status webhook
- **Product**: Variant support (size/colour), rich content blocks editor
- **Category**: Nested categories via closure table
- **Notifications**: In-app and email notifications for order status changes
- **Search**: Full-text product search (PostgreSQL `tsvector` or Scout + Meilisearch)

---

## Security Checklist

- [ ] Apply `auth` + role middleware to `/owner/*` and `/admin/*`
- [ ] CSRF tokens on all POST/PATCH/DELETE forms (`@csrf`)
- [ ] Form Request validation on every mutating endpoint
- [ ] XSS: use `{{ }}` not `{!! !!}` unless content is explicitly trusted
- [ ] Rate limiting on login, register, password reset (Laravel `throttle`)
- [ ] File upload validation (MIME type, size, no executable extensions) for slip and product images
- [ ] Avoid mass-assignment exposure — use `$fillable` explicitly (Product currently uses `$guarded = []`)
- [ ] SQL injection: use Eloquent/Query Builder bindings only, no raw interpolation
- [ ] Sensitive env values never committed — injected via Jenkins credentials

## Development Standards & Guidelines

- **Testing**: Use Pest for Feature and Unit testing. Aim for TDD approach.
- **Roles**: Implement Spatie Laravel Permission for RBAC (Roles: admin, owner, member).
- **Code Style**: Follow PSR-12. Use Laravel Pint for styling. Strictly type-hint properties, arguments, and return types.
- **Error Handling**: Use custom Exception classes for business logic failures. Return consistent JSON structure for Alpine.js requests: `{ success: boolean, message: string, data?: any }`.
- **Currency**: Store prices as integers (Satang/Cents). Use a dedicated CurrencyFormatter service for display.
- **Localization**: Default locale is 'th'. All user-facing strings must use `__()` or `trans()` functions.