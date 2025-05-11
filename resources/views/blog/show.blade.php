<x-layouts.public>
    <div class="filament-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 mb-6">
        <div class="p-6">
            <!-- Back to Blog -->
            <div class="mb-6">
                <a href="{{ route('blog') }}" class="filament-link inline-flex items-center justify-center gap-1 font-medium outline-none hover:underline focus:underline text-gray-600 hover:text-amber-600 dark:text-gray-400 dark:hover:text-amber-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back to Blog</span>
                </a>
            </div>

            <!-- Post Header -->
            <div class="mb-8">
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <a href="{{ route('blog', ['category' => $post->category->slug]) }}" class="filament-badge inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-amber-700 bg-amber-500/10 dark:text-amber-500">
                        {{ $post->category->name }}
                    </a>
                    <span class="mx-2">•</span>
                    <span>{{ $post->published_at->format('M d, Y') }}</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $post->title }}</h1>

                <!-- Author Info -->
                <div class="flex items-center mb-6">
                    <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($post->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $post->user->name }}" class="h-10 w-10 rounded-full mr-3">
                    <div>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $post->user->name }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Author</p>
                    </div>
                </div>

                <!-- Featured Image -->
                @if($post->featured_image)
                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-auto object-cover rounded-lg mb-8">
                @else
                    <img src="{{ asset('img/placeholder.webp') }}" alt="{{ $post->title }}" class="w-full h-auto object-cover rounded-lg mb-8">
                @endif
            </div>

            <!-- Post Content -->
            <div class="prose prose-amber dark:prose-invert max-w-none mb-8">
                {!! $post->content !!}
            </div>

            <!-- Tags -->
            @if($post->tags->count() > 0)
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('blog', ['tag' => $tag->slug]) }}" class="filament-badge inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-primary-700 bg-primary-500/10 dark:text-primary-500">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Share Links -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-8 mb-8">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Share this post</h3>
                <div class="flex space-x-4">
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(route('blog.show', $post->slug)) }}" target="_blank" rel="noopener noreferrer" aria-label="Share on Twitter" class="transition-colors p-2 rounded-full bg-gray-100 hover:bg-blue-100 text-gray-600 hover:text-blue-600 dark:bg-gray-800 dark:hover:bg-blue-900 dark:text-gray-400 dark:hover:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.016 10.016 0 01-3.127 1.195 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.937 4.937 0 004.604 3.417 9.868 9.868 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 002.46-2.548l-.047-.02z" />
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}" target="_blank" rel="noopener noreferrer" aria-label="Share on Facebook" class="transition-colors p-2 rounded-full bg-gray-100 hover:bg-blue-100 text-gray-600 hover:text-blue-600 dark:bg-gray-800 dark:hover:bg-blue-900 dark:text-gray-400 dark:hover:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blog.show', $post->slug)) }}" target="_blank" rel="noopener noreferrer" aria-label="Share on LinkedIn" class="transition-colors p-2 rounded-full bg-gray-100 hover:bg-blue-100 text-gray-600 hover:text-blue-600 dark:bg-gray-800 dark:hover:bg-blue-900 dark:text-gray-400 dark:hover:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Related Posts -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">You might also like</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($relatedPosts as $relatedPost)
                        <div class="filament-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden">
                            <img src="{{ $relatedPost->featured_image ?? asset('img/placeholder.webp') }}" alt="{{ $relatedPost->title }}" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-2">
                                    <span class="filament-badge inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-amber-700 bg-amber-500/10 dark:text-amber-500">
                                        {{ $relatedPost->category->name }}
                                    </span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $relatedPost->published_at->format('M d, Y') }}</span>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $relatedPost->title }}</h4>
                                <a href="{{ route('blog.show', $relatedPost->slug) }}" class="filament-link inline-flex items-center justify-center gap-1 font-medium outline-none hover:underline focus:underline text-amber-600 hover:text-amber-500 dark:text-amber-500 dark:hover:text-amber-400">
                                    Read more →
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center text-gray-500 dark:text-gray-400">
                            No related posts found
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>