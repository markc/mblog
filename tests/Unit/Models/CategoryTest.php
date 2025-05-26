<?php

use App\Models\Category;
use App\Models\Post;

test('category can be created with valid data', function () {
    $category = Category::create([
        'name' => 'Technology',
        'slug' => 'technology',
    ]);

    expect($category)->toBeInstanceOf(Category::class)
        ->and($category->name)->toBe('Technology')
        ->and($category->slug)->toBe('technology');
});

test('category has many posts', function () {
    $category = Category::factory()->create();
    Post::factory()->count(3)->create(['category_id' => $category->id]);

    expect($category->posts)->toHaveCount(3)
        ->and($category->posts->first())->toBeInstanceOf(Post::class);
});

test('category requires name', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    Category::create([
        'slug' => 'test-category',
    ]);
});

test('category requires slug', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    Category::create([
        'name' => 'Test Category',
    ]);
});

test('category name and slug are fillable', function () {
    $category = new Category;

    expect($category->getFillable())->toContain('name', 'slug');
});

test('category can be updated', function () {
    $category = Category::factory()->create(['name' => 'Old Name']);

    $category->update(['name' => 'New Name']);

    expect($category->fresh()->name)->toBe('New Name');
});

test('category deletion removes associated posts relationship', function () {
    $category = Category::factory()->create();
    $post = Post::factory()->create(['category_id' => $category->id]);

    $category->delete();

    expect($post->fresh())->toBeNull();
});
