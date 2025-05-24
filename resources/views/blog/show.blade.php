@extends('layouts.app')

@php
    $title = $post->meta_title ?: $post->title;
    $metaDescription = $post->meta_description ?: Str::limit(strip_tags($post->content), 160);
@endphp

@section('content')
<div class="space-y-8">
    <!-- Post Header -->
    <article class="fi-section-content-ctn rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
        @if($post->featured_image)
        <div class="overflow-hidden rounded-t-xl">
            <img src="{{ Storage::url($post->featured_image) }}" 
                 alt="{{ $post->title }}"
                 class="h-64 w-full object-cover lg:h-96">
        </div>
        @endif
        
        <div class="p-8">
            <!-- Meta Information -->
            <div class="mb-6 flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('blog.category', $post->category) }}" 
                   class="fi-badge fi-color-primary fi-size-md inline-flex items-center gap-x-1 rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset">
                    {{ $post->category->name }}
                </a>
                
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
                    <span>{{ $post->user->name }}</span>
                </div>
                
                <time>{{ $post->published_at->format('F d, Y') }}</time>
                
                <span>{{ $post->published_at->diffForHumans() }}</span>
            </div>

            <!-- Title -->
            <h1 class="mb-6 text-4xl font-bold leading-tight tracking-tight text-gray-950 dark:text-white lg:text-5xl">
                {{ $post->title }}
            </h1>

            <!-- Tags -->
            @if($post->tags->isNotEmpty())
            <div class="mb-8 flex flex-wrap gap-2">
                @foreach($post->tags as $tag)
                <a href="{{ route('blog.tag', $tag) }}" 
                   class="fi-badge fi-color-gray fi-size-sm inline-flex items-center gap-x-1 rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset hover:bg-gray-100 dark:hover:bg-white/10">
                    #{{ $tag->name }}
                </a>
                @endforeach
            </div>
            @endif

            <!-- Content -->
            <div class="prose prose-gray max-w-none dark:prose-invert prose-headings:text-gray-950 prose-a:text-primary-600 prose-strong:text-gray-950 dark:prose-headings:text-white dark:prose-a:text-primary-400 dark:prose-strong:text-white">
                {!! $post->content !!}
            </div>
        </div>
    </article>

    <!-- Related Posts -->
    @if($relatedPosts->isNotEmpty())
    <div class="fi-section-content-ctn rounded-xl bg-white p-8 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
        <h3 class="mb-6 text-xl font-semibold text-gray-950 dark:text-white">
            Related Posts
        </h3>
        
        <div class="grid gap-6 md:grid-cols-3">
            @foreach($relatedPosts as $relatedPost)
            <article class="group">
                @if($relatedPost->featured_image)
                <div class="mb-3 overflow-hidden rounded-lg">
                    <img src="{{ Storage::url($relatedPost->featured_image) }}" 
                         alt="{{ $relatedPost->title }}"
                         class="h-32 w-full object-cover transition duration-300 group-hover:scale-105">
                </div>
                @endif
                
                <div class="space-y-2">
                    <h4>
                        <a href="{{ route('post.show', $relatedPost) }}" 
                           class="fi-link text-base font-medium text-gray-950 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                            {{ $relatedPost->title }}
                        </a>
                    </h4>
                    
                    <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                        <time>{{ $relatedPost->published_at->format('M d, Y') }}</time>
                        <span>•</span>
                        <span>{{ $relatedPost->user->name }}</span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Navigation -->
    <div class="fi-section-content-ctn rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
        <div class="flex justify-between">
            <a href="{{ route('blog.index') }}" 
               class="fi-btn fi-color-gray fi-btn-size-md fi-size-md gap-1.5 px-4 py-2 font-semibold shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Blog
            </a>
            
            <a href="{{ route('blog.category', $post->category) }}" 
               class="fi-btn fi-color-primary fi-btn-size-md fi-size-md gap-1.5 px-4 py-2 font-semibold shadow-sm">
                More in {{ $post->category->name }}
            </a>
        </div>
    </div>
</div>
@endsection