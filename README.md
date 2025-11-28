# DKS Web Application

## Overview
This is a web application for **Lembaga Sertifikasi Profesi (LSP)**. It manages certifications (skema), blogs, and user profiles. The system includes a public-facing frontend and a secure admin dashboard.

## Features

### 1. Public Frontend
-   **Home**: Landing page with carousel, about us, vision/mission, and latest updates.
-   **Sertifikasi**: List of available certification schemes.
-   **Blog**: News and articles.
-   **Profile**: User profile page.
-   **Authentication**: User registration and login.

### 2. Admin Dashboard
-   **Secure Access**: Only accessible by Super Admins.
-   **Obfuscated Path**: Admin panel is accessed via a secret URL prefix (e.g., `/secure-panel/admin`) to prevent unauthorized scanning.
-   **Dashboard**: Overview of total blogs and schemes.
-   **Blog Management**: Create, edit, delete, and publish blog posts. Support for rich text editing and image uploads.
-   **Scheme Management**: Manage certification schemes (Skema), including details, requirements, and assessment methods.
-   **Photo Management**: Manage gallery photos for the homepage carousel.
-   **Admin Management**: Manage other admin accounts.

### 3. Security & Architecture
-   **URL Rewriting**: `.php` extensions are removed from URLs for a cleaner look (e.g., `/login` instead of `/login.php`).
-   **Role-Based Access Control (RBAC)**:
    -   **Regular Users**: Can access public pages and their profile.
    -   **Super Admins**: Can access the Admin Dashboard and management features.
-   **Session Management**: Secure session handling for user authentication.
-   **Database**: MySQL database for storing data.

## Workflow & System Logic

### Authentication Flow
1.  **Registration**: Users sign up via `/register`. Passwords are hashed using `password_hash`.
2.  **Login**: Users log in via `/login`.
    -   **Regular Users**: Redirected to `/index` (Home).
    -   **Super Admins**: Redirected to the secret admin dashboard URL (configured in `config.php`).
3.  **Logout**: Users log out via `/logout`, which destroys the session and redirects to login.

### Admin Access
-   The admin path is hidden. To access it, you must know the `ADMIN_PATH_PREFIX` defined in `config/config.php`.
-   Example: If prefix is `secure-panel`, the admin URL is `http://yourdomain.com/secure-panel/admin`.
-   Attempting to access `/admin.php` directly without the prefix (or without being logged in as Super Admin) will redirect to the login page or home page.

### Content Management
-   **Blogs**: Admins can draft posts and publish them later. Images are handled securely.
-   **Schemes**: Comprehensive management of certification schemes, including related data like requirements and units of competency.

## Configuration
-   **Database**: Configured in `config/config.php`.
-   **Admin Prefix**: Change `ADMIN_PATH_PREFIX` in `config/config.php` to rotate the secret admin URL.
-   **Super Admin**: The email address for the Super Admin is defined in `config/config.php`.

## Installation
1.  Import the database SQL file (`dks.sql`).
2.  Configure database credentials in `config/config.php`.
3.  Set up the web server (Apache) to support `.htaccess` for URL rewriting.
