# Namitembo Technical College - E-Library Management System

A Laravel 12 based digital campus management system for Namitembo Technical College. The application provides role-based access for Administrators and Students, a centralized resource library, profile management with avatars, and a clean, branded user interface.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation & Setup](#installation--setup)
- [Database Migrations](#database-migrations)
- [Default Roles & Access](#default-roles--access)
- [Application Structure](#application-structure)
- [Usage Guide](#usage-guide)
- [File Uploads & Storage](#file-uploads--storage)
- [Assets & Frontend](#assets--frontend)
- [Testing](#testing)
- [License](#license)

## Overview

Namitembo E-Library is designed to digitize resource sharing between departments. Administrators manage students, upload learning materials, and maintain the library. Students can browse resources filtered by department and type, preview materials in-browser (PDFs and videos), download files, and manage their own profiles with optional profile photos.

## Features

### Authentication & Authorization
- Email/password authentication (Laravel Breeze style flows)
- Role-based access control (`admin` and `student`) with middleware protection
- Email verification support
- Password update and account deletion from profile page

### Admin Panel
- Dashboard with overview of library activity
- Student Management: View, edit, delete student accounts; update student profile photos
- Resource Library Management: Upload, view, edit, delete learning materials
- Filter resources by department, type, and search
- Preview resources in modal (PDF via iframe, video via HTML5 video tag)
- Manage own admin profile and photo

### Student Portal
- Personalized dashboard with resources relevant to their department
- Library browsing with search and type filters (PDF, video, presentation, document, image)
- Resource detail view with preview and download options
- In-browser preview modal for supported types
- Profile management with photo upload/remove, password change
- Avatar system with initials fallback when no photo is uploaded

### UI/UX
- Branded design with Namitembo colors (navy, gold, etc.)
- Responsive layouts for admin and student areas
- Icon system and reusable components
- Custom CSS and JS in `public/assets/`

## Tech Stack

- **Framework**: [Laravel 12](https://laravel.com/)
- **PHP**: ^8.2
- **Authentication**: Laravel Breeze
- **Frontend**: Blade templates, Bootstrap (Rizz theme assets), Alpine.js, Vite
- **Storage**: Local/public disk for uploads
- **Database**: MySQL/SQLite/Postgres (configurable via `.env`)

## Requirements

- PHP >= 8.2 with extensions: `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`
- Composer
- Node.js & NPM
- A web server (Apache/Nginx) or use `php artisan serve`
- Database server

## Installation & Setup

1. **Clone the repository**
```bash
git clone <repository-url>
cd namitembo_e_library
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node dependencies**
```bash
npm install
```

4. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=namitembo_e_library
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Run migrations**
```bash
php artisan migrate
```

6. **Create storage link**
```bash
php artisan storage:link
```

7. **Build assets (production) or run dev server**
```bash
# Development
npm run dev

# Production
npm run build
```

8. **Start the application**
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Database Migrations

Key migrations included:
- `0001_01_01_000000_create_users_table.php` - Users table with `role` (student/admin) and `department` (ICT, FBW, CJ, TFD, BL)
- `2026_10_18_000000_create_materials_table.php` - Materials/resources table
- `2026_10_18_112059_add_profile_photo_to_users_table.php` - Adds `profile_photo_path` to users
- Additional migrations for roles/departments and sessions/password resets

## Default Roles & Access

After seeding or manual setup, create users with appropriate roles:
- **Admin**: Access to `/admin/*` - manage students, manage library, preview all resources
- **Student**: Access to `/student/*` - view department-specific resources, manage own profile

Middleware enforces role-based access. Unauthenticated users can access welcome, login, and register pages.

## Application Structure

```
app/
├── Http/Controllers/
│   ├── Admin/           # Admin controllers (Dashboard, Student, Material)
│   ├── Student/         # Student controllers
│   ├── ProfileController.php
│   ├── MaterialViewerController.php
│   └── Auth/            # Breeze auth controllers
├── Models/
│   ├── User.php         # Has role, department, profile_photo_path
│   └── Material.php
database/migrations/     # Schema definitions
resources/
├── views/
│   ├── admin/           # Admin panel views
│   ├── student/         # Student portal views
│   ├── auth/            # Auth views
│   ├── profile/         # Profile edit
│   ├── shared/          # Shared components (avatar, modal, icons)
│   └── layouts/         # Layout templates
public/
├── assets/              # CSS/JS/libs/fonts from theme
└── images/              # Logos and images
```

## Usage Guide

### For Administrators
1. Log in as admin → redirected to Admin Dashboard
2. **Manage Students**: Go to Students → view list, edit details, upload/remove profile photos, delete accounts
3. **Manage Library**: Go to Resource Library → Upload Material (title, department, type, description, file), Preview, Edit, or Delete resources
4. **Profile**: Update name/email/photo from Profile page

### For Students
1. Log in as student → redirected to Student Dashboard (shows department resources)
2. **Browse Library**: Filter by type or search; click Preview to view in modal or Open to view details
3. **View/Download**: PDFs/videos can be previewed in-browser; other file types may need to be downloaded and opened locally
4. **Profile**: Update personal details, change password, upload/remove profile photo

## File Uploads & Storage

- **Materials**: Stored in `storage/app/public/materials/` (max 100MB)
- **Profile Photos**: Stored in `storage/app/public/profile-photos/` (images, max 2MB)
- Run `php artisan storage:link` to make files accessible via `/storage/`

The `MaterialViewerController` serves files with appropriate MIME types and inline disposition for browser preview where supported.

## Assets & Frontend

- Theme assets loaded from `public/assets/` (CSS, JS, fonts, icons)
- Vite configured for `resources/css/app.css` and `resources/js/app.js`
- Custom styles in `public/assets/css/custom.css`
- Preview modal handled by `public/assets/js/custom.js`
- Logos stored in `public/images/` (PNG/SVG)

## Testing

Run tests with Pest/PHPUnit:
```bash
php artisan test
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
