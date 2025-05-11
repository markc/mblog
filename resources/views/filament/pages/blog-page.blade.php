<x-filament::page>
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="lg:w-3/4">
            <div class="filament-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 mb-6">
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Blog</h1>
                    
                    <!-- Search Form -->
                    <form action="{{ route('blog') }}" method="GET" class="mb-6">
                        <div class="flex">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..." class="filament-forms-input-component text-gray-900 dark:text-white block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-offset-gray-800 border-gray-300 focus:border-amber-600 focus:ring-amber-600 dark:focus:border-amber-600 dark:focus:ring-amber-600 rounded-r-none">
                            <button type="submit" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white bg-amber-600 border-transparent hover:bg-amber-500 focus:bg-amber-700 focus:ring-offset-amber-700 dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-offset-amber-600 rounded-l-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                                <span>Search</span>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Active Filters -->
                    @if(request()->anyFilled(['category', 'tag', 'search']))
                        <div class="mb-6">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Active filters:</div>
                            <div class="flex flex-wrap gap-2">
                                @if(request('category'))
                                    <div class="filament-badge inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-amber-700 bg-amber-500/10 dark:text-amber-500">
                                        Category: {{ request('category') }}
                                        <a href="{{ route('blog', array_filter(request()->except('category'))) }}" class="ml-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                                
                                @if(request('tag'))
                                    <div class="filament-badge inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-primary-700 bg-primary-500/10 dark:text-primary-500">
                                        Tag: {{ request('tag') }}
                                        <a href="{{ route('blog', array_filter(request()->except('tag'))) }}" class="ml-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                                
                                @if(request('search'))
                                    <div class="filament-badge inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-gray-700 bg-gray-500/10 dark:text-gray-300">
                                        Search: {{ request('search') }}
                                        <a href="{{ route('blog', array_filter(request()->except('search'))) }}" class="ml-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                                
                                <a href="{{ route('blog') }}" class="filament-link inline-flex items-center justify-center gap-1 font-medium outline-none hover:underline focus:underline text-primary-600 hover:text-primary-500 dark:text-primary-500 dark:hover:text-primary-400 text-sm">
                                    Clear all filters
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Blog Posts -->
                    <div class="space-y-8">
                        @forelse($this->getPosts() as $post)
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-8 last:border-b-0 last:pb-0">
                                <div class="flex flex-col md:flex-row">
                                    <div class="md:w-1/3 mb-4 md:mb-0 md:mr-6">
                                        <img src="{{ $post->featured_image ?? asset('img/placeholder.webp') }}" alt="{{ $post->title }}" class="w-full h-48 object-cover rounded-lg">
                                    </div>
                                    <div class="md:w-2/3">
                                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                                            <a href="{{ route('blog', ['category' => $post->category->slug]) }}" class="filament-badge inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-amber-700 bg-amber-500/10 dark:text-amber-500">
                                                {{ $post->category->name }}
                                            </a>
                                            <span class="mx-2">•</span>
                                            <span>{{ $post->published_at->format('M d, Y') }}</span>
                                        </div>
                                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $post->title }}</h2>
                                        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $post->excerpt }}</p>
                                        
                                        @if($post->tags->count() > 0)
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                @foreach($post->tags as $tag)
                                                    <a href="{{ route('blog', ['tag' => $tag->slug]) }}" class="filament-badge inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-primary-700 bg-primary-500/10 dark:text-primary-500">
                                                        #{{ $tag->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                        
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
                            <div class="flex items-center justify-center p-6 text-center">
                                <div>
                                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <h2 class="text-lg font-medium">No posts found</h2>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Try adjusting your search or filter criteria.</p>
                                    <a href="{{ route('blog') }}" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white bg-amber-600 border-transparent hover:bg-amber-500 focus:bg-amber-700 focus:ring-offset-amber-700 dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-offset-amber-600 mt-4">
                                        Clear filters
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $this->getPosts()->links() }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:w-1/4">
            <!-- Categories Widget -->
            <div class="filament-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Categories</h2>
                    <ul class="space-y-3">
                        @forelse($this->getCategories() as $category)
                            <li>
                                <a href="{{ route('blog', ['category' => $category->slug]) }}" class="flex items-center justify-between text-gray-600 dark:text-gray-300 hover:text-amber-600 dark:hover:text-amber-500 transition">
                                    <span>{{ $category->name }}</span>
                                    <span class="filament-badge inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-gray-700 bg-gray-500/10 dark:text-gray-300">
                                        {{ $category->posts_count }}
                                    </span>
                                </a>
                            </li>
                        @empty
                            <li class="text-gray-500 dark:text-gray-400">No categories available</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <!-- Tags Widget -->
            <div class="filament-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Tags</h2>
                    <div class="flex flex-wrap gap-2">
                        @forelse($this->getTags() as $tag)
                            <a href="{{ route('blog', ['tag' => $tag->slug]) }}" class="filament-badge inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-primary-700 bg-primary-500/10 dark:text-primary-500">
                                #{{ $tag->name }} ({{ $tag->posts_count }})
                            </a>
                        @empty
                            <span class="text-gray-500 dark:text-gray-400">No tags available</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament::page>