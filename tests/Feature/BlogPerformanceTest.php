<?php

use App\Models\Setting;
use Tests\Helpers\TestHelpers;

beforeEach(function () {
    Setting::set('posts_per_page', 10);
});

test('homepage loads efficiently with many posts', function () {
    TestHelpers::createPostsForPagination(50);

    $start = microtime(true);
    $response = $this->get('/');
    $duration = microtime(true) - $start;

    $response->assertStatus(200);
    expect($duration)->toBeLessThan(1.0); // Should load in under 1 second
});

test('category page handles large post count efficiently', function () {
    $posts = TestHelpers::createPostsForPagination(30);
    $category = $posts->first()->category;

    $start = microtime(true);
    $response = $this->get("/category/{$category->slug}");
    $duration = microtime(true) - $start;

    $response->assertStatus(200);
    expect($duration)->toBeLessThan(1.0);
});

test('post with many tags displays properly', function () {
    $post = TestHelpers::createPostWithTags(10);

    $response = $this->get("/post/{$post->slug}");

    $response->assertStatus(200);
    
    // Should show all tags
    foreach ($post->tags as $tag) {
        $response->assertSee($tag->name);
    }
});

test('mixed published and unpublished posts are filtered correctly', function () {
    $posts = TestHelpers::createMixedPosts(5, 3);

    $response = $this->get('/');

    $response->assertStatus(200);
    
    // Should see published posts
    foreach ($posts['published'] as $post) {
        $response->assertSee($post->title);
    }
    
    // Should not see unpublished posts
    foreach ($posts['unpublished'] as $post) {
        $response->assertDontSee($post->title);
    }
});

test('database queries are optimized for homepage', function () {
    TestHelpers::createPostsForPagination(20);

    // Enable query logging
    \DB::enableQueryLog();

    $this->get('/');

    $queries = \DB::getQueryLog();
    
    // Should use reasonable number of queries (not N+1)
    expect(count($queries))->toBeLessThan(10);
});

test('pagination works correctly with exact page boundaries', function () {
    Setting::set('posts_per_page', 5);
    TestHelpers::createPostsForPagination(15); // Exactly 3 pages

    // Test first page
    $response = $this->get('/');
    $posts = $response->viewData('posts');
    expect($posts)->toHaveCount(5);
    expect($posts->hasPages())->toBeTrue();

    // Test second page
    $response = $this->get('/?page=2');
    $posts = $response->viewData('posts');
    expect($posts)->toHaveCount(5);

    // Test third page
    $response = $this->get('/?page=3');
    $posts = $response->viewData('posts');
    expect($posts)->toHaveCount(5);

    // Test beyond last page
    $response = $this->get('/?page=4');
    $posts = $response->viewData('posts');
    expect($posts)->toHaveCount(0);
});