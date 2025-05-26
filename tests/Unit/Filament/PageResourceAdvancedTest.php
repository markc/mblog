<?php

use App\Filament\Resources\PageResource;
use App\Models\Page;

describe('PageResource Advanced Coverage', function () {
    it('has correct model binding', function () {
        $resource = new PageResource;
        expect($resource::getModel())->toBe(Page::class);
    });

    it('has protected static properties', function () {
        $reflection = new ReflectionClass(PageResource::class);

        $modelProperty = $reflection->getProperty('model');
        expect($modelProperty->isStatic())->toBeTrue();
        expect($modelProperty->isProtected())->toBeTrue();

        $iconProperty = $reflection->getProperty('navigationIcon');
        expect($iconProperty->isStatic())->toBeTrue();
        expect($iconProperty->isProtected())->toBeTrue();

        $groupProperty = $reflection->getProperty('navigationGroup');
        expect($groupProperty->isStatic())->toBeTrue();
        expect($groupProperty->isProtected())->toBeTrue();
    });

    it('getRelations method returns array', function () {
        $relations = PageResource::getRelations();
        expect($relations)->toBeArray();
    });

    it('getPages method returns correct structure', function () {
        $pages = PageResource::getPages();

        expect($pages)->toBeArray();
        expect($pages)->toHaveCount(3);
        expect($pages)->toHaveKeys(['index', 'create', 'edit']);
    });

    it('extends Resource class', function () {
        expect(is_subclass_of(PageResource::class, 'Filament\Resources\Resource'))->toBeTrue();
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(PageResource::class);
        expect($reflection->getNamespaceName())->toBe('App\Filament\Resources');
    });

    it('class properties are accessible', function () {
        $reflection = new ReflectionClass(PageResource::class);
        expect($reflection->hasProperty('model'))->toBeTrue();
        expect($reflection->hasProperty('navigationIcon'))->toBeTrue();
        expect($reflection->hasProperty('navigationGroup'))->toBeTrue();
    });

    it('has all required static methods', function () {
        expect(method_exists(PageResource::class, 'form'))->toBeTrue();
        expect(method_exists(PageResource::class, 'table'))->toBeTrue();
        expect(method_exists(PageResource::class, 'getRelations'))->toBeTrue();
        expect(method_exists(PageResource::class, 'getPages'))->toBeTrue();
        expect(method_exists(PageResource::class, 'getModel'))->toBeTrue();
    });

    it('methods have correct visibility', function () {
        $formMethod = new ReflectionMethod(PageResource::class, 'form');
        expect($formMethod->isPublic())->toBeTrue();
        expect($formMethod->isStatic())->toBeTrue();

        $tableMethod = new ReflectionMethod(PageResource::class, 'table');
        expect($tableMethod->isPublic())->toBeTrue();
        expect($tableMethod->isStatic())->toBeTrue();
    });

    it('class is instantiable', function () {
        $resource = new PageResource;
        expect($resource)->toBeInstanceOf(PageResource::class);
    });
});
