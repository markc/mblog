<?php

use App\Providers\AppServiceProvider;

it('can be instantiated', function () {
    $provider = new AppServiceProvider(app());

    expect($provider)->toBeInstanceOf(AppServiceProvider::class);
});

it('has register method', function () {
    $provider = new AppServiceProvider(app());

    expect(method_exists($provider, 'register'))->toBeTrue();
});

it('has boot method', function () {
    $provider = new AppServiceProvider(app());

    expect(method_exists($provider, 'boot'))->toBeTrue();
});

it('register method can be called', function () {
    $provider = new AppServiceProvider(app());

    expect(fn () => $provider->register())->not->toThrow(Exception::class);
});

it('boot method can be called', function () {
    $provider = new AppServiceProvider(app());

    expect(fn () => $provider->boot())->not->toThrow(Exception::class);
});
