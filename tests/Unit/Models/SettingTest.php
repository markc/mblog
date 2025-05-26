<?php

use App\Models\Setting;

test('setting can be created with valid data', function () {
    $setting = Setting::create([
        'key' => 'site_name',
        'value' => 'My Blog',
    ]);

    expect($setting)->toBeInstanceOf(Setting::class)
        ->and($setting->key)->toBe('site_name')
        ->and($setting->value)->toBe('My Blog');
});

test('setting value is cast to json', function () {
    $setting = Setting::create([
        'key' => 'complex_setting',
        'value' => ['name' => 'value', 'number' => 42],
    ]);

    expect($setting->value)->toBeArray()
        ->and($setting->value['name'])->toBe('value')
        ->and($setting->value['number'])->toBe(42);
});

test('setting get method returns value by key', function () {
    Setting::create([
        'key' => 'test_setting',
        'value' => 'test_value',
    ]);

    $value = Setting::get('test_setting');

    expect($value)->toBe('test_value');
});

test('setting get method returns default when key not found', function () {
    $value = Setting::get('non_existent_key', 'default_value');

    expect($value)->toBe('default_value');
});

test('setting get method returns null when no default provided', function () {
    $value = Setting::get('non_existent_key');

    expect($value)->toBeNull();
});

test('setting set method creates new setting', function () {
    Setting::set('new_setting', 'new_value');

    $setting = Setting::where('key', 'new_setting')->first();

    expect($setting)->not->toBeNull()
        ->and($setting->value)->toBe('new_value');
});

test('setting set method updates existing setting', function () {
    Setting::create([
        'key' => 'existing_setting',
        'value' => 'old_value',
    ]);

    Setting::set('existing_setting', 'new_value');

    $setting = Setting::where('key', 'existing_setting')->first();

    expect($setting->value)->toBe('new_value')
        ->and(Setting::where('key', 'existing_setting')->count())->toBe(1);
});

test('setting fillable attributes are correct', function () {
    $setting = new Setting;

    expect($setting->getFillable())->toContain('key', 'value');
});

test('setting requires key', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    Setting::create([
        'value' => 'test_value',
    ]);
});

test('setting can store complex json data', function () {
    $complexData = [
        'theme' => 'dark',
        'features' => ['comments', 'social_sharing'],
        'metadata' => [
            'version' => '1.0',
            'author' => 'John Doe',
        ],
    ];

    Setting::set('app_config', $complexData);
    $retrieved = Setting::get('app_config');

    expect($retrieved)->toBeArray()
        ->and($retrieved['theme'])->toBe('dark')
        ->and($retrieved['features'])->toContain('comments', 'social_sharing')
        ->and($retrieved['metadata']['version'])->toBe('1.0');
});
