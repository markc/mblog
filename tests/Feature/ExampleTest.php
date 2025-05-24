<?php

use App\Models\Category;
use App\Models\Setting;
use App\Models\User;

it('returns a successful response', function () {
    // Create necessary data for the homepage to work
    User::factory()->create();
    Category::create(['name' => 'Test Category', 'slug' => 'test-category']);
    Setting::set('posts_per_page', 10);
    Setting::set('site_name', 'Test Blog');
    Setting::set('site_description', 'Test Description');

    $response = $this->get('/');

    $response->assertStatus(200);
});
