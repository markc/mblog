<?php

use App\Filament\Resources\PostResource;
use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\Pages\ListPosts;

describe('PostResource Pages', function () {
    it('CreatePost has correct resource', function () {
        expect(CreatePost::getResource())->toBe(PostResource::class);
    });

    it('CreatePost extends create record page', function () {
        expect(is_subclass_of(CreatePost::class, 'Filament\Resources\Pages\CreateRecord'))->toBeTrue();
    });

    it('EditPost has correct resource', function () {
        expect(EditPost::getResource())->toBe(PostResource::class);
    });

    it('EditPost extends edit record page', function () {
        expect(is_subclass_of(EditPost::class, 'Filament\Resources\Pages\EditRecord'))->toBeTrue();
    });

    it('EditPost has getHeaderActions method', function () {
        expect(method_exists(EditPost::class, 'getHeaderActions'))->toBeTrue();
    });

    it('ListPosts has correct resource', function () {
        expect(ListPosts::getResource())->toBe(PostResource::class);
    });

    it('ListPosts extends list records page', function () {
        expect(is_subclass_of(ListPosts::class, 'Filament\Resources\Pages\ListRecords'))->toBeTrue();
    });

    it('ListPosts has getHeaderActions method', function () {
        expect(method_exists(ListPosts::class, 'getHeaderActions'))->toBeTrue();
    });

    it('EditPost can be instantiated', function () {
        $page = new EditPost;
        expect($page)->toBeInstanceOf(EditPost::class);
    });

    it('ListPosts can be instantiated', function () {
        $page = new ListPosts;
        expect($page)->toBeInstanceOf(ListPosts::class);
    });

    it('CreatePost can be instantiated', function () {
        $page = new CreatePost;
        expect($page)->toBeInstanceOf(CreatePost::class);
    });
});
