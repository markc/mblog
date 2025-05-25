<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ 
          darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
      }" 
      x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' : '' }}{{ \App\Models\Setting::get('site_name', 'My Blog') }}</title>
    
    @if(isset($metaDescription))
    <meta name="description" content="{{ $metaDescription }}">
    @else
    <meta name="description" content="{{ \App\Models\Setting::get('site_description', 'A blog built with Laravel and Filament') }}">
    @endif

    <!-- Filament Styles -->
    @filamentStyles
    @vite('resources/css/app.css')
    
    <style>
        :root {
            --primary-color: {{ \App\Models\Setting::get('header_color', '#f59e0b') }};
        }
        
        .fi-color-custom {
            --c-50: {{ \App\Models\Setting::get('header_color', '#f59e0b') }}1a;
            --c-400: {{ \App\Models\Setting::get('header_color', '#f59e0b') }};
            --c-500: {{ \App\Models\Setting::get('header_color', '#f59e0b') }};
            --c-600: {{ \App\Models\Setting::get('header_color', '#f59e0b') }};
        }
    </style>
</head>
<body class="fi-body fi-panel-app min-h-screen bg-gray-50 font-normal text-gray-950 antialiased dark:bg-gray-950 dark:text-white">
    <!-- Top Navigation Bar -->
    <nav class="fi-topbar sticky top-0 z-50 border-b border-gray-200 bg-white px-4 md:px-6 lg:px-8 dark:border-white/10 dark:bg-gray-900" x-data="{ mobileMenuOpen: false }">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between overflow-visible">
            <!-- Logo / Site Name -->
            <div class="flex items-center">
                <a href="{{ route('blog.index') }}" class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ \App\Models\Setting::get('site_name', 'My Blog') }}
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 md:flex">
                <a href="{{ route('blog.index') }}" 
                   class="fi-link fi-link-size-md fi-color-gray transition duration-75 hover:text-gray-500 dark:hover:text-gray-400 {{ request()->routeIs('blog.index') ? 'text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-200' }}">
                    Home
                </a>
                
                <!-- Blog Dropdown -->
                <div class="relative" x-data="{ open: false }" x-on:click.away="open = false">
                    <button x-on:click="open = !open" 
                            class="fi-link fi-link-size-md fi-color-gray transition duration-75 hover:text-gray-500 dark:hover:text-gray-400 {{ request()->routeIs('blog.*') ? 'text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-200' }} flex items-center focus:outline-none">
                        Blog
                        <svg class="ml-1 h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute left-0 z-[9999] mt-2 w-48 origin-top-left rounded-md bg-white py-1 shadow-xl ring-1 ring-black ring-opacity-5 dark:bg-gray-900 dark:ring-white/20 border border-gray-200 dark:border-gray-700"
                         style="display: none;">
                        <a href="{{ route('blog.index') }}" 
                           class="block px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-800 {{ request()->routeIs('blog.index') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400' : '' }}">
                            All Posts
                        </a>
                        <hr class="my-1 border-gray-200 dark:border-gray-600">
                        @foreach(\App\Models\Category::get() as $category)
                        <a href="{{ route('blog.category', $category) }}" 
                           class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 dark:text-gray-100 dark:hover:bg-gray-800 {{ request()->route('category')?->slug === $category->slug ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400' : '' }}">
                            {{ $category->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                
                @foreach(\App\Models\Page::published()->take(3)->get() as $page)
                <a href="{{ route('page.show', $page) }}" 
                   class="fi-link fi-link-size-md fi-color-gray transition duration-75 hover:text-gray-500 dark:hover:text-gray-400 {{ request()->route('page')?->slug === $page->slug ? 'text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-200' }}">
                    {{ $page->title }}
                </a>
                @endforeach
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" x-on:click="mobileMenuOpen = !mobileMenuOpen" 
                        class="fi-icon-btn fi-color-gray fi-icon-btn-size-md flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Theme Switcher & Social Links -->
            <div class="hidden items-center space-x-4 md:flex">
                <!-- Theme Switcher -->
                <button @click="darkMode = !darkMode" class="fi-icon-btn fi-color-gray fi-icon-btn-size-md">
                    <!-- Moon icon - show when in light mode (click to go dark) -->
                    <svg x-show="!darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <!-- Sun icon - show when in dark mode (click to go light) -->
                    <svg x-show="darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
                <a href="https://github.com/markc/mblog" target="_blank" 
                   class="fi-icon-btn fi-color-gray fi-icon-btn-size-md">
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-300" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="fill: currentColor;">
                        <title>GitHub</title>
                        <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
                    </svg>
                </a>
                
                <a href="https://goldcoast.org" target="_blank" 
                   class="fi-icon-btn fi-color-gray fi-icon-btn-size-md">
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-300" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="fill: currentColor;">
                        <title>Nextcloud</title>
                        <path d="M12.018 6.537c-2.5 0-4.6 1.712-5.241 4.015-.56-1.232-1.793-2.105-3.225-2.105A3.569 3.569 0 0 0 0 12a3.569 3.569 0 0 0 3.552 3.553c1.432 0 2.664-.874 3.224-2.106.641 2.304 2.742 4.016 5.242 4.016 2.487 0 4.576-1.693 5.231-3.977.569 1.21 1.783 2.067 3.198 2.067A3.568 3.568 0 0 0 24 12a3.569 3.569 0 0 0-3.553-3.553c-1.416 0-2.63.858-3.199 2.067-.654-2.284-2.743-3.978-5.23-3.977zm0 2.085c1.878 0 3.378 1.5 3.378 3.378 0 1.878-1.5 3.378-3.378 3.378A3.362 3.362 0 0 1 8.641 12c0-1.878 1.5-3.378 3.377-3.378zm-8.466 1.91c.822 0 1.467.645 1.467 1.468s-.644 1.467-1.467 1.468A1.452 1.452 0 0 1 2.085 12c0-.823.644-1.467 1.467-1.467zm16.895 0c.823 0 1.468.645 1.468 1.468s-.645 1.468-1.468 1.468A1.452 1.452 0 0 1 18.98 12c0-.823.644-1.467 1.467-1.467z"/>
                    </svg>
                </a>
                
                <!-- Admin Link -->
                <a href="/admin" 
                   class="fi-btn fi-color-primary fi-btn-size-md fi-size-md gap-1.5 px-3 py-2 text-sm font-semibold shadow-sm">
                    Admin
                </a>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" x-collapse class="border-t border-gray-200 pb-3 pt-4 dark:border-white/10 md:hidden">
            <div class="space-y-1">
                <a href="{{ route('blog.index') }}" 
                   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                    Home
                </a>
                
                <!-- Mobile Blog Dropdown -->
                <div x-data="{ mobileOpen: false }">
                    <button x-on:click="mobileOpen = !mobileOpen" 
                            class="flex w-full items-center justify-between px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white focus:outline-none">
                        Blog
                        <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': mobileOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div x-show="mobileOpen" x-collapse class="ml-4 space-y-1">
                        <a href="{{ route('blog.index') }}" 
                           class="block px-3 py-2 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white {{ request()->routeIs('blog.index') ? 'text-primary-600 dark:text-primary-400' : '' }}">
                            All Posts
                        </a>
                        @foreach(\App\Models\Category::get() as $category)
                        <a href="{{ route('blog.category', $category) }}" 
                           class="block px-3 py-2 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white {{ request()->route('category')?->slug === $category->slug ? 'text-primary-600 dark:text-primary-400' : '' }}">
                            {{ $category->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                
                @foreach(\App\Models\Page::published()->take(3)->get() as $page)
                <a href="{{ route('page.show', $page) }}" 
                   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                    {{ $page->title }}
                </a>
                @endforeach
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="mx-auto max-w-7xl px-4 py-8 md:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-white px-4 py-12 md:px-6 lg:px-8 dark:border-white/10 dark:bg-gray-900">
        <div class="mx-auto max-w-7xl">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ \App\Models\Setting::get('site_name', 'My Blog') }}
                    </h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        {{ \App\Models\Setting::get('site_description', 'A blog built with Laravel and Filament') }}
                    </p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Categories</h3>
                    <ul class="mt-2 space-y-1">
                        @foreach(\App\Models\Category::take(5)->get() as $category)
                        <li>
                            <a href="{{ route('blog.category', $category) }}" 
                               class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pages</h3>
                    <ul class="mt-2 space-y-1">
                        @foreach(\App\Models\Page::published()->get() as $page)
                        <li>
                            <a href="{{ route('page.show', $page) }}" 
                               class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                {{ $page->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <div class="mt-8 border-t border-gray-200 pt-8 dark:border-white/10">
                <p class="text-center text-gray-500 dark:text-gray-400">
                    © {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'My Blog') }}. Built with Laravel & Filament.
                </p>
            </div>
        </div>
    </footer>

    <!-- Filament Scripts -->
    @filamentScripts
    @vite('resources/js/app.js')
    
</body>
</html>