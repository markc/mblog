<?php

use App\Filament\Pages\Settings;
use App\Models\Setting;

beforeEach(function () {
    // Clear any existing settings
    Setting::query()->delete();
});

it('has correct navigation icon', function () {
    expect(Settings::getNavigationIcon())->toBe('heroicon-o-cog-6-tooth');
});

it('has navigation group', function () {
    expect(Settings::getNavigationGroup())->toBe('System');
});

it('has correct view name', function () {
    $page = new Settings;
    expect($page->getView())->toBe('filament.pages.settings');
});

it('initializes with default values', function () {
    $page = new Settings;
    $page->mount();

    expect($page->data)->not->toBeEmpty();
});

it('form method exists', function () {
    expect(method_exists(Settings::class, 'form'))->toBeTrue();
});

it('save method exists', function () {
    expect(method_exists(Settings::class, 'save'))->toBeTrue();
});

it('mount fills form with setting values', function () {
    Setting::set('site_name', 'Test Blog');
    Setting::set('posts_per_page', 15);

    $page = new Settings;
    $page->mount();

    expect($page->data['site_name'])->toBe('Test Blog');
    expect($page->data['posts_per_page'])->toBe(15);
});

it('mount uses default values when settings do not exist', function () {
    $page = new Settings;
    $page->mount();

    expect($page->data['site_name'])->toBe('My Blog');
    expect($page->data['posts_per_page'])->toBe(10);
    expect($page->data['enable_comments'])->toBe(true);
});
