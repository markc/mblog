<?php

use App\Models\Page;

test('published page can be viewed', function () {
    $page = Page::factory()->create([
        'title' => 'About Us',
        'slug' => 'about-us',
        'content' => 'This is our about page content',
        'is_published' => true,
    ]);

    $response = $this->get("/page/{$page->slug}");

    $response->assertStatus(200)
        ->assertViewIs('pages.show')
        ->assertSee('About Us')
        ->assertSee('This is our about page content');
});

test('unpublished page returns 404', function () {
    $page = Page::factory()->create([
        'slug' => 'unpublished-page',
        'is_published' => false,
    ]);

    $response = $this->get("/page/{$page->slug}");

    $response->assertStatus(404);
});

test('page with meta title uses it for page title', function () {
    $page = Page::factory()->create([
        'title' => 'Regular Title',
        'meta_title' => 'SEO Optimized Page Title',
        'is_published' => true,
    ]);

    $response = $this->get("/page/{$page->slug}");

    $response->assertStatus(200)
        ->assertSee('SEO Optimized Page Title', false);
});

test('page with meta description includes it in meta tags', function () {
    $page = Page::factory()->create([
        'meta_description' => 'This is a custom page meta description',
        'is_published' => true,
    ]);

    $response = $this->get("/page/{$page->slug}");

    $response->assertStatus(200)
        ->assertSee('This is a custom page meta description', false);
});

test('non-existent page returns 404', function () {
    $response = $this->get('/page/non-existent-page');

    $response->assertStatus(404);
});

test('page displays without sidebar or blog metadata', function () {
    $page = Page::factory()->create([
        'title' => 'Privacy Policy',
        'content' => 'This is our privacy policy content',
        'is_published' => true,
    ]);

    $response = $this->get("/page/{$page->slug}");

    $response->assertStatus(200)
        ->assertSee('Privacy Policy')
        ->assertSee('This is our privacy policy content')
        ->assertDontSee('Author:')
        ->assertDontSee('Category:');
});

test('page content can contain html', function () {
    $page = Page::factory()->create([
        'title' => 'HTML Page',
        'content' => '<h2>Subheading</h2><p>This is <strong>bold</strong> text.</p>',
        'is_published' => true,
    ]);

    $response = $this->get("/page/{$page->slug}");

    $response->assertStatus(200)
        ->assertSee('<h2>Subheading</h2>', false)
        ->assertSee('<strong>bold</strong>', false);
});
