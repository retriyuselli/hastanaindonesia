<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\WeddingOrganizer;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class WeddingOrganizerPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:WeddingOrganizer');
    }

    public function view(AuthUser $authUser, WeddingOrganizer $weddingOrganizer): bool
    {
        return $authUser->can('View:WeddingOrganizer');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:WeddingOrganizer');
    }

    public function update(AuthUser $authUser, WeddingOrganizer $weddingOrganizer): bool
    {
        return $authUser->can('Update:WeddingOrganizer');
    }

    public function delete(AuthUser $authUser, WeddingOrganizer $weddingOrganizer): bool
    {
        return $authUser->can('Delete:WeddingOrganizer');
    }

    public function restore(AuthUser $authUser, WeddingOrganizer $weddingOrganizer): bool
    {
        return $authUser->can('Restore:WeddingOrganizer');
    }

    public function forceDelete(AuthUser $authUser, WeddingOrganizer $weddingOrganizer): bool
    {
        return $authUser->can('ForceDelete:WeddingOrganizer');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:WeddingOrganizer');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:WeddingOrganizer');
    }

    public function replicate(AuthUser $authUser, WeddingOrganizer $weddingOrganizer): bool
    {
        return $authUser->can('Replicate:WeddingOrganizer');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:WeddingOrganizer');
    }
}
