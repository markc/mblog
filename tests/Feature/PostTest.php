<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

test('published post can be viewed', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::factory()->create([
        'title' => 'Test Post',
        'slug' => 'test-post',
        'content' => 'This is the post content',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get("/post/{$post->slug}");

    $response->assertStatus(200)
        ->assertViewIs('blog.show')
        ->assertSee('Test Post')
        ->assertSee('This is the post content');
});

test('unpublished post returns 404', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::factory()->create([
        'slug' => 'unpublished-post',
        'is_published' => false,
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get("/post/{$post->slug}");

    $response->assertStatus(404);
});

test('future published post returns 404', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::factory()->create([
        'slug' => 'future-post',
        'is_published' => true,
        'published_at' => now()->addDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get("/post/{$post->slug}");

    $response->assertStatus(404);
});

test('post displays author and category information', function () {
    $user = User::factory()->create(['name' => 'Jane Author']);
    $category = Category::factory()->create(['name' => 'Science']);

    $post = Post::factory()->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get("/post/{$post->slug}");

    $response->assertStatus(200)
        ->assertSee('Jane Author')
        ->assertSee('Science');
});

test('post displays associated tags', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $tag1 = Tag::factory()->create(['name' => 'Laravel']);
    $tag2 = Tag::factory()->create(['name' => 'PHP']);

    $post = Post::factory()->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $post->tags()->attach([$tag1->id, $tag2->id]);

    $response = $this->get("/post/{$post->slug}");

    $response->assertStatus(200)
        ->assertSee('Laravel')
        ->assertSee('PHP');
});

test('post with meta title uses it for page title', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::factory()->create([
        'title' => 'Regular Title',
        'meta_title' => 'SEO Optimized Title',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get("/post/{$post->slug}");

    $response->assertStatus(200)
        ->assertSee('SEO Optimized Title', false);
});

test('post with meta description includes it in meta tags', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::factory()->create([
        'meta_description' => 'This is a custom meta description',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get("/post/{$post->slug}");

    $response->assertStatus(200)
        ->assertSee('This is a custom meta description', false);
});

test('non-existent post returns 404', function () {
    $response = $this->get('/post/non-existent-post');

    $response->assertStatus(404);
});
