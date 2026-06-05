# plant_store

A simple online plant store built with PHP. It provides a complete front‑end for customers and a back‑office for administrators to manage products, categories, orders, and users.

---

## Overview

`plant_store` is a web application that allows users to browse, search, and purchase a variety of plants, fertilizers, and gardening tools. Administrators can log in to a secure dashboard to add/edit categories and plants, manage orders, and handle user accounts.

Key components include:

| Directory / File | Description |
|------------------|-------------|
| `Database/plantstore.sql` | MySQL dump containing the required tables and sample data. |
| `Online Plant Store.docx` | Project specification and design notes. |
| `admin/` | Admin panel pages (login, dashboard, CRUD operations, order management, etc.). |
| `css/style.css` | Global stylesheet for both front‑end and admin UI. |
| `index.php`, `home.php`, `about.php`, `contactus.php` | Public‑facing pages. |
| `login.php`, `logout.php`, `admin_login.php` | Authentication endpoints. |
| `buy_form.php`, `delete_order.php` | Order handling scripts. |
| `config.php`, `admin/config.php` | Centralised configuration (DB credentials, site settings). |

---

## Features

- **Public storefront**
  - Browse plants, fertilizers, and gardening tools.
  - Detailed product pages with images and descriptions.
  - Simple order form with email confirmation.

- **Admin dashboard**
  - Secure login with session handling.
  - CRUD operations for categories and plants.
  - View and update order status.
  - Manage user accounts (activate, deactivate, delete).
  - Responsive navigation bar (`admin_navbar.php`).

- **Support utilities**
  - Contact form (`contact_support.php`).
  - Centralised configuration for easy environment changes.

- **Styling**
  - Clean, responsive layout using a single CSS file (`css/style.css`).

---

## Tech Stack

| Layer | Technology |
|-------|------------|
| **Backend** | PHP 7.4+ |
| **Database** | MySQL / MariaDB |
| **Frontend** | HTML5, CSS3 (no external frameworks) |
| **Server** | Apache or Nginx with PHP-FPM |
| **Version Control** | Git (GitHub) |

---

## Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/yourusername/plant_store.git
   cd plant_store
   ```

2. **Create a MySQL database**

   ```sql
   CREATE DATABASE plantstore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. **Import the schema and sample data**

   ```bash
   mysql -u your_user -p plantstore < Database/plantstore.sql
   ```

4. **Configure the application**

   - Copy `config.sample.php` (if provided) to `config.php` and edit the constants:

     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'plantstore');
     define('DB_USER', 'YOUR_DB_USER');
     define('DB_PASS', 'YOUR_DB_PASSWORD');
     ```

   - Do the same for `admin/config.php` if it contains separate credentials.

5. **Set up the web server**

   - Point the document root to the project folder.
   - Ensure PHP has permission to read/write the directory (especially if you add file uploads later).

6. **Optional: Enable URL rewriting (Apache)**

   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteBase /
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond