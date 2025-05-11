<x-layouts.public>
    <!-- Hero Section -->
    <div class="filament-card rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 mb-6">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 p-4">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Welcome to our Blog</h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                    Discover the latest insights, tutorials, and news on our platform. Stay updated with the newest content from our expert writers.
                </p>
                <a href="{{ route('blog') }}" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white bg-amber-600 border-transparent hover:bg-amber-500 focus:bg-amber-700 focus:ring-offset-amber-700 dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-offset-amber-600">
                    Explore Blog
                </a>
            </div>
            <div class="md:w-1/2 p-4">
                <img src="{{ asset('img/placeholder.webp') }}" alt="Blog Hero" class="w-full h-auto rounded-lg shadow-md">
            </div>
        </div>
    </div>

    <!-- Featured Posts Section -->
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Featured Posts</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @forelse($featuredPosts as $post)
            <div class="filament-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden">
                <img src="{{ $post->featured_image ?? asset('img/placeholder.webp') }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                        <span class="filament-badge inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-amber-700 bg-amber-500/10 dark:text-amber-500">{{ $post->category->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $post->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $post->excerpt }}</p>
                    <a href="{{ route('blog.show', $post->slug) }}" class="filament-link inline-flex items-center justify-center gap-1 font-medium outline-none hover:underline focus:underline text-amber-600 hover:text-amber-500 dark:text-amber-500 dark:hover:text-amber-400">
                        Read more →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 filament-card rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="flex items-center justify-center p-6 text-center">
                    <div>
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-medium">No featured posts available</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Check back later for featured content</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Recent Posts Section -->
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Recent Posts</h2>
    <div class="filament-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse($recentPosts as $post)
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row">
                        <div class="sm:w-1/4 mb-4 sm:mb-0 sm:mr-6">
                            <img src="{{ $post->featured_image ?? asset('img/placeholder.webp') }}" alt="{{ $post->title }}" class="w-full h-32 object-cover rounded-lg">
                        </div>
                        <div class="sm:w-3/4">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                                <span class="filament-badge inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-amber-700 bg-amber-500/10 dark:text-amber-500">{{ $post->category->name }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $post->title }}</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $post->excerpt }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($post->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $post->user->name }}" class="h-8 w-8 rounded-full mr-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $post->user->name }}</span>
                                </div>
                                <a href="{{ route('blog.show', $post->slug) }}" class="filament-link inline-flex items-center justify-center gap-1 font-medium outline-none hover:underline focus:underline text-amber-600 hover:text-amber-500 dark:text-amber-500 dark:hover:text-amber-400">
                                    Read more →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6">
                    <div class="flex items-center justify-center p-6 text-center">
                        <div>
                            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h2 class="text-lg font-medium">No recent posts available</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Check back later for new content</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('blog') }}" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 dark:text-gray-200 dark:bg-gray-800 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-700">
            View All Posts
        </a>
    </div>
</x-layouts.public>