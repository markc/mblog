<?php

use App\Filament\Resources\TagResource;
use App\Models\Tag;

it('has correct model class', function () {
    expect(TagResource::getModel())->toBe(Tag::class);
});

it('has navigation icon', function () {
    expect(TagResource::getNavigationIcon())->toBe('heroicon-o-tag');
});

it('has navigation group', function () {
    expect(TagResource::getNavigationGroup())->toBe('Blog Management');
});

it('form method exists', function () {
    expect(method_exists(TagResource::class, 'form'))->toBeTrue();
});

it('table method exists', function () {
    expect(method_exists(TagResource::class, 'table'))->toBeTrue();
});

it('has correct page routes', function () {
    $pages = TagResource::getPages();

    expect($pages)->toHaveKey('index');
    expect($pages)->toHaveKey('create');
    expect($pages)->toHaveKey('edit');
});
