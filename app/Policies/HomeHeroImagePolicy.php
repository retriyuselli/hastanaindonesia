<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\HomeHeroImage;
use Illuminate\Auth\Access\HandlesAuthorization;

class HomeHeroImagePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:HomeHeroImage');
    }

    public function view(AuthUser $authUser, HomeHeroImage $homeHeroImage): bool
    {
        return $authUser->can('View:HomeHeroImage');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:HomeHeroImage');
    }

    public function update(AuthUser $authUser, HomeHeroImage $homeHeroImage): bool
    {
        return $authUser->can('Update:HomeHeroImage');
    }

    public function delete(AuthUser $authUser, HomeHeroImage $homeHeroImage): bool
    {
        return $authUser->can('Delete:HomeHeroImage');
    }

    public function restore(AuthUser $authUser, HomeHeroImage $homeHeroImage): bool
    {
        return $authUser->can('Restore:HomeHeroImage');
    }

    public function forceDelete(AuthUser $authUser, HomeHeroImage $homeHeroImage): bool
    {
        return $authUser->can('ForceDelete:HomeHeroImage');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:HomeHeroImage');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:HomeHeroImage');
    }

    public function replicate(AuthUser $authUser, HomeHeroImage $homeHeroImage): bool
    {
        return $authUser->can('Replicate:HomeHeroImage');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:HomeHeroImage');
    }

}