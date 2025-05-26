<?php

use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\CategoryResource\Pages\ListCategories;

describe('CategoryResource Pages', function () {
    it('CreateCategory has correct resource', function () {
        expect(CreateCategory::getResource())->toBe(CategoryResource::class);
    });

    it('CreateCategory extends create record page', function () {
        expect(is_subclass_of(CreateCategory::class, 'Filament\Resources\Pages\CreateRecord'))->toBeTrue();
    });

    it('EditCategory has correct resource', function () {
        expect(EditCategory::getResource())->toBe(CategoryResource::class);
    });

    it('EditCategory extends edit record page', function () {
        expect(is_subclass_of(EditCategory::class, 'Filament\Resources\Pages\EditRecord'))->toBeTrue();
    });

    it('EditCategory has getHeaderActions method', function () {
        expect(method_exists(EditCategory::class, 'getHeaderActions'))->toBeTrue();
    });

    it('ListCategories has correct resource', function () {
        expect(ListCategories::getResource())->toBe(CategoryResource::class);
    });

    it('ListCategories extends list records page', function () {
        expect(is_subclass_of(ListCategories::class, 'Filament\Resources\Pages\ListRecords'))->toBeTrue();
    });

    it('ListCategories has getHeaderActions method', function () {
        expect(method_exists(ListCategories::class, 'getHeaderActions'))->toBeTrue();
    });

    it('EditCategory can be instantiated', function () {
        $page = new EditCategory;
        expect($page)->toBeInstanceOf(EditCategory::class);
    });

    it('ListCategories can be instantiated', function () {
        $page = new ListCategories;
        expect($page)->toBeInstanceOf(ListCategories::class);
    });

    it('CreateCategory can be instantiated', function () {
        $page = new CreateCategory;
        expect($page)->toBeInstanceOf(CreateCategory::class);
    });
});
