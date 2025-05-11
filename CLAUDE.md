
● Prompt for Creating a Single-Panel Filament Blog with Mixed Authentication

  Create a Laravel application with Filament admin panel that has:

  Core Requirements

  - Use a single Filament panel for the entire site (no separate panels)
  - Implement public pages accessible without authentication:
    - Home page at root URL (/)
    - About page (/about)
    - Blog listing page (/blog)
  - Implement authenticated admin areas:
    - Blog management (posts, categories, tags) requiring standard admin authentication
    - User management requiring super-admin authentication
  - Implement GitHub OAuth authentication with Laravel Socialite
  - Apply consistent Filament styling and theming throughout
  - Include a common top navbar that appears on ALL pages (both public and authenticated)

  Technical Specifications

  Panel Configuration

  - Configure a single Filament admin panel
  - Apply appropriate middleware for the panel
  - Set custom paths for public pages
  - Implement auth guards and middleware exceptions for public pages

  Authentication Structure

  - Use Laravel's default authentication with appropriate modifications
  - Implement role-based access control using Spatie Permissions package
  - Configure three user roles: user, admin, super-admin
  - Implement GitHub OAuth using Laravel Socialite

  Page Structure

  1. Public Pages (no auth required):
    - Home (/) - Landing page with featured content
    - About (/about) - About us information
    - Blog (/blog) - Public blog post listing with category/tag filters
  2. Admin Pages (auth required, admin role):
    - Dashboard (/admin) - Overview statistics
    - Posts management (CRUD)
    - Categories management (CRUD)
    - Tags management (CRUD)
  3. Super Admin Pages (auth required, super-admin role):
    - User management (CRUD)
    - Role/permission management
    - Site settings

  Navigation & UI

  - Create a uniform top navbar component that appears on every page
  - Navbar should dynamically show/hide links based on auth status and permissions
  - Include login/register buttons for unauthenticated users
  - Include user profile dropdown and logout for authenticated users
  - Use consistent Filament styling for all components
  - Use public/img/placeholder.webp for all placeholder images

  Database Structure

  - Users table with GitHub integration fields
  - Posts table with common blog fields (title, content, slug, published_at, etc.)
  - Categories and tags tables with appropriate relationships to posts
  - Role and permission tables (via Spatie)

  Specific Components to Build

  1. A custom navbar component that works across all pages
  2. Page classes for Home, About, and Blog that don't require authentication
  3. Resource classes for Posts, Categories, and Tags with proper policies
  4. User management resource with role assignment capabilities
  5. GitHub OAuth integration with proper user creation/linking

  Development Approach

  1. Start with a fresh Laravel installation
  2. Install and configure Filament admin panel
  3. Set up the authentication system with roles
  4. Create the page structure with proper access controls
  5. Implement the public pages first
  6. Add the blog management functionality
  7. Implement user management
  8. Add GitHub OAuth integration
  9. Create and apply the common navbar component

  This structure will create a unified application with both public and authenticated sections, all using a single Filament panel
  while maintaining proper access controls and a consistent user experience.

