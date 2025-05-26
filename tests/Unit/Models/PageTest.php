<?php

use App\Models\Page;

test('page can be created with valid data', function () {
    $page = Page::create([
        'title' => 'About Us',
        'slug' => 'about-us',
        'content' => 'This is our about page content',
        'meta_title' => 'About Us - Site Name',
        'meta_description' => 'Learn more about us',
        'is_published' => true,
    ]);

    expect($page)->toBeInstanceOf(Page::class)
        ->and($page->title)->toBe('About Us')
        ->and($page->slug)->toBe('about-us')
        ->and($page->is_published)->toBeTrue();
});

test('page published scope returns only published pages', function () {
    Page::factory()->create(['is_published' => true]);
    Page::factory()->create(['is_published' => false]);

    $publishedPages = Page::published()->get();

    expect($publishedPages)->toHaveCount(1);
});

test('page is_published is cast to boolean', function () {
    $page = Page::factory()->create(['is_published' => 1]);

    expect($page->is_published)->toBeTrue();
});

test('page requires title', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    Page::create([
        'slug' => 'test-page',
        'content' => 'Content',
    ]);
});

test('page requires slug', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    Page::create([
        'title' => 'Test Page',
        'content' => 'Content',
    ]);
});

test('page fillable attributes are correct', function () {
    $page = new Page;

    expect($page->getFillable())->toContain(
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'is_published'
    );
});

test('page can be updated', function () {
    $page = Page::factory()->create(['title' => 'Old Title']);

    $page->update(['title' => 'New Title']);

    expect($page->fresh()->title)->toBe('New Title');
});

test('page meta fields are optional', function () {
    $page = Page::create([
        'title' => 'Simple Page',
        'slug' => 'simple-page',
        'content' => 'Simple content',
        'is_published' => true,
    ]);

    expect($page->meta_title)->toBeNull()
        ->and($page->meta_description)->toBeNull();
});
