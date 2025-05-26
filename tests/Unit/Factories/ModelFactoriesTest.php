<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

describe('Model Factories', function () {
    it('can create user via factory', function () {
        $user = User::factory()->create();

        expect($user)->toBeInstanceOf(User::class);
        expect($user->name)->not->toBeEmpty();
        expect($user->email)->not->toBeEmpty();
    });

    it('can create category via factory', function () {
        $category = Category::factory()->create();

        expect($category)->toBeInstanceOf(Category::class);
        expect($category->name)->not->toBeEmpty();
        expect($category->slug)->not->toBeEmpty();
    });

    it('can create tag via factory', function () {
        $tag = Tag::factory()->create();

        expect($tag)->toBeInstanceOf(Tag::class);
        expect($tag->name)->not->toBeEmpty();
        expect($tag->slug)->not->toBeEmpty();
    });

    it('can create page via factory', function () {
        $page = Page::factory()->create();

        expect($page)->toBeInstanceOf(Page::class);
        expect($page->title)->not->toBeEmpty();
        expect($page->slug)->not->toBeEmpty();
        expect($page->content)->not->toBeEmpty();
    });

    it('can create post via factory', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $post = Post::factory()
            ->for($user)
            ->for($category)
            ->create();

        expect($post)->toBeInstanceOf(Post::class);
        expect($post->title)->not->toBeEmpty();
        expect($post->slug)->not->toBeEmpty();
        expect($post->content)->not->toBeEmpty();
        expect($post->user_id)->toBe($user->id);
        expect($post->category_id)->toBe($category->id);
    });

    it('factories create unique slugs', function () {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        expect($category1->slug)->not->toBe($category2->slug);
    });

    it('can create multiple models', function () {
        $users = User::factory()->count(3)->create();
        $categories = Category::factory()->count(3)->create();

        expect($users)->toHaveCount(3);
        expect($categories)->toHaveCount(3);
    });

    it('post factory can attach tags', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $tags = Tag::factory()->count(3)->create();

        $post = Post::factory()
            ->for($user)
            ->for($category)
            ->hasAttached($tags)
            ->create();

        expect($post->tags)->toHaveCount(3);
    });
});
