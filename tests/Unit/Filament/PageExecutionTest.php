<?php

use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\CategoryResource\Pages\ListCategories;
use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\PageResource\Pages\ListPages;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Filament\Resources\TagResource\Pages\EditTag;
use App\Filament\Resources\TagResource\Pages\ListTags;

describe('Filament Page Method Execution', function () {
    it('EditPost getHeaderActions method is accessible via reflection', function () {
        $page = new EditPost;
        $reflection = new ReflectionClass($page);
        $method = $reflection->getMethod('getHeaderActions');
        $method->setAccessible(true);

        $actions = $method->invoke($page);

        expect($actions)->toBeArray();
        expect($actions)->not->toBeEmpty();
    });

    it('ListPosts getHeaderActions method is accessible via reflection', function () {
        $page = new ListPosts;
        $reflection = new ReflectionClass($page);
        $method = $reflection->getMethod('getHeaderActions');
        $method->setAccessible(true);

        $actions = $method->invoke($page);

        expect($actions)->toBeArray();
        expect($actions)->not->toBeEmpty();
    });

    it('EditCategory getHeaderActions method is accessible via reflection', function () {
        $page = new EditCategory;
        $reflection = new ReflectionClass($page);
        $method = $reflection->getMethod('getHeaderActions');
        $method->setAccessible(true);

        $actions = $method->invoke($page);

        expect($actions)->toBeArray();
        expect($actions)->not->toBeEmpty();
    });

    it('ListCategories getHeaderActions method is accessible via reflection', function () {
        $page = new ListCategories;
        $reflection = new ReflectionClass($page);
        $method = $reflection->getMethod('getHeaderActions');
        $method->setAccessible(true);

        $actions = $method->invoke($page);

        expect($actions)->toBeArray();
        expect($actions)->not->toBeEmpty();
    });

    it('EditPage getHeaderActions method is accessible via reflection', function () {
        $page = new EditPage;
        $reflection = new ReflectionClass($page);
        $method = $reflection->getMethod('getHeaderActions');
        $method->setAccessible(true);

        $actions = $method->invoke($page);

        expect($actions)->toBeArray();
        expect($actions)->not->toBeEmpty();
    });

    it('ListPages getHeaderActions method is accessible via reflection', function () {
        $page = new ListPages;
        $reflection = new ReflectionClass($page);
        $method = $reflection->getMethod('getHeaderActions');
        $method->setAccessible(true);

        $actions = $method->invoke($page);

        expect($actions)->toBeArray();
        expect($actions)->not->toBeEmpty();
    });

    it('EditTag getHeaderActions method is accessible via reflection', function () {
        $page = new EditTag;
        $reflection = new ReflectionClass($page);
        $method = $reflection->getMethod('getHeaderActions');
        $method->setAccessible(true);

        $actions = $method->invoke($page);

        expect($actions)->toBeArray();
        expect($actions)->not->toBeEmpty();
    });

    it('ListTags getHeaderActions method is accessible via reflection', function () {
        $page = new ListTags;
        $reflection = new ReflectionClass($page);
        $method = $reflection->getMethod('getHeaderActions');
        $method->setAccessible(true);

        $actions = $method->invoke($page);

        expect($actions)->toBeArray();
        expect($actions)->not->toBeEmpty();
    });
});
