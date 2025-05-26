<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

describe('Model Advanced Features', function () {
    it('category model has correct table name', function () {
        $category = new Category;
        expect($category->getTable())->toBe('categories');
    });

    it('page model has correct table name', function () {
        $page = new Page;
        expect($page->getTable())->toBe('pages');
    });

    it('post model has correct table name', function () {
        $post = new Post;
        expect($post->getTable())->toBe('posts');
    });

    it('tag model has correct table name', function () {
        $tag = new Tag;
        expect($tag->getTable())->toBe('tags');
    });

    it('user model has correct table name', function () {
        $user = new User;
        expect($user->getTable())->toBe('users');
    });

    it('models have timestamps enabled', function () {
        expect((new Category)->timestamps)->toBeTrue();
        expect((new Page)->timestamps)->toBeTrue();
        expect((new Post)->timestamps)->toBeTrue();
        expect((new Tag)->timestamps)->toBeTrue();
        expect((new User)->timestamps)->toBeTrue();
    });

    it('models have correct primary key', function () {
        expect((new Category)->getKeyName())->toBe('id');
        expect((new Page)->getKeyName())->toBe('id');
        expect((new Post)->getKeyName())->toBe('id');
        expect((new Tag)->getKeyName())->toBe('id');
        expect((new User)->getKeyName())->toBe('id');
    });

    it('models have incrementing primary keys', function () {
        expect((new Category)->incrementing)->toBeTrue();
        expect((new Page)->incrementing)->toBeTrue();
        expect((new Post)->incrementing)->toBeTrue();
        expect((new Tag)->incrementing)->toBeTrue();
        expect((new User)->incrementing)->toBeTrue();
    });

    it('post model has correct relationship methods', function () {
        $post = new Post;

        expect(method_exists($post, 'user'))->toBeTrue();
        expect(method_exists($post, 'category'))->toBeTrue();
        expect(method_exists($post, 'tags'))->toBeTrue();
    });

    it('category model has posts relationship', function () {
        $category = new Category;

        expect(method_exists($category, 'posts'))->toBeTrue();
    });

    it('tag model has posts relationship', function () {
        $tag = new Tag;

        expect(method_exists($tag, 'posts'))->toBeTrue();
    });

    it('user model has posts relationship', function () {
        $user = new User;

        expect(method_exists($user, 'posts'))->toBeTrue();
    });
});
