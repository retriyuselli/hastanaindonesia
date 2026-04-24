<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\AboutPage;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class AboutPagePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AboutPage');
    }

    public function view(AuthUser $authUser, AboutPage $aboutPage): bool
    {
        return $authUser->can('View:AboutPage');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AboutPage');
    }

    public function update(AuthUser $authUser, AboutPage $aboutPage): bool
    {
        return $authUser->can('Update:AboutPage');
    }

    public function delete(AuthUser $authUser, AboutPage $aboutPage): bool
    {
        return $authUser->can('Delete:AboutPage');
    }

    public function restore(AuthUser $authUser, AboutPage $aboutPage): bool
    {
        return $authUser->can('Restore:AboutPage');
    }

    public function forceDelete(AuthUser $authUser, AboutPage $aboutPage): bool
    {
        return $authUser->can('ForceDelete:AboutPage');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AboutPage');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AboutPage');
    }

    public function replicate(AuthUser $authUser, AboutPage $aboutPage): bool
    {
        return $authUser->can('Replicate:AboutPage');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AboutPage');
    }
}
