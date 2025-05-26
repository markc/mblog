<?php

use App\Filament\Resources\TagResource;
use App\Filament\Resources\TagResource\Pages\CreateTag;
use App\Filament\Resources\TagResource\Pages\EditTag;
use App\Filament\Resources\TagResource\Pages\ListTags;

describe('TagResource Pages', function () {
    it('CreateTag has correct resource', function () {
        expect(CreateTag::getResource())->toBe(TagResource::class);
    });

    it('CreateTag extends create record page', function () {
        expect(is_subclass_of(CreateTag::class, 'Filament\Resources\Pages\CreateRecord'))->toBeTrue();
    });

    it('EditTag has correct resource', function () {
        expect(EditTag::getResource())->toBe(TagResource::class);
    });

    it('EditTag extends edit record page', function () {
        expect(is_subclass_of(EditTag::class, 'Filament\Resources\Pages\EditRecord'))->toBeTrue();
    });

    it('EditTag has getHeaderActions method', function () {
        expect(method_exists(EditTag::class, 'getHeaderActions'))->toBeTrue();
    });

    it('ListTags has correct resource', function () {
        expect(ListTags::getResource())->toBe(TagResource::class);
    });

    it('ListTags extends list records page', function () {
        expect(is_subclass_of(ListTags::class, 'Filament\Resources\Pages\ListRecords'))->toBeTrue();
    });

    it('ListTags has getHeaderActions method', function () {
        expect(method_exists(ListTags::class, 'getHeaderActions'))->toBeTrue();
    });

    it('EditTag can be instantiated', function () {
        $page = new EditTag;
        expect($page)->toBeInstanceOf(EditTag::class);
    });

    it('ListTags can be instantiated', function () {
        $page = new ListTags;
        expect($page)->toBeInstanceOf(ListTags::class);
    });

    it('CreateTag can be instantiated', function () {
        $page = new CreateTag;
        expect($page)->toBeInstanceOf(CreateTag::class);
    });
});
