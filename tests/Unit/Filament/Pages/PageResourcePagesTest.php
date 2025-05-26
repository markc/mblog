<?php

use App\Filament\Resources\PageResource;
use App\Filament\Resources\PageResource\Pages\CreatePage;
use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\PageResource\Pages\ListPages;

describe('PageResource Pages', function () {
    it('CreatePage has correct resource', function () {
        expect(CreatePage::getResource())->toBe(PageResource::class);
    });

    it('CreatePage extends create record page', function () {
        expect(is_subclass_of(CreatePage::class, 'Filament\Resources\Pages\CreateRecord'))->toBeTrue();
    });

    it('EditPage has correct resource', function () {
        expect(EditPage::getResource())->toBe(PageResource::class);
    });

    it('EditPage extends edit record page', function () {
        expect(is_subclass_of(EditPage::class, 'Filament\Resources\Pages\EditRecord'))->toBeTrue();
    });

    it('EditPage has getHeaderActions method', function () {
        expect(method_exists(EditPage::class, 'getHeaderActions'))->toBeTrue();
    });

    it('ListPages has correct resource', function () {
        expect(ListPages::getResource())->toBe(PageResource::class);
    });

    it('ListPages extends list records page', function () {
        expect(is_subclass_of(ListPages::class, 'Filament\Resources\Pages\ListRecords'))->toBeTrue();
    });

    it('ListPages has getHeaderActions method', function () {
        expect(method_exists(ListPages::class, 'getHeaderActions'))->toBeTrue();
    });

    it('EditPage can be instantiated', function () {
        $page = new EditPage;
        expect($page)->toBeInstanceOf(EditPage::class);
    });

    it('ListPages can be instantiated', function () {
        $page = new ListPages;
        expect($page)->toBeInstanceOf(ListPages::class);
    });

    it('CreatePage can be instantiated', function () {
        $page = new CreatePage;
        expect($page)->toBeInstanceOf(CreatePage::class);
    });
});
