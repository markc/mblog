<?php

use App\Http\Controllers\BlogController;
use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\User;

beforeEach(function () {
    $this->controller = new BlogController;
    Setting::set('posts_per_page', 10);
});

test('index method returns blog index view with published posts', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $publishedPost = Post::factory()->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $unpublishedPost = Post::factory()->create([
        'is_published' => false,
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->get('/');

    $response->assertViewIs('blog.index');

    $posts = $response->viewData('posts');
    expect($posts)->toHaveCount(1);
    expect($posts->first()->id)->toBe($publishedPost->id);
});

test('category method returns category view with posts from specific category', function () {
    $user = User::factory()->create();
    $category1 = Category::factory()->create(['slug' => 'tech']);
    $category2 = Category::factory()->create(['slug' => 'science']);

    $techPost = Post::factory()->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category1->id,
    ]);

    $sciencePost = Post::factory()->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category2->id,
    ]);

    $response = $this->get("/category/{$category1->slug}");

    $response->assertViewIs('blog.category');

    $posts = $response->viewData('posts');
    $category = $response->viewData('category');

    expect($posts)->toHaveCount(1);
    expect($posts->first()->id)->toBe($techPost->id);
    expect($category->id)->toBe($category1->id);
});

test('tag method returns tag view with posts tagged with specific tag', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $tag1 = Tag::factory()->create(['slug' => 'laravel']);
    $tag2 = Tag::factory()->create(['slug' => 'php']);

    $laravelPost = Post::factory()->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $phpPost = Post::factory()->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $laravelPost->tags()->attach($tag1);
    $phpPost->tags()->attach($tag2);

    $response = $this->get("/tag/{$tag1->slug}");

    $response->assertViewIs('blog.tag');

    $posts = $response->viewData('posts');
    $tag = $response->viewData('tag');

    expect($posts)->toHaveCount(1);
    expect($posts->first()->id)->toBe($laravelPost->id);
    expect($tag->id)->toBe($tag1->id);
});

test('category method throws 404 for non-existent category', function () {
    $this->get('/category/non-existent')
        ->assertStatus(404);
});

test('tag method throws 404 for non-existent tag', function () {
    $this->get('/tag/non-existent')
        ->assertStatus(404);
});

test('posts are paginated according to settings', function () {
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

    $posts = $response->viewData('posts');
    expect($posts)->toHaveCount(2);
    expect($posts->hasPages())->toBeTrue();
});
