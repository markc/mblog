# Laravel Filament Blog System

[![Laravel Pint](https://github.com/markc/mblog/actions/workflows/pint.yml/badge.svg)](https://github.com/markc/mblog/actions/workflows/pint.yml)

A comprehensive blog platform built with Laravel 12 and Filament 3.3, featuring a fully integrated admin panel, GitHub OAuth authentication, and consistent theming throughout both admin and public pages.

## ✨ Features

### 🏠 Public Features
- **Blog Posts**: Browse published posts with categories and tags
- **Standalone Pages**: Static pages like About, Contact, etc.
- **Category & Tag Archives**: Filter posts by category or tag
- **Responsive Design**: Mobile-first design using Tailwind CSS
- **Dark Mode Toggle**: Persistent theme switching with localStorage
- **Professional Styling**: Uses Filament's exact color palette and components

### 🛡️ Admin Features (Filament Panel)
- **Content Management**: Create, edit, and publish blog posts and pages
- **Rich Text Editor**: Advanced content editing with Filament's RichEditor
- **Category & Tag Management**: Organize content with hierarchical categories
- **User Management**: Handle user accounts and permissions
- **Site Settings**: Configure site-wide options including layout and social links
- **GitHub OAuth**: Secure authentication via GitHub Socialite integration
- **Media Management**: Upload and manage featured images

### 🎨 Theming Excellence
- **Unified Color Palette**: Exact OKLCH color matching between admin and public pages
- **Consistent Components**: Filament-style buttons, cards, and navigation throughout
- **Professional Appearance**: Corporate-grade design suitable for business blogs
- **Theme Persistence**: Dark/light mode preferences saved across sessions

## 🏗️ Technical Architecture

### Core Technologies
- **Laravel 12**: Latest PHP framework with enhanced performance
- **Filament 3.3**: Modern admin panel with TALL stack (Tailwind, Alpine, Livewire, Laravel)
- **Tailwind CSS 4.0**: Latest utility-first CSS framework
- **Alpine.js**: Lightweight JavaScript framework for interactivity
- **SQLite/MySQL/PostgreSQL**: Flexible database support

### Key Packages
- `filament/filament` - Admin panel framework
- `laravel/socialite` - OAuth authentication
- `dutchcodingcompany/filament-socialite` - GitHub OAuth integration for Filament
- `pestphp/pest` - Modern testing framework
- `laravel/pint` - Code style fixer

## 🚀 Quick Start

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd mblog
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=sqlite
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=mblog
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

5. **GitHub OAuth Setup**
   
   Create a GitHub OAuth App at https://github.com/settings/applications/new
   
   Add to `.env`:
   ```env
   GITHUB_CLIENT_ID=your_github_client_id
   GITHUB_CLIENT_SECRET=your_github_client_secret
   ```

6. **Run migrations and seed data**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Create admin user**
   ```bash
   php artisan make:filament-user
   ```

8. **Build assets and start development**
   ```bash
   npm run build
   php artisan serve
   ```

Visit:
- Public blog: http://localhost:8000
- Admin panel: http://localhost:8000/admin

## 🎨 Critical Theming Implementation

### The Challenge: Filament v3 + Tailwind v4 Compatibility

This project solves a critical compatibility issue between Filament v3 (which uses Tailwind CSS v3) and Laravel 12 (which ships with Tailwind CSS v4). Without proper handling, this results in:

- ❌ Blue-tinted colors instead of Filament's warm grays
- ❌ Non-functional dark mode toggle
- ❌ Inconsistent styling between admin and public pages

### The Solution: OKLCH Color Override + Modern Dark Mode

#### 1. Color Palette Unification (`resources/css/app.css`)

```css
@custom-variant dark (&:where(.dark, .dark *));

@theme {
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

#### 2. Alpine.js Dark Mode Implementation

```html
<html x-data="{ 
    darkMode: localStorage.getItem('theme') === 'dark' || 
             (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
}" 
x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
:class="{ 'dark': darkMode }">
```

#### 3. Component Styling Strategy

- **Navigation**: Filament-style buttons with `fi-btn` classes
- **Cards**: Dark mode backgrounds using `dark:bg-gray-800` to match Filament widgets
- **Icons**: Inline SVG with forced colors for consistent appearance
- **Typography**: Proper contrast ratios with `text-gray-600 dark:text-gray-300`

### Future-Proofing for Filament v4

When Filament v4 releases with native Tailwind v4 support:

1. **Remove OKLCH overrides** from `app.css` as they'll be redundant
2. **Keep Alpine.js implementation** as it provides superior UX
3. **Maintain component structure** as Filament's design language will remain consistent
4. **Update dependencies** and test thoroughly

## 📁 Project Structure

```
├── app/
│   ├── Filament/
│   │   ├── Pages/Settings.php           # Site configuration panel
│   │   └── Resources/                   # Admin CRUD interfaces
│   ├── Http/Controllers/                # Public page controllers
│   └── Models/                          # Eloquent models
├── database/
│   ├── migrations/                      # Database schema
│   └── seeders/BlogSeeder.php          # Sample content
├── resources/
│   ├── css/app.css                     # Critical theming overrides
│   └── views/                          # Blade templates
└── routes/web.php                      # Application routes
```

## 🔧 Key Components

### Models & Relationships
- **User**: Extended with GitHub OAuth fields
- **Post**: Blog posts with categories, tags, and featured images
- **Category**: Hierarchical post organization
- **Tag**: Flexible content tagging
- **Page**: Standalone static pages
- **Setting**: Key-value site configuration

### Filament Resources
- **PostResource**: Rich post editing with automatic slug generation
- **PageResource**: Simple page management
- **CategoryResource & TagResource**: Content organization
- **Settings Page**: Site-wide configuration interface

### Public Controllers
- **BlogController**: Homepage and category/tag archives
- **PostController**: Individual post display
- **PageController**: Static page rendering

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test
php artisan test --filter=ExampleTest
```

## 🎯 Development Workflow

### Before Every Commit
```bash
# Format code
php artisan pint

# Run tests
php artisan test

# Build assets
npm run build
```

### Adding New Features
1. Create/update models and migrations
2. Build Filament resources for admin interface
3. Create public controllers and views
4. Maintain theming consistency using established patterns
5. Add tests for new functionality

## 🌟 Styling Guidelines

### Color Usage
- **Primary**: Amber colors (`amber-500`, `amber-600`) for CTAs and links
- **Gray**: Use the overridden OKLCH values for consistent appearance
- **Backgrounds**: `dark:bg-gray-800` for content cards to match Filament

### Component Patterns
- **Buttons**: Use `fi-btn` classes for consistency with admin panel
- **Cards**: Follow Filament's shadow and border patterns
- **Forms**: Leverage Filament form components where possible
- **Navigation**: Maintain dropdown and mobile menu patterns

### Dark Mode Best Practices
- Always provide dark variants for custom colors
- Test thoroughly in both light and dark modes
- Use `ring-gray-700` for focus states in dark mode
- Ensure sufficient contrast ratios for accessibility

## 📚 Documentation

- **CLAUDE.md**: Comprehensive implementation guide and troubleshooting
- **Database Schema**: See migration files for complete structure
- **API Documentation**: Generated from code comments

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Follow the established coding standards
4. Run tests and Pint before committing
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🆘 Support

For issues related to:
- **Filament**: Check the [Filament documentation](https://filamentphp.com/docs)
- **Laravel**: Refer to [Laravel documentation](https://laravel.com/docs)
- **Theming**: See `CLAUDE.md` for detailed implementation notes

---

Built with ❤️ using Laravel 12 and Filament 3.3