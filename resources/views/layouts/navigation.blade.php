<nav x-data="{ open: false }" class="bg-white dark:bg-gray-950 border-b border-gray-200 dark:border-gray-800 filament-navbar">
    <div class="mx-auto max-w-screen-2xl px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-amber-600 hover:text-amber-500 dark:text-amber-500 dark:hover:text-amber-400">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:ms-10 sm:flex">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition {{ request()->routeIs('home') ? 'text-amber-600 dark:text-amber-500 filament-nav-link-active' : 'text-gray-500 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-500' }}">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            <span>Home</span>
                        </span>
                    </a>
                    <a href="{{ route('about') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition {{ request()->routeIs('about') ? 'text-amber-600 dark:text-amber-500 filament-nav-link-active' : 'text-gray-500 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-500' }}">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <span>About</span>
                        </span>
                    </a>
                    <a href="{{ route('blog') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition {{ request()->routeIs('blog') || request()->routeIs('blog.show') ? 'text-amber-600 dark:text-amber-500 filament-nav-link-active' : 'text-gray-500 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-500' }}">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd" />
                                <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z" />
                            </svg>
                            <span>Blog</span>
                        </span>
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-filament::dropdown placement="bottom-end">
                        <x-slot name="trigger">
                            <button type="button" class="inline-flex items-center justify-center gap-1 font-medium rounded-lg text-sm px-4 py-2 tracking-tight text-gray-500 bg-gray-50 hover:bg-gray-100 focus:bg-gray-100 dark:text-gray-400 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:bg-gray-800 focus:outline-none transition duration-75">
                                @if (auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full mr-2">
                                @endif
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </x-slot>

                        <x-filament::dropdown.list>
                            <x-filament::dropdown.list.item
                                icon="heroicon-m-user"
                                :href="route('filament.admin.auth.profile')"
                                tag="a"
                            >
                                Profile
                            </x-filament::dropdown.list.item>

                            @if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                                <x-filament::dropdown.list.item
                                    icon="heroicon-m-cog-6-tooth"
                                    :href="route('filament.admin.pages.dashboard')"
                                    tag="a"
                                >
                                    Dashboard
                                </x-filament::dropdown.list.item>
                            @endif

                            <x-filament::dropdown.list.item
                                icon="heroicon-m-arrow-left-on-rectangle"
                                :action="route('filament.admin.auth.logout')"
                                method="post"
                                tag="form"
                            >
                                Log out
                            </x-filament::dropdown.list.item>
                        </x-filament::dropdown.list>
                    </x-filament::dropdown>
                @else
                    <div class="flex space-x-2">
                        <a href="{{ route('filament.admin.auth.login') }}" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 dark:text-gray-200 dark:bg-gray-800 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-700">
                            Log in
                        </a>
                        <a href="{{ route('filament.admin.auth.register') }}" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white bg-amber-600 border-transparent hover:bg-amber-500 focus:bg-amber-700 focus:ring-offset-amber-700 dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-offset-amber-600">
                            Register
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'bg-amber-50 dark:bg-gray-800 text-amber-600 dark:text-amber-500' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-amber-600 dark:hover:text-amber-500' }} block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    <span>Home</span>
                </div>
            </a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'bg-amber-50 dark:bg-gray-800 text-amber-600 dark:text-amber-500' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-amber-600 dark:hover:text-amber-500' }} block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <span>About</span>
                </div>
            </a>
            <a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') || request()->routeIs('blog.show') ? 'bg-amber-50 dark:bg-gray-800 text-amber-600 dark:text-amber-500' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-amber-600 dark:hover:text-amber-500' }} block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd" />
                        <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z" />
                    </svg>
                    <span>Blog</span>
                </div>
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            @auth
                <div class="flex items-center px-4">
                    @if (auth()->user()->avatar)
                        <div class="shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full" src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}">
                        </div>
                    @endif
                    <div>
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('filament.admin.auth.profile') }}" class="text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-amber-600 dark:hover:text-amber-500 block w-full ps-3 pe-4 py-2 text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            <span>Profile</span>
                        </div>
                    </a>

                    @if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                        <a href="{{ route('filament.admin.pages.dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-amber-600 dark:hover:text-amber-500 block w-full ps-3 pe-4 py-2 text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm14 1a1 1 0 11-2 0 1 1 0 012 0zM2 13a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zm14 1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                                </svg>
                                <span>Dashboard</span>
                            </div>
                        </a>
                    @endif

                    <form method="POST" action="{{ route('filament.admin.auth.logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-amber-600 dark:hover:text-amber-500 block w-full ps-3 pe-4 py-2 text-start text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V7.414l-5.707-5.707a1 1 0 00-1.414 0L3 7.414V3zm2 7.414l5.293-5.293a1 1 0 011.414 0L17 10.414V19H5V10.414z" clip-rule="evenodd" />
                                </svg>
                                <span>Log Out</span>
                            </div>
                        </button>
                    </form>
                </div>
            @else
                <div class="space-y-2 p-4">
                    <a href="{{ route('filament.admin.auth.login') }}" class="filament-button filament-button-size-md w-full inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 dark:text-gray-200 dark:bg-gray-800 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-700">
                        Log in
                    </a>
                    <a href="{{ route('filament.admin.auth.register') }}" class="filament-button filament-button-size-md w-full inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white bg-amber-600 border-transparent hover:bg-amber-500 focus:bg-amber-700 focus:ring-offset-amber-700 dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-offset-amber-600">
                        Register
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>