@extends('layouts.app')

@php
    $title = $page->meta_title ?: $page->title;
    $metaDescription = $page->meta_description ?: Str::limit(strip_tags($page->content), 160);
@endphp

@section('content')
<div class="space-y-8">
    <!-- Page Content -->
    <article class="fi-section-content-ctn rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
        <div class="p-8">
            <!-- Breadcrumb -->
            <div class="mb-6 flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('blog.index') }}" 
                   class="fi-link fi-color-gray hover:text-gray-900 dark:hover:text-white">
                    Home
                </a>
                <span class="text-gray-400 dark:text-gray-600">→</span>
                <span class="text-gray-900 dark:text-white">{{ $page->title }}</span>
            </div>

            <!-- Title -->
            <h1 class="mb-8 text-4xl font-bold leading-tight tracking-tight text-gray-950 dark:text-white lg:text-5xl">
                {{ $page->title }}
            </h1>

            <!-- Content -->
            <div class="prose prose-gray max-w-none dark:prose-invert prose-headings:text-gray-950 prose-a:text-primary-600 prose-strong:text-gray-950 dark:prose-headings:text-white dark:prose-a:text-primary-400 dark:prose-strong:text-white">
                {!! $page->content !!}
            </div>
        </div>
    </article>

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
            
            <!-- Other Pages -->
            @php
                $otherPages = \App\Models\Page::published()
                    ->where('id', '!=', $page->id)
                    ->take(3)
                    ->get();
            @endphp
            
            @if($otherPages->isNotEmpty())
            <div class="flex space-x-2">
                @foreach($otherPages as $otherPage)
                <a href="{{ route('page.show', $otherPage) }}" 
                   class="fi-btn fi-color-gray fi-btn-size-md fi-size-md gap-1.5 px-4 py-2 font-semibold shadow-sm">
                    {{ $otherPage->title }}
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection