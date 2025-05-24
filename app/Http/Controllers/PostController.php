<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function show(Post $post)
    {
        // Ensure the post is published
        if (! $post->is_published || $post->published_at > now()) {
            abort(404);
        }

        // Load relationships
        $post->load(['category', 'user', 'tags']);

        // Get related posts from the same category
        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
