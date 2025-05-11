<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view posts');
    }

    public function view(User $user, Post $post): bool
    {
        return $user->can('view posts');
    }

    public function create(User $user): bool
    {
        return $user->can('create posts');
    }

    public function update(User $user, Post $post): bool
    {
        return $user->can('edit posts') && ($user->id === $post->user_id || $user->isAdmin() || $user->isSuperAdmin());
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->can('delete posts') && ($user->id === $post->user_id || $user->isAdmin() || $user->isSuperAdmin());
    }

    public function restore(User $user, Post $post): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return $user->isSuperAdmin();
    }
}