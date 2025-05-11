<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class About extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static string $view = 'filament.pages.about-page';

    protected static ?int $navigationSort = -2;

    // Configure a custom route
    protected static ?string $slug = 'about';

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
        return 'About';
    }
}