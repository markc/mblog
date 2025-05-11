<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view tags');
    }

    public function view(User $user, Tag $tag): bool
    {
        return $user->can('view tags');
    }

    public function create(User $user): bool
    {
        return $user->can('create tags');
    }

    public function update(User $user, Tag $tag): bool
    {
        return $user->can('edit tags');
    }

    public function delete(User $user, Tag $tag): bool
    {
        return $user->can('delete tags');
    }

    public function restore(User $user, Tag $tag): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    public function forceDelete(User $user, Tag $tag): bool
    {
        return $user->isSuperAdmin();
    }
}