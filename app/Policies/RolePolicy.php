<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view roles');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->can('view roles');
    }

    public function create(User $user): bool
    {
        return $user->can('create roles');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->can('edit roles');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->can('delete roles') && $role->name !== 'super-admin';
    }

    public function restore(User $user, Role $role): bool
    {
        return $user->isSuperAdmin();
    }

    public function forceDelete(User $user, Role $role): bool
    {
        return $user->isSuperAdmin() && $role->name !== 'super-admin';
    }
}