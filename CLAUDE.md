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
- To match Filament's warm gray colors (instead of Tailwind's blue-tinted grays), override the gray color palette in `resources/css/app.css` using Filament's exact OKLCH values in the `@theme` directive. This ensures the public pages have the same warm, professional color scheme as the Filament admin panel.
- For Tailwind CSS 4.0 dark mode toggle: Add `@custom-variant dark (&:where(.dark, .dark *));` to CSS, use Alpine.js `x-data` on `<html>` element with `darkMode` variable and `:class="{ 'dark': darkMode }"` binding. Theme switcher button should use `@click="darkMode = !darkMode"` to toggle the shared state. This follows Tailwind CSS 4.0's CSS-first configuration approach.
- When using Filament v4-beta after June 10 2025, review compatibility changes and test thoroughly before upgrading the project
- **Test Summary**: 
  - All tests are implemented using Pest testing framework
  - Test coverage command available to measure code coverage
  - Specific test files can be run individually
  - Tests cover various aspects of the blog system including feature and potentially unit tests
  - Recommended to maintain high test coverage for critical components like authentication, blog post creation, and admin panel functionality

## Complete Guide: Matching Filament Colors & Dark Mode Toggle

### Problem
When building public-facing pages for a Filament project, you often want the same professional look and feel. However, there are several compatibility challenges:

1. **Tailwind Version Mismatch**: Filament v3 uses Tailwind CSS v3, but Laravel 12 ships with Tailwind CSS v4
2. **Dark Mode Configuration Differences**: v3 uses `darkMode: 'class'` in JavaScript config, v4 uses `@custom-variant` in CSS
3. **Color System Differences**: Tailwind's default grays have blue undertones vs Filament's warm grays

**⚠️ Critical Issue**: This version mismatch is why dark mode toggles and color matching took extensive troubleshooting!

### Solution: Two-Part Implementation

#### Part 1: Filament Warm Gray Colors

**Step 1: Override Tailwind's Gray Palette**
Add Filament's exact warm gray colors to `resources/css/app.css`:

```css
@theme {
    /* Override gray colors with Filament's warm grays */
    --color-gray-50: oklch(98.3% 0.0016 106.89);
    --color-gray-100: oklch(96.2% 0.0014 106.89);
    --color-gray-200: oklch(92.8% 0.0016 106.89);
    --color-gray-300: oklch(87.1% 0.0018 106.89);
    --color-gray-400: oklch(71.7% 0.0015 106.89);
    --color-gray-500: oklch(57.0% 0.0015 106.89);
    --color-gray-600: oklch(45.7% 0.0014 106.89);
    --color-gray-700: oklch(36.4% 0.0013 106.89);
    --color-gray-800: oklch(27.5% 0.0011 106.89);
    --color-gray-900: oklch(19.7% 0.0009 106.89);
    --color-gray-950: oklch(13.1% 0.0006 106.89);
}
```

**Step 2: Use Proper Filament Color Hierarchy**
- **Background**: `dark:bg-gray-950` (very dark, like Filament sidebar)
- **Navbar**: `dark:bg-gray-900` (medium dark, like Filament topbar)  
- **Content Cards**: `dark:bg-gray-800` (widget-style backgrounds)
- **Borders**: `dark:ring-gray-700` for proper contrast

#### Part 2: Tailwind CSS 4.0 Dark Mode Toggle

**Step 1: Configure Dark Mode in CSS**
Add the custom variant directive to `resources/css/app.css`:

```css
@import 'tailwindcss';
@custom-variant dark (&:where(.dark, .dark *));
```

**Step 2: Setup HTML Element with Alpine.js**
Replace the `<html>` tag with Alpine.js dark mode state:

```html
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ 
          darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
      }" 
      x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      :class="{ 'dark': darkMode }">
```

**Step 3: Create Theme Switcher Button**
Simple button that toggles the shared state:

```html
<button @click="darkMode = !darkMode" class="fi-icon-btn fi-color-gray fi-icon-btn-size-md">
    <!-- Moon icon - show when in light mode -->
    <svg x-show="!darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
    </svg>
    <!-- Sun icon - show when in dark mode -->
    <svg x-show="darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
</button>
```

### Key Benefits
- **Perfect Color Matching**: Warm grays instead of blue-tinted ones
- **System Preference Support**: Respects user's OS dark mode setting
- **Persistent Theme**: Remembers user's choice in localStorage
- **No Flicker**: Alpine.js handles initial state before render
- **Icon Feedback**: Visual indication of current mode
- **Future-Proof**: Uses Tailwind CSS 4.0's CSS-first approach

### Version Compatibility Insights
**Why This Was Complex:**
- **Filament v3**: Uses Tailwind CSS v3 with `darkMode: 'class'` configuration
- **Laravel 12**: Ships with Tailwind CSS v4 using `@custom-variant` syntax
- **Mixed Environment**: Admin panel (Filament/v3) + Public pages (Laravel/v4) = different dark mode systems
- **Solution Required**: Bridge between v3 admin styling and v4 public page implementation

**Future Considerations:**
- **Filament v4**: Will support Tailwind CSS v4 natively
- **Current Workaround**: Use v4 syntax for public pages while Filament handles admin with v3
- **Alternative**: Downgrade entire project to Tailwind v3 for consistency (not recommended for new Laravel 12 projects)

### Troubleshooting
- **Dark mode not working**: Ensure `@custom-variant` is in CSS file
- **Colors still blue-tinted**: Verify OKLCH values are in `@theme` directive
- **Icons not switching**: Check `x-show` bindings use `darkMode` variable
- **Theme not persisting**: Confirm localStorage integration in HTML element

### Testing Checklist
- [ ] Page loads in correct theme (system preference)
- [ ] Theme switcher changes page colors immediately  
- [ ] Icons switch between moon/sun correctly
- [ ] Theme preference persists after page reload
- [ ] Colors match Filament admin panel exactly