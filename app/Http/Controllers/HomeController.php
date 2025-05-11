<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        $featuredPosts = Post::with(['user', 'category', 'tags'])
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->where('is_featured', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        $recentPosts = Post::with(['user', 'category'])
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('home', compact('featuredPosts', 'recentPosts'));
    }
}
