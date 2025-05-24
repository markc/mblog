# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a complete Laravel 12 blog system with Filament 3.3 admin panel. The project uses:

-   **Laravel 12** as the core framework
-   **Filament 3.3** for admin panel and UI components (also used for public styling)
-   **Pest** for testing (not PHPUnit)
-   **Vite** with Tailwind CSS 4.0 for frontend assets
-   **SQLite** database (development)
-   **GitHub OAuth** via Laravel Socialite and Filament Socialite plugin
-   **Comprehensive blog features** with posts, pages, categories, tags, and settings

## Key Commands

### Development

```bash
# Start development server with all services
composer dev

# Start individual services
php artisan serve                    # Web server
php artisan queue:listen --tries=1  # Queue worker
php artisan pail --timeout=0        # Log viewer
npm run dev                          # Vite dev server

# Frontend asset building
npm run build                        # Production build
npm run dev                          # Development build with watch
```

### Testing

```bash
# Run all tests (uses Pest, not PHPUnit)
composer test
php artisan test

# Run specific test file
php artisan test tests/Feature/ExampleTest.php

# Run tests with coverage
php artisan test --coverage
```

### Code Quality

```bash
# Format code (Laravel Pint)
./vendor/bin/pint

# Check code style
./vendor/bin/pint --test
```

### Database

```bash
# Run migrations
php artisan migrate

# Reset database and run migrations
php artisan migrate:fresh

# Seed database with sample blog content
php artisan db:seed
```

### Filament Commands

```bash
# Create Filament user
php artisan make:filament-user

# Create Filament resource
php artisan make:filament-resource ModelName --generate

# Create Filament page
php artisan make:filament-page PageName

# Upgrade Filament (runs automatically via composer)
php artisan filament:upgrade
```

## Memories

- Always run pint before pushing to github

## Complete Implementation Guide

[Rest of the existing content remains the same...]