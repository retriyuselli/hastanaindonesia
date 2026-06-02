<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Iuran;
use Illuminate\Auth\Access\HandlesAuthorization;

class IuranPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Iuran');
    }

    public function view(AuthUser $authUser, Iuran $iuran): bool
    {
        return $authUser->can('View:Iuran');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Iuran');
    }

    public function update(AuthUser $authUser, Iuran $iuran): bool
    {
        return $authUser->can('Update:Iuran');
    }

    public function delete(AuthUser $authUser, Iuran $iuran): bool
    {
        return $authUser->can('Delete:Iuran');
    }

    public function restore(AuthUser $authUser, Iuran $iuran): bool
    {
        return $authUser->can('Restore:Iuran');
    }

    public function forceDelete(AuthUser $authUser, Iuran $iuran): bool
    {
        return $authUser->can('ForceDelete:Iuran');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Iuran');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Iuran');
    }

    public function replicate(AuthUser $authUser, Iuran $iuran): bool
    {
        return $authUser->can('Replicate:Iuran');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Iuran');
    }

}