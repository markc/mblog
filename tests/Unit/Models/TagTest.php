<?php

use App\Models\Post;
use App\Models\Tag;

test('tag can be created with valid data', function () {
    $tag = Tag::create([
        'name' => 'Laravel',
        'slug' => 'laravel',
    ]);

    expect($tag)->toBeInstanceOf(Tag::class)
        ->and($tag->name)->toBe('Laravel')
        ->and($tag->slug)->toBe('laravel');
});

test('tag belongs to many posts', function () {
    $tag = Tag::factory()->create();
    $posts = Post::factory()->count(3)->create();

    $tag->posts()->attach($posts);

    expect($tag->posts)->toHaveCount(3)
        ->and($tag->posts->first())->toBeInstanceOf(Post::class);
});

test('tag requires name', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    Tag::create([
        'slug' => 'test-tag',
    ]);
});

test('tag requires slug', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    Tag::create([
        'name' => 'Test Tag',
    ]);
});

test('tag name and slug are fillable', function () {
    $tag = new Tag;

    expect($tag->getFillable())->toContain('name', 'slug');
});

test('tag can be updated', function () {
    $tag = Tag::factory()->create(['name' => 'Old Tag']);

    $tag->update(['name' => 'New Tag']);

    expect($tag->fresh()->name)->toBe('New Tag');
});

test('tag deletion removes pivot table entries', function () {
    $tag = Tag::factory()->create();
    $post = Post::factory()->create();

    $tag->posts()->attach($post);

    expect($tag->posts)->toHaveCount(1);

    $tag->delete();

    expect($post->fresh()->tags)->toHaveCount(0);
});
