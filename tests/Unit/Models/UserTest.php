<?php

use App\Models\Post;
use App\Models\User;

test('user can be created with valid data', function () {
    $user = User::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->name)->toBe('John Doe')
        ->and($user->email)->toBe('john@example.com');
});

test('user password is hashed', function () {
    $user = User::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    expect($user->password)->not->toBe('password123')
        ->and(password_verify('password123', $user->password))->toBeTrue();
});

test('user has many posts', function () {
    $user = User::factory()->create();
    Post::factory()->count(3)->create(['user_id' => $user->id]);

    expect($user->posts)->toHaveCount(3)
        ->and($user->posts->first())->toBeInstanceOf(Post::class);
});

test('user fillable attributes are correct', function () {
    $user = new User;

    expect($user->getFillable())->toContain(
        'name',
        'email',
        'password',
        'github_id',
        'avatar_url'
    );
});

test('user hidden attributes include password and remember token', function () {
    $user = new User;

    expect($user->getHidden())->toContain('password', 'remember_token');
});

test('user email verified at is cast to datetime', function () {
    $user = User::factory()->create(['email_verified_at' => '2024-01-01 12:00:00']);

    expect($user->email_verified_at)->toBeInstanceOf(DateTime::class);
});

test('user requires name', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    User::create([
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);
});

test('user requires email', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    User::create([
        'name' => 'John Doe',
        'password' => 'password123',
    ]);
});

test('user requires unique email', function () {
    User::factory()->create(['email' => 'john@example.com']);

    $this->expectException(\Illuminate\Database\QueryException::class);

    User::create([
        'name' => 'Jane Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);
});

test('user can have github id and avatar url for social login', function () {
    $user = User::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'github_id' => '12345',
        'avatar_url' => 'https://github.com/avatar.jpg',
    ]);

    expect($user->github_id)->toBe('12345')
        ->and($user->avatar_url)->toBe('https://github.com/avatar.jpg');
});

test('user can be updated', function () {
    $user = User::factory()->create(['name' => 'Old Name']);

    $user->update(['name' => 'New Name']);

    expect($user->fresh()->name)->toBe('New Name');
});
