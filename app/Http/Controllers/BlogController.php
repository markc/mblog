<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Tag;

class BlogController extends Controller
{
    public function index()
    {
        $postsPerPage = Setting::get('posts_per_page', 10);

        $posts = Post::published()
            ->with(['category', 'user', 'tags'])
            ->latest('published_at')
            ->paginate($postsPerPage);

        return view('blog.index', compact('posts'));
    }

    public function category(Category $category)
    {
        $postsPerPage = Setting::get('posts_per_page', 10);

        $posts = $category->posts()
            ->published()
            ->with(['category', 'user', 'tags'])
            ->latest('published_at')
            ->paginate($postsPerPage);

        return view('blog.category', compact('posts', 'category'));
    }

    public function tag(Tag $tag)
    {
        $postsPerPage = Setting::get('posts_per_page', 10);

        $posts = $tag->posts()
            ->published()
            ->with(['category', 'user', 'tags'])
            ->latest('published_at')
            ->paginate($postsPerPage);

        return view('blog.tag', compact('posts', 'tag'));
    }
}
