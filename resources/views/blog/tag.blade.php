@extends('layouts.app')

@php
    $title = "Posts tagged with {$tag->name}";
@endphp

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="fi-section fi-section-header-padding border-b border-gray-200 pb-8 dark:border-white/10">
        <div class="fi-section-header-wrapper">
            <div class="flex items-center space-x-2">
                <a href="{{ route('blog.index') }}" 
                   class="fi-link fi-color-gray text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    Home
                </a>
                <span class="text-gray-400 dark:text-gray-600">→</span>
                <span class="text-gray-900 dark:text-white">#{{ $tag->name }}</span>
            </div>
            
            <h1 class="fi-section-header-heading mt-2 text-3xl font-bold leading-tight tracking-tight text-gray-950 dark:text-white">
                Posts tagged with "#{{ $tag->name }}"
            </h1>
            
            <p class="fi-section-header-description mt-2 text-lg text-gray-600 dark:text-gray-400">
                {{ $posts->total() }} {{ Str::plural('post', $posts->total()) }} found
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
                        <span class="text-gray-500 dark:text-gray-400">•</span>
                        <span class="text-gray-500 dark:text-gray-400">
                            {{ $post->user->name }}
                        </span>
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

                    <!-- Tags -->
                    @if($post->tags->isNotEmpty())
                    <div class="mb-4 flex flex-wrap gap-1">
                        @foreach($post->tags->take(3) as $postTag)
                        <a href="{{ route('blog.tag', $postTag) }}" 
                           class="fi-badge fi-color-gray fi-size-sm inline-flex items-center gap-x-1 rounded-md px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $postTag->slug === $tag->slug ? 'fi-color-primary' : '' }}">
                            #{{ $postTag->name }}
                        </a>
                        @endforeach
                    </div>
                    @endif

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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <h3 class="fi-empty-state-heading text-lg font-semibold text-gray-950 dark:text-white">
                    No posts with this tag
                </h3>
                <p class="fi-empty-state-description mt-2 text-gray-600 dark:text-gray-400">
                    There are no published posts tagged with "#{{ $tag->name }}" yet.
                </p>
                <div class="mt-6">
                    <a href="{{ route('blog.index') }}" 
                       class="fi-btn fi-color-primary fi-btn-size-md fi-size-md gap-1.5 px-4 py-2 font-semibold shadow-sm">
                        Browse All Posts
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection