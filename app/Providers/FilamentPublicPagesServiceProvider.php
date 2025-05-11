<?php

namespace App\Providers;

use App\Filament\Pages\Home;
use App\Filament\Pages\About;
use App\Filament\Pages\Blog;
use App\Filament\Pages\BlogPost;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FilamentPublicPagesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->booted(function () {
            $panel = Filament::getPanel('admin');
            
            // Define custom routes for the public pages
            Route::get('/', function () use ($panel) {
                $page = new Home();
                $page->panel = $panel;
                return $page->__invoke(request());
            })->name('home');
            
            Route::get('/about', function () use ($panel) {
                $page = new About();
                $page->panel = $panel;
                return $page->__invoke(request());
            })->name('about');
            
            Route::get('/blog', function () use ($panel) {
                $page = new Blog();
                $page->panel = $panel;
                return $page->__invoke(request());
            })->name('blog');
            
            // Blog post detail route - needs to be below the /blog route to avoid conflicts
            Route::get('/blog/{slug}', function (string $slug) use ($panel) {
                $page = new BlogPost();
                $page->panel = $panel;
                $page->mount($slug);

                return $page->__invoke(request());
            })->name('blog.show')->where('slug', '[a-z0-9-]+');
        });
    }
}