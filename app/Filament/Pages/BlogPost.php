<?php

namespace App\Filament\Pages;

use App\Models\Post;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class BlogPost extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static string $view = 'filament.pages.blog-post';
    
    // These pages should be dynamically generated, not static
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    
    // Allow this page to be accessed without authentication
    public static function shouldCheckAccess(): bool
    {
        return false;
    }
    
    // Store the current post in memory
    public ?Post $post = null;

    // Store related posts too
    public $relatedPosts = [];

    public function getTitle(): string|Htmlable
    {
        return $this->post?->title ?? 'Blog Post';
    }

    // Mount function to handle the post slug
    public function mount(string $slug)
    {
        $this->post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->firstOrFail();

        $this->relatedPosts = Post::published()
            ->where('id', '!=', $this->post->id)
            ->where(function ($query) {
                $query->where('category_id', $this->post->category_id)
                    ->orWhereHas('tags', function ($query) {
                        $query->whereIn('tags.id', $this->post->tags->pluck('id'));
                    });
            })
            ->inRandomOrder()
            ->take(3)
            ->get();
    }
}