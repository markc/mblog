<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

test('category page displays successfully', function () {
    $category = Category::factory()->create([
        'name' => 'Technology',
        'slug' => 'technology',
    ]);

    $response = $this->get("/category/{$category->slug}");

    $response->assertStatus(200)
        ->assertViewIs('blog.category')
        ->assertSee('Technology');
});

test('category page displays posts from that category only', function () {
    $user = User::factory()->create();
    $category1 = Category::factory()->create(['name' => 'Technology']);
    $category2 = Category::factory()->create(['name' => 'Science']);

    $techPost = Post::factory()->create([
        'title' => 'Tech Post',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category1->id,
    ]);

    $sciencePost = Post::factory()->create([
        'title' => 'Science Post',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category2->id,
    ]);

    $response = $this->get("/category/{$category1->slug}");

    $response->assertStatus(200)
        ->assertSee('Tech Post')
        ->assertDontSee('Science Post');
});

test('category page only shows published posts', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $publishedPost = Post::factory()->create([
        'title' => 'Published Tech Post',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $unpublishedPost = Post::factory()->create([
        'title' => 'Unpublished Tech Post',
        'is_published' => false,
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get("/category/{$category->slug}");

    $response->assertStatus(200)
        ->assertSee('Published Tech Post')
        ->assertDontSee('Unpublished Tech Post');
});

test('category page paginates posts', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    Post::factory()->count(15)->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get("/category/{$category->slug}");

    $response->assertStatus(200);

    $posts = $response->viewData('posts');
    expect($posts->hasPages())->toBeTrue();
});

test('category page shows message when no posts exist', function () {
    $category = Category::factory()->create();

    $response = $this->get("/category/{$category->slug}");

    $response->assertStatus(200)
        ->assertSee('No posts in this category');
});

test('non-existent category returns 404', function () {
    $response = $this->get('/category/non-existent-category');

    $response->assertStatus(404);
});

test('category page displays post metadata', function () {
    $user = User::factory()->create(['name' => 'John Author']);
    $category = Category::factory()->create();

    Post::factory()->create([
        'title' => 'Category Test Post',
        'excerpt' => 'This is a test excerpt for category',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get("/category/{$category->slug}");

    $response->assertStatus(200)
        ->assertSee('Category Test Post')
        ->assertSee('This is a test excerpt for category')
        ->assertSee('John Author');
});
