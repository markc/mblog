@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="fi-section fi-section-header-padding border-b border-gray-200 pb-8 dark:border-white/10">
        <div class="fi-section-header-wrapper">
            <h1 class="fi-section-header-heading text-3xl font-bold leading-tight tracking-tight text-gray-950 dark:text-white">
                Latest Posts
            </h1>
            <p class="fi-section-header-description mt-2 text-lg text-gray-600 dark:text-gray-400">
                {{ \App\Models\Setting::get('site_description', 'A blog built with Laravel and Filament') }}
            </p>
        </div>
    </div>

    @if($posts->isNotEmpty())
        <!-- Posts Grid -->
        <div class="grid gap-8 lg:grid-cols-2">
            @foreach($posts as $post)
            <article class="fi-section-content-ctn rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
                @if($post->featured_image)
                <div class="overflow-hidden rounded-t-xl">
                    <img src="{{ Storage::url($post->featured_image) }}" 
                         alt="{{ $post->title }}"
                         class="h-48 w-full object-cover transition duration-300 hover:scale-105">
                </div>
                @endif
                
                <div class="p-6">
                    <!-- Category & Date -->
                    <div class="mb-4 flex items-center space-x-2 text-sm">
                        <a href="{{ route('blog.category', $post->category) }}" 
                           class="fi-badge fi-color-primary fi-size-md inline-flex items-center gap-x-1 rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset">
                            {{ $post->category->name }}
                        </a>
                        <span class="text-gray-500 dark:text-gray-400">•</span>
                        <time class="text-gray-500 dark:text-gray-400">
                            {{ $post->published_at->format('M d, Y') }}
                        </time>
                    </div>

                    <!-- Title -->
                    <h2 class="mb-3">
                        <a href="{{ route('post.show', $post) }}" 
                           class="fi-link text-xl font-semibold text-gray-950 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                            {{ $post->title }}
                        </a>
                    </h2>

                    <!-- Excerpt -->
                    @if($post->excerpt)
                    <p class="mb-4 text-gray-600 dark:text-gray-400">
                        {{ Str::limit($post->excerpt, 150) }}
                    </p>
                    @endif

                    <!-- Meta -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="fi-avatar fi-size-sm h-8 w-8">
                                @if($post->user->avatar_url)
                                <img src="{{ $post->user->avatar_url }}" 
                                     alt="{{ $post->user->name }}"
                                     class="h-full w-full rounded-full object-cover">
                                @else
                                <div class="flex h-full w-full items-center justify-center rounded-full bg-primary-500 text-primary-50">
                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                </div>
                                @endif
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $post->user->name }}
                            </span>
                        </div>

                        <!-- Tags -->
                        @if($post->tags->isNotEmpty())
                        <div class="flex flex-wrap gap-1">
                            @foreach($post->tags->take(3) as $tag)
                            <a href="{{ route('blog.tag', $tag) }}" 
                               class="fi-badge fi-color-gray fi-size-sm inline-flex items-center gap-x-1 rounded-md px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
                                #{{ $tag->name }}
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- Read More -->
                    <div class="mt-4">
                        <a href="{{ route('post.show', $post) }}" 
                           class="fi-link fi-color-primary inline-flex items-center text-sm font-medium">
                            Read more
                            <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="fi-section-content-ctn rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
            <div class="flex justify-center">
                {{ $posts->links() }}
            </div>
        </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="fi-section-content-ctn rounded-xl bg-white p-12 text-center shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
            <div class="fi-empty-state">
                <div class="fi-empty-state-icon mb-4 flex justify-center">
                    <svg class="h-16 w-16 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="fi-empty-state-heading text-lg font-semibold text-gray-950 dark:text-white">
                    No posts yet
                </h3>
                <p class="fi-empty-state-description mt-2 text-gray-600 dark:text-gray-400">
                    Check back later for new content, or visit the admin panel to create your first post.
                </p>
                <div class="mt-6">
                    <a href="/admin" 
                       class="fi-btn fi-color-primary fi-btn-size-md fi-size-md gap-1.5 px-4 py-2 font-semibold shadow-sm">
                        Go to Admin
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection