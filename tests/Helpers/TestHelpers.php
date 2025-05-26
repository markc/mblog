<?php

namespace Tests\Helpers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class TestHelpers
{
    /**
     * Create a published post with all required relationships.
     */
    public static function createPublishedPost(array $attributes = []): Post
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        return Post::factory()->create(array_merge([
            'is_published' => true,
            'published_at' => now()->subDay(),
            'user_id' => $user->id,
            'category_id' => $category->id,
        ], $attributes));
    }

    /**
     * Create a post with tags attached.
     */
    public static function createPostWithTags(int $tagCount = 3, array $attributes = []): Post
    {
        $post = self::createPublishedPost($attributes);
        $tags = Tag::factory()->count($tagCount)->create();

        $post->tags()->attach($tags);

        return $post;
    }

    /**
     * Create multiple posts for pagination testing.
     */
    public static function createPostsForPagination(int $count = 15): \Illuminate\Database\Eloquent\Collection
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        return Post::factory()->count($count)->create([
            'is_published' => true,
            'published_at' => now()->subDay(),
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
    }

    /**
     * Create a mix of published and unpublished posts.
     */
    public static function createMixedPosts(int $published = 3, int $unpublished = 2): array
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $publishedPosts = Post::factory()->count($published)->create([
            'is_published' => true,
            'published_at' => now()->subDay(),
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $unpublishedPosts = Post::factory()->count($unpublished)->create([
            'is_published' => false,
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        return [
            'published' => $publishedPosts,
            'unpublished' => $unpublishedPosts,
        ];
    }
}
