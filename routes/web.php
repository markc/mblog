<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Blog routes
Route::get('/', [BlogController::class, 'index'])->name('blog.index');
Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/tag/{tag:slug}', [BlogController::class, 'tag'])->name('blog.tag');

// Post routes
Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('post.show');

// Page routes
Route::get('/page/{page:slug}', [PageController::class, 'show'])->name('page.show');
