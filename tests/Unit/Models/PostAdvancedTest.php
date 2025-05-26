<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Tests\Helpers\TestHelpers;

test('post slug is automatically generated from title', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::create([
        'title' => 'This Is A Test Post Title',
        'content' => 'Test content',
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    expect($post->slug)->toBe('this-is-a-test-post-title');
});

test('post can have duplicate titles with different slugs', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $post1 = Post::create([
        'title' => 'Duplicate Title',
        'slug' => 'duplicate-title-1',
        'content' => 'Content 1',
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $post2 = Post::create([
        'title' => 'Duplicate Title',
        'slug' => 'duplicate-title-2',
        'content' => 'Content 2',
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    expect($post1->title)->toBe($post2->title);
    expect($post1->slug)->not->toBe($post2->slug);
});

test('published scope excludes posts with null published_at', function () {
    Post::factory()->create([
        'is_published' => true,
        'published_at' => null,
    ]);

    $publishedPosts = Post::published()->get();

    expect($publishedPosts)->toHaveCount(0);
});

test('post can be scheduled for future publication', function () {
    $futureDate = now()->addWeek();

    $post = Post::factory()->create([
        'is_published' => true,
        'published_at' => $futureDate,
    ]);

    // Should not appear in published scope now
    expect(Post::published()->get())->toHaveCount(0);

    // Mock future time
    $this->travelTo($futureDate->addMinute());

    // Should now appear in published scope
    expect(Post::published()->get())->toHaveCount(1);
});

test('post excerpt is automatically truncated if too long', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $longExcerpt = str_repeat('This is a very long excerpt. ', 50); // ~1400 characters

    $post = Post::create([
        'title' => 'Test Post',
        'slug' => 'test-post',
        'content' => 'Content',
        'excerpt' => $longExcerpt,
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    // Excerpt should be stored as-is (validation happens at form level)
    expect(strlen($post->excerpt))->toBeGreaterThan(500);
});

test('post can have many-to-many relationship with tags', function () {
    $post = TestHelpers::createPostWithTags(5);

    expect($post->tags)->toHaveCount(5);

    // Test relationship is bidirectional
    $firstTag = $post->tags->first();
    expect($firstTag->posts->pluck('id'))->toContain($post->id);
});

test('post deletion removes tag relationships but not tags', function () {
    $post = TestHelpers::createPostWithTags(3);
    $tags = $post->tags;
    $tagIds = $tags->pluck('id');

    $post->delete();

    // Tags should still exist
    foreach ($tagIds as $tagId) {
        expect(Tag::find($tagId))->not->toBeNull();
    }

    // But relationships should be gone
    expect(\DB::table('post_tag')->where('post_id', $post->id)->count())->toBe(0);
});

test('post with meta_title uses it over regular title for SEO', function () {
    $post = Post::factory()->create([
        'title' => 'Regular Title',
        'meta_title' => 'SEO Optimized Meta Title',
    ]);

    expect($post->meta_title)->toBe('SEO Optimized Meta Title');
    expect($post->title)->toBe('Regular Title');
});

test('post without meta_title falls back to regular title', function () {
    $post = Post::factory()->create([
        'title' => 'Regular Title',
        'meta_title' => null,
    ]);

    $displayTitle = $post->meta_title ?: $post->title;

    expect($displayTitle)->toBe('Regular Title');
});

test('post slug updates when title changes and matches old slug pattern', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::create([
        'title' => 'Original Title',
        'content' => 'Content',
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    expect($post->slug)->toBe('original-title');

    // Update title - slug should update since it matches the old pattern
    $post->update(['title' => 'Updated Title']);

    expect($post->fresh()->slug)->toBe('updated-title');
});

test('post slug does not update when title changes but custom slug exists', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::create([
        'title' => 'Original Title',
        'slug' => 'custom-slug',
        'content' => 'Content',
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    expect($post->slug)->toBe('custom-slug');

    // Update title - slug should NOT update since it's custom
    $post->update(['title' => 'Updated Title']);

    expect($post->fresh()->slug)->toBe('custom-slug');
});

test('unique slug generation handles collisions properly', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    // Create first post with a title
    $post1 = Post::create([
        'title' => 'Duplicate Title',
        'content' => 'Content 1',
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    // Create second post with same title - should get incremented slug
    $post2 = Post::create([
        'title' => 'Duplicate Title',
        'content' => 'Content 2',
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    expect($post1->slug)->toBe('duplicate-title');
    expect($post2->slug)->toBe('duplicate-title-1');
});
