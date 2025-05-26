<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

describe('Post Model Complete Coverage', function () {
    it('generateSlugFromTitle creates correct slug', function () {
        $reflection = new ReflectionClass(Post::class);
        $method = $reflection->getMethod('generateSlugFromTitle');
        $method->setAccessible(true);

        $slug = $method->invoke(null, 'Test Title With Spaces');
        expect($slug)->toBe('test-title-with-spaces');

        $slug2 = $method->invoke(null, 'Special!@#$%^&*()Characters');
        expect($slug2)->toBe('special-at-characters');
    });

    it('generateUniqueSlug method can be accessed via reflection', function () {
        $reflection = new ReflectionClass(Post::class);
        $method = $reflection->getMethod('generateUniqueSlug');

        expect($method->isStatic())->toBeTrue();
        expect($method->isProtected())->toBeTrue();
    });

    it('has correct static boot method', function () {
        $reflection = new ReflectionClass(Post::class);
        $method = $reflection->getMethod('boot');

        expect($method->isStatic())->toBeTrue();
        expect($method->isProtected())->toBeTrue();
    });

    it('has correct casts property', function () {
        $post = new Post;
        $casts = $post->getCasts();

        expect($casts)->toHaveKey('published_at');
        expect($casts)->toHaveKey('is_published');
        expect($casts['is_published'])->toBe('boolean');
    });

    it('has correct date casting', function () {
        $post = new Post;
        $casts = $post->getCasts();

        expect($casts)->toHaveKey('published_at');
        expect($casts['published_at'])->toContain('datetime');
    });

    it('fillable array contains all expected fields', function () {
        $post = new Post;
        $fillable = $post->getFillable();

        $expectedFields = [
            'title', 'slug', 'content', 'excerpt', 'featured_image',
            'meta_title', 'meta_description', 'published_at', 'is_published',
            'user_id', 'category_id',
        ];

        foreach ($expectedFields as $field) {
            expect(in_array($field, $fillable))->toBeTrue();
        }
    });

    it('has correct table name', function () {
        $post = new Post;
        expect($post->getTable())->toBe('posts');
    });

    it('has correct connection', function () {
        $post = new Post;
        expect($post->getConnectionName())->toBeNull(); // uses default connection
    });

    it('model uses factory trait', function () {
        $traits = class_uses(Post::class);
        expect(in_array('Illuminate\Database\Eloquent\Factories\HasFactory', $traits))->toBeTrue();
    });

    it('relationships return correct instance types', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->for($user)->for($category)->create();

        expect($post->user())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        expect($post->category())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        expect($post->tags())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class);
    });

    it('scopes return correct query builder', function () {
        expect(Post::published())->toBeInstanceOf(\Illuminate\Database\Eloquent\Builder::class);
    });

    it('model has correct timestamps setting', function () {
        $post = new Post;
        expect($post->timestamps)->toBeTrue();
    });

    it('model has correct primary key', function () {
        $post = new Post;
        expect($post->getKeyName())->toBe('id');
        expect($post->getIncrementing())->toBeTrue();
    });
});
