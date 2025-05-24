<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
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
    <nav class="fi-topbar sticky top-0 z-50 border-b border-gray-200 bg-white px-4 md:px-6 lg:px-8 dark:border-white/10 dark:bg-gray-900">
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
                <button type="button" x-data x-on:click="$refs.mobileMenu.classList.toggle('hidden')" 
                        class="fi-icon-btn fi-color-gray fi-icon-btn-size-md flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Social Links -->
            <div class="hidden items-center space-x-4 md:flex">
                @if(\App\Models\Setting::get('social_github'))
                <a href="{{ \App\Models\Setting::get('social_github') }}" target="_blank" 
                   class="fi-icon-btn fi-color-gray fi-icon-btn-size-md">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
                @endif
                
                @if(\App\Models\Setting::get('social_twitter'))
                <a href="{{ \App\Models\Setting::get('social_twitter') }}" target="_blank" 
                   class="fi-icon-btn fi-color-gray fi-icon-btn-size-md">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h4a1 1 0 011 1v2M7 4h10l-1 16H8L7 4z" />
                    </svg>
                </a>
                @endif
                
                <!-- Admin Link -->
                <a href="/admin" 
                   class="fi-btn fi-color-primary fi-btn-size-md fi-size-md gap-1.5 px-3 py-2 text-sm font-semibold shadow-sm">
                    Admin
                </a>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-ref="mobileMenu" class="hidden border-t border-gray-200 pb-3 pt-4 dark:border-white/10 md:hidden">
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
    
    <!-- Ensure Alpine.js is available -->
    <script>
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js is ready');
        });
    </script>
</body>
</html>