<?php

use App\Http\Controllers\PostController;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

beforeEach(function () {
    $this->controller = new PostController;
});

test('show method returns post view for published post', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::factory()->create([
        'slug' => 'test-post',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get("/post/{$post->slug}");

    $response->assertViewIs('blog.show');

    $viewPost = $response->viewData('post');
    expect($viewPost->id)->toBe($post->id);
});

test('show method throws 404 for unpublished post', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::factory()->create([
        'slug' => 'unpublished-post',
        'is_published' => false,
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $this->get("/post/{$post->slug}")
        ->assertStatus(404);
});

test('show method throws 404 for future published post', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::factory()->create([
        'slug' => 'future-post',
        'is_published' => true,
        'published_at' => now()->addDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $this->get("/post/{$post->slug}")
        ->assertStatus(404);
});

test('show method throws 404 for non-existent post', function () {
    $this->get('/post/non-existent-post')
        ->assertStatus(404);
});

test('show method loads post with relationships', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $tag = Tag::factory()->create();

    $post = Post::factory()->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $post->tags()->attach($tag);

    $response = $this->get("/post/{$post->slug}");

    $viewPost = $response->viewData('post');

    expect($viewPost->relationLoaded('user'))->toBeTrue();
    expect($viewPost->relationLoaded('category'))->toBeTrue();
    expect($viewPost->relationLoaded('tags'))->toBeTrue();
});
