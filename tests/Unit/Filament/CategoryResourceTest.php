<?php

use App\Filament\Resources\CategoryResource;
use App\Models\Category;

it('has correct model class', function () {
    expect(CategoryResource::getModel())->toBe(Category::class);
});

it('has navigation icon', function () {
    expect(CategoryResource::getNavigationIcon())->toBe('heroicon-o-folder');
});

it('has navigation group', function () {
    expect(CategoryResource::getNavigationGroup())->toBe('Blog Management');
});

it('form method exists', function () {
    expect(method_exists(CategoryResource::class, 'form'))->toBeTrue();
});

it('table method exists', function () {
    expect(method_exists(CategoryResource::class, 'table'))->toBeTrue();
});

it('has correct page routes', function () {
    $pages = CategoryResource::getPages();

    expect($pages)->toHaveKey('index');
    expect($pages)->toHaveKey('create');
    expect($pages)->toHaveKey('edit');
});
