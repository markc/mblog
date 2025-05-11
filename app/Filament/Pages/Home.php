<?php

namespace App\Filament\Pages;

use App\Models\Post;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Home extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.home-page';

    protected static ?int $navigationSort = -3;

    // Configure a custom route for this page that doesn't include the admin prefix
    protected static ?string $slug = '/';

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
        return 'Home';
    }

    public function getFeaturedPosts()
    {
        return Post::with(['user', 'category', 'tags'])
            ->published()
            ->featured()
            ->latest('published_at')
            ->take(3)
            ->get();
    }

    public function getRecentPosts()
    {
        return Post::with(['user', 'category'])
            ->published()
            ->latest('published_at')
            ->take(5)
            ->get();
    }
}