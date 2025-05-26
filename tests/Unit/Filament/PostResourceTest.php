<?php

use App\Filament\Resources\PostResource;
use App\Models\Post;

it('has correct model class', function () {
    expect(PostResource::getModel())->toBe(Post::class);
});

it('has navigation icon', function () {
    expect(PostResource::getNavigationIcon())->toBe('heroicon-o-document-text');
});

it('has navigation group', function () {
    expect(PostResource::getNavigationGroup())->toBe('Blog Management');
});

it('form method exists', function () {
    expect(method_exists(PostResource::class, 'form'))->toBeTrue();
});

it('table method exists', function () {
    expect(method_exists(PostResource::class, 'table'))->toBeTrue();
});

it('has correct page routes', function () {
    $pages = PostResource::getPages();

    expect($pages)->toHaveKey('index');
    expect($pages)->toHaveKey('create');
    expect($pages)->toHaveKey('edit');
});

it('getRelations method exists', function () {
    expect(method_exists(PostResource::class, 'getRelations'))->toBeTrue();
});

it('is subclass of resource', function () {
    expect(is_subclass_of(PostResource::class, 'Filament\Resources\Resource'))->toBeTrue();
});
