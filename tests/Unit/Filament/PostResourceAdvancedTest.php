<?php

use App\Filament\Resources\PostResource;
use App\Models\Post;

describe('PostResource Advanced Coverage', function () {
    it('has correct model binding', function () {
        $resource = new PostResource;
        expect($resource::getModel())->toBe(Post::class);
    });

    it('has protected static model property', function () {
        $reflection = new ReflectionClass(PostResource::class);
        $property = $reflection->getProperty('model');

        expect($property->isStatic())->toBeTrue();
        expect($property->isProtected())->toBeTrue();
    });

    it('has protected static navigation icon property', function () {
        $reflection = new ReflectionClass(PostResource::class);
        $property = $reflection->getProperty('navigationIcon');

        expect($property->isStatic())->toBeTrue();
        expect($property->isProtected())->toBeTrue();
    });

    it('has protected static navigation group property', function () {
        $reflection = new ReflectionClass(PostResource::class);
        $property = $reflection->getProperty('navigationGroup');

        expect($property->isStatic())->toBeTrue();
        expect($property->isProtected())->toBeTrue();
    });

    it('form method returns Form instance', function () {
        $method = new ReflectionMethod(PostResource::class, 'form');
        expect($method->isPublic())->toBeTrue();
        expect($method->isStatic())->toBeTrue();
    });

    it('table method returns Table instance', function () {
        $method = new ReflectionMethod(PostResource::class, 'table');
        expect($method->isPublic())->toBeTrue();
        expect($method->isStatic())->toBeTrue();
    });

    it('getRelations method returns array', function () {
        $relations = PostResource::getRelations();
        expect($relations)->toBeArray();
    });

    it('getPages method returns correct structure', function () {
        $pages = PostResource::getPages();

        expect($pages)->toBeArray();
        expect($pages)->toHaveCount(3);
        expect($pages)->toHaveKeys(['index', 'create', 'edit']);
    });

    it('extends Resource class', function () {
        expect(is_subclass_of(PostResource::class, 'Filament\Resources\Resource'))->toBeTrue();
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(PostResource::class);
        expect($reflection->getNamespaceName())->toBe('App\Filament\Resources');
    });

    it('class is not abstract', function () {
        $reflection = new ReflectionClass(PostResource::class);
        expect($reflection->isAbstract())->toBeFalse();
    });

    it('class is not final', function () {
        $reflection = new ReflectionClass(PostResource::class);
        expect($reflection->isFinal())->toBeFalse();
    });

    it('has all required static methods', function () {
        expect(method_exists(PostResource::class, 'form'))->toBeTrue();
        expect(method_exists(PostResource::class, 'table'))->toBeTrue();
        expect(method_exists(PostResource::class, 'getRelations'))->toBeTrue();
        expect(method_exists(PostResource::class, 'getPages'))->toBeTrue();
        expect(method_exists(PostResource::class, 'getModel'))->toBeTrue();
    });
});
