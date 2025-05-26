<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

test('tag page displays successfully', function () {
    $tag = Tag::factory()->create([
        'name' => 'Laravel',
        'slug' => 'laravel',
    ]);

    $response = $this->get("/tag/{$tag->slug}");

    $response->assertStatus(200)
        ->assertViewIs('blog.tag')
        ->assertSee('Laravel');
});

test('tag page displays posts with that tag only', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $laravelTag = Tag::factory()->create(['name' => 'Laravel']);
    $phpTag = Tag::factory()->create(['name' => 'PHP']);

    $laravelPost = Post::factory()->create([
        'title' => 'Laravel Post',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $phpPost = Post::factory()->create([
        'title' => 'PHP Post',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $laravelPost->tags()->attach($laravelTag);
    $phpPost->tags()->attach($phpTag);

    $response = $this->get("/tag/{$laravelTag->slug}");

    $response->assertStatus(200)
        ->assertSee('Laravel Post')
        ->assertDontSee('PHP Post');
});

test('tag page only shows published posts', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $tag = Tag::factory()->create();

    $publishedPost = Post::factory()->create([
        'title' => 'Published Tagged Post',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $unpublishedPost = Post::factory()->create([
        'title' => 'Unpublished Tagged Post',
        'is_published' => false,
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $publishedPost->tags()->attach($tag);
    $unpublishedPost->tags()->attach($tag);

    $response = $this->get("/tag/{$tag->slug}");

    $response->assertStatus(200)
        ->assertSee('Published Tagged Post')
        ->assertDontSee('Unpublished Tagged Post');
});

test('tag page paginates posts', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $tag = Tag::factory()->create();

    $posts = Post::factory()->count(15)->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    foreach ($posts as $post) {
        $post->tags()->attach($tag);
    }

    $response = $this->get("/tag/{$tag->slug}");

    $response->assertStatus(200);

    $posts = $response->viewData('posts');
    expect($posts->hasPages())->toBeTrue();
});

test('tag page shows message when no posts exist', function () {
    $tag = Tag::factory()->create();

    $response = $this->get("/tag/{$tag->slug}");

    $response->assertStatus(200)
        ->assertSee('No posts with this tag');
});

test('non-existent tag returns 404', function () {
    $response = $this->get('/tag/non-existent-tag');

    $response->assertStatus(404);
});

test('tag page displays post metadata', function () {
    $user = User::factory()->create(['name' => 'John Author']);
    $category = Category::factory()->create(['name' => 'Technology']);
    $tag = Tag::factory()->create();

    $post = Post::factory()->create([
        'title' => 'Tagged Test Post',
        'excerpt' => 'This is a test excerpt for tag',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $post->tags()->attach($tag);

    $response = $this->get("/tag/{$tag->slug}");

    $response->assertStatus(200)
        ->assertSee('Tagged Test Post')
        ->assertSee('This is a test excerpt for tag')
        ->assertSee('John Author')
        ->assertSee('Technology');
});
