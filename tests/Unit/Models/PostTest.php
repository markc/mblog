<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->category = Category::factory()->create();
});

test('post can be created with valid data', function () {
    $post = Post::create([
        'title' => 'Test Post',
        'slug' => 'test-post',
        'content' => 'This is test content',
        'excerpt' => 'Test excerpt',
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
        'is_published' => true,
        'published_at' => now(),
    ]);

    expect($post)->toBeInstanceOf(Post::class)
        ->and($post->title)->toBe('Test Post')
        ->and($post->slug)->toBe('test-post')
        ->and($post->is_published)->toBeTrue();
});

test('post belongs to user', function () {
    $post = Post::factory()->create(['user_id' => $this->user->id]);

    expect($post->user)->toBeInstanceOf(User::class)
        ->and($post->user->id)->toBe($this->user->id);
});

test('post belongs to category', function () {
    $post = Post::factory()->create(['category_id' => $this->category->id]);

    expect($post->category)->toBeInstanceOf(Category::class)
        ->and($post->category->id)->toBe($this->category->id);
});

test('post can have many tags', function () {
    $post = Post::factory()->create();
    $tags = Tag::factory()->count(3)->create();

    $post->tags()->attach($tags);

    expect($post->tags)->toHaveCount(3)
        ->and($post->tags->first())->toBeInstanceOf(Tag::class);
});

test('published scope returns only published posts', function () {
    Post::factory()->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
    ]);

    Post::factory()->create([
        'is_published' => false,
        'published_at' => now()->subDay(),
    ]);

    Post::factory()->create([
        'is_published' => true,
        'published_at' => now()->addDay(),
    ]);

    $publishedPosts = Post::published()->get();

    expect($publishedPosts)->toHaveCount(1);
});

test('published at is cast to datetime', function () {
    $post = Post::factory()->create(['published_at' => '2024-01-01 12:00:00']);

    expect($post->published_at)->toBeInstanceOf(DateTime::class);
});

test('is published is cast to boolean', function () {
    $post = Post::factory()->create(['is_published' => 1]);

    expect($post->is_published)->toBeTrue();
});

test('post requires title', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    Post::create([
        'slug' => 'test-post',
        'content' => 'Content',
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);
});

test('post can be deleted', function () {
    $post = Post::factory()->create();
    $postId = $post->id;

    $post->delete();

    expect(Post::find($postId))->toBeNull();
});
