<?php

use App\Console\Commands\PintCommand;
use Illuminate\Console\Command;

describe('PintCommand Advanced Coverage', function () {
    it('extends Console Command', function () {
        expect(is_subclass_of(PintCommand::class, Command::class))->toBeTrue();
    });

    it('has correct signature property', function () {
        $command = new PintCommand;
        $reflection = new ReflectionClass($command);
        $property = $reflection->getProperty('signature');
        $property->setAccessible(true);

        $signature = $property->getValue($command);
        expect($signature)->toBe('pint {--test : Run in test mode} {--dirty : Only fix files with uncommitted changes}');
    });

    it('has correct description property', function () {
        $command = new PintCommand;
        $reflection = new ReflectionClass($command);
        $property = $reflection->getProperty('description');
        $property->setAccessible(true);

        $description = $property->getValue($command);
        expect($description)->toBe('Run Laravel Pint code style fixer');
    });

    it('signature contains test option', function () {
        $command = new PintCommand;
        $reflection = new ReflectionClass($command);
        $property = $reflection->getProperty('signature');
        $property->setAccessible(true);

        $signature = $property->getValue($command);
        expect($signature)->toContain('--test');
    });

    it('signature contains dirty option', function () {
        $command = new PintCommand;
        $reflection = new ReflectionClass($command);
        $property = $reflection->getProperty('signature');
        $property->setAccessible(true);

        $signature = $property->getValue($command);
        expect($signature)->toContain('--dirty');
    });

    it('handle method exists and is public', function () {
        expect(method_exists(PintCommand::class, 'handle'))->toBeTrue();

        $method = new ReflectionMethod(PintCommand::class, 'handle');
        expect($method->isPublic())->toBeTrue();
    });

    it('class has correct namespace', function () {
        $reflection = new ReflectionClass(PintCommand::class);
        expect($reflection->getNamespaceName())->toBe('App\Console\Commands');
    });

    it('command name is pint', function () {
        $command = new PintCommand;
        expect($command->getName())->toBe('pint');
    });

    it('can be instantiated', function () {
        $command = new PintCommand;
        expect($command)->toBeInstanceOf(PintCommand::class);
    });

    it('has parent constructor available', function () {
        $reflection = new ReflectionClass(PintCommand::class);
        $constructor = $reflection->getConstructor();
        expect($constructor)->not->toBeNull();
    });
});
