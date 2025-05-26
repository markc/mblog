<?php

describe('Application Configuration', function () {
    it('app name is configured', function () {
        expect(config('app.name'))->not->toBeEmpty();
    });

    it('app environment is set', function () {
        expect(config('app.env'))->not->toBeEmpty();
    });

    it('database connection is configured', function () {
        expect(config('database.default'))->not->toBeEmpty();
        expect(config('database.connections.sqlite'))->not->toBeEmpty();
    });

    it('cache configuration is set', function () {
        expect(config('cache.default'))->not->toBeEmpty();
    });

    it('session configuration is set', function () {
        expect(config('session.driver'))->not->toBeEmpty();
    });

    it('mail configuration is set', function () {
        expect(config('mail.default'))->not->toBeEmpty();
    });

    it('queue configuration is set', function () {
        expect(config('queue.default'))->not->toBeEmpty();
    });

    it('logging configuration is set', function () {
        expect(config('logging.default'))->not->toBeEmpty();
    });

    it('auth configuration has guards', function () {
        expect(config('auth.guards'))->not->toBeEmpty();
        expect(config('auth.guards.web'))->not->toBeEmpty();
    });

    it('filesystems configuration is set', function () {
        expect(config('filesystems.default'))->not->toBeEmpty();
    });
});
