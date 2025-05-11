<?php

namespace App\Filament\Pages;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Request;

class Blog extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static string $view = 'filament.pages.blog-page';

    protected static ?int $navigationSort = -1;

    // Configure a custom route
    protected static ?string $slug = 'blog';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    // Allow this page to be accessed without authentication
    public static function shouldCheckAccess(): bool
    {
        return false;
    }

    public function getTitle(): string|Htmlable
    {
        return 'Blog';
    }

    public function getPosts()
    {
        $query = Post::with(['user', 'category', 'tags'])
            ->published()
            ->latest('published_at');

        if (Request::filled('category')) {
            $query->whereHas('category', function ($q) {
                $q->where('slug', Request::input('category'));
            });
        }

        if (Request::filled('tag')) {
            $query->whereHas('tags', function ($q) {
                $q->where('slug', Request::input('tag'));
            });
        }

        if (Request::filled('search')) {
            $search = Request::input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        return $query->paginate(10);
    }

    public function getCategories()
    {
        return Category::withCount('posts')->get();
    }

    public function getTags()
    {
        return Tag::withCount('posts')->get();
    }
}