<?php

use App\Filament\Resources\PageResource;
use App\Models\Page;

it('has correct model class', function () {
    expect(PageResource::getModel())->toBe(Page::class);
});

it('has navigation icon', function () {
    expect(PageResource::getNavigationIcon())->toBe('heroicon-o-document');
});

it('has navigation group', function () {
    expect(PageResource::getNavigationGroup())->toBe('Blog Management');
});

it('form method exists', function () {
    expect(method_exists(PageResource::class, 'form'))->toBeTrue();
});

it('table method exists', function () {
    expect(method_exists(PageResource::class, 'table'))->toBeTrue();
});

it('has correct page routes', function () {
    $pages = PageResource::getPages();

    expect($pages)->toHaveKey('index');
    expect($pages)->toHaveKey('create');
    expect($pages)->toHaveKey('edit');
});
