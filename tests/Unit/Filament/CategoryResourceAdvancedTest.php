<?php

use App\Filament\Resources\CategoryResource;
use App\Models\Category;

describe('CategoryResource Advanced Coverage', function () {
    it('has correct model binding', function () {
        $resource = new CategoryResource;
        expect($resource::getModel())->toBe(Category::class);
    });

    it('has protected static properties', function () {
        $reflection = new ReflectionClass(CategoryResource::class);

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
        $relations = CategoryResource::getRelations();
        expect($relations)->toBeArray();
    });

    it('getPages method returns correct structure', function () {
        $pages = CategoryResource::getPages();

        expect($pages)->toBeArray();
        expect($pages)->toHaveCount(3);
        expect($pages)->toHaveKeys(['index', 'create', 'edit']);
    });

    it('extends Resource class', function () {
        expect(is_subclass_of(CategoryResource::class, 'Filament\Resources\Resource'))->toBeTrue();
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(CategoryResource::class);
        expect($reflection->getNamespaceName())->toBe('App\Filament\Resources');
    });

    it('class properties are accessible', function () {
        $reflection = new ReflectionClass(CategoryResource::class);
        expect($reflection->hasProperty('model'))->toBeTrue();
        expect($reflection->hasProperty('navigationIcon'))->toBeTrue();
        expect($reflection->hasProperty('navigationGroup'))->toBeTrue();
    });

    it('has all required static methods', function () {
        expect(method_exists(CategoryResource::class, 'form'))->toBeTrue();
        expect(method_exists(CategoryResource::class, 'table'))->toBeTrue();
        expect(method_exists(CategoryResource::class, 'getRelations'))->toBeTrue();
        expect(method_exists(CategoryResource::class, 'getPages'))->toBeTrue();
        expect(method_exists(CategoryResource::class, 'getModel'))->toBeTrue();
    });

    it('methods have correct visibility', function () {
        $formMethod = new ReflectionMethod(CategoryResource::class, 'form');
        expect($formMethod->isPublic())->toBeTrue();
        expect($formMethod->isStatic())->toBeTrue();

        $tableMethod = new ReflectionMethod(CategoryResource::class, 'table');
        expect($tableMethod->isPublic())->toBeTrue();
        expect($tableMethod->isStatic())->toBeTrue();
    });
});
