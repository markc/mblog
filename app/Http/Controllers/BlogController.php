<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display the blog listing page
     */
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags'])
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->latest('published_at');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->input('tag'));
            });
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(10);
        $categories = Category::withCount('posts')->get();
        $tags = Tag::withCount('posts')->get();

        return view('blog', compact('posts', 'categories', 'tags'));
    }

    /**
     * Display a specific blog post
     */
    public function show(Post $post)
    {
        if (!$post->is_published || $post->published_at > now()) {
            abort(404);
        }

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where(function ($query) use ($post) {
                $query->where('category_id', $post->category_id)
                    ->orWhereHas('tags', function ($query) use ($post) {
                        $query->whereIn('tags.id', $post->tags->pluck('id'));
                    });
            })
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
