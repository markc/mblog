<?php

use App\Http\Controllers\PageController;
use App\Models\Page;

beforeEach(function () {
    $this->controller = new PageController;
});

test('show method returns page view for published page', function () {
    $page = Page::factory()->create([
        'slug' => 'about-us',
        'is_published' => true,
    ]);

    $response = $this->get("/page/{$page->slug}");

    $response->assertViewIs('pages.show');

    $viewPage = $response->viewData('page');
    expect($viewPage->id)->toBe($page->id);
});

test('show method throws 404 for unpublished page', function () {
    $page = Page::factory()->create([
        'slug' => 'unpublished-page',
        'is_published' => false,
    ]);

    $this->get("/page/{$page->slug}")
        ->assertStatus(404);
});

test('show method throws 404 for non-existent page', function () {
    $this->get('/page/non-existent-page')
        ->assertStatus(404);
});

test('show method returns page with all content', function () {
    $page = Page::factory()->create([
        'title' => 'Test Page',
        'content' => 'This is test page content',
        'meta_title' => 'Test Page Meta Title',
        'meta_description' => 'Test page meta description',
        'is_published' => true,
    ]);

    $response = $this->get("/page/{$page->slug}");

    $viewPage = $response->viewData('page');

    expect($viewPage->title)->toBe('Test Page');
    expect($viewPage->content)->toBe('This is test page content');
    expect($viewPage->meta_title)->toBe('Test Page Meta Title');
    expect($viewPage->meta_description)->toBe('Test page meta description');
});
