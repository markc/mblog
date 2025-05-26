<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;

describe('Post Model Final Coverage', function () {
    it('scopePublished filters correctly with all conditions', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        // Create posts with different publication states
        $publishedPost = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'is_published' => true,
            'published_at' => Carbon::now()->subDay(),
        ]);

        $unpublishedPost = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'is_published' => false,
            'published_at' => Carbon::now()->subDay(),
        ]);

        $futurePost = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'is_published' => true,
            'published_at' => Carbon::now()->addDay(),
        ]);

        $nullDatePost = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'is_published' => true,
            'published_at' => null,
        ]);

        // Test the scope
        $publishedPosts = Post::published()->get();

        expect($publishedPosts)->toHaveCount(1);
        expect($publishedPosts->first()->id)->toBe($publishedPost->id);
    });

    it('scopePublished returns correct query builder instance', function () {
        $query = Post::published();

        expect($query)->toBeInstanceOf(\Illuminate\Database\Eloquent\Builder::class);

        // Verify the query has the correct where clauses
        $sql = $query->toSql();
        expect($sql)->toContain('is_published');
        expect($sql)->toContain('published_at');
    });

    it('scopePublished can be chained with other methods', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        Post::factory()->create([
            'title' => 'Test Post',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'is_published' => true,
            'published_at' => Carbon::now()->subDay(),
        ]);

        $result = Post::published()->where('title', 'Test Post')->first();

        expect($result)->not->toBeNull();
        expect($result->title)->toBe('Test Post');
    });

    it('boot method registers model events correctly', function () {
        // Test that the boot method is called and events are registered
        $post = new Post;
        $events = $post->getObservableEvents();

        expect(in_array('creating', $events))->toBeTrue();
        expect(in_array('updating', $events))->toBeTrue();
    });

    it('model event handling works for slug generation', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        // Test creating event
        $post = new Post([
            'title' => 'Test Event Title',
            'content' => 'Test content',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $post->save();

        expect($post->slug)->toBe('test-event-title');
    });

    it('model updating event works for slug modification', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $post = Post::create([
            'title' => 'Original Title',
            'content' => 'Test content',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        expect($post->slug)->toBe('original-title');

        // Update the title
        $post->update(['title' => 'Updated Title']);

        expect($post->fresh()->slug)->toBe('updated-title');
    });
});
