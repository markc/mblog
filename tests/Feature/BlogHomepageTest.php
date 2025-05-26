<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;

beforeEach(function () {
    Setting::set('site_name', 'Test Blog');
    Setting::set('site_description', 'A test blog description');
    Setting::set('posts_per_page', 10);
});

test('blog homepage displays successfully', function () {
    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertViewIs('blog.index');
});

test('blog homepage displays published posts', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $publishedPost = Post::factory()->create([
        'title' => 'Published Post',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $unpublishedPost = Post::factory()->create([
        'title' => 'Unpublished Post',
        'is_published' => false,
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('Published Post')
        ->assertDontSee('Unpublished Post');
});

test('blog homepage displays site settings', function () {
    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('Test Blog')
        ->assertSee('A test blog description');
});

test('blog homepage paginates posts correctly', function () {
    Setting::set('posts_per_page', 2);

    $user = User::factory()->create();
    $category = Category::factory()->create();

    Post::factory()->count(5)->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);

    $posts = $response->viewData('posts');
    expect($posts)->toHaveCount(2);
});

test('blog homepage shows no posts message when empty', function () {
    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('No posts yet');
});

test('blog homepage displays post metadata', function () {
    $user = User::factory()->create(['name' => 'John Author']);
    $category = Category::factory()->create(['name' => 'Technology']);

    Post::factory()->create([
        'title' => 'Test Post',
        'excerpt' => 'This is a test excerpt',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('Test Post')
        ->assertSee('This is a test excerpt')
        ->assertSee('John Author')
        ->assertSee('Technology');
});
