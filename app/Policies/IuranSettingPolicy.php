<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\IuranSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class IuranSettingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:IuranSetting');
    }

    public function view(AuthUser $authUser, IuranSetting $iuranSetting): bool
    {
        return $authUser->can('View:IuranSetting');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:IuranSetting');
    }

    public function update(AuthUser $authUser, IuranSetting $iuranSetting): bool
    {
        return $authUser->can('Update:IuranSetting');
    }

    public function delete(AuthUser $authUser, IuranSetting $iuranSetting): bool
    {
        return $authUser->can('Delete:IuranSetting');
    }

    public function restore(AuthUser $authUser, IuranSetting $iuranSetting): bool
    {
        return $authUser->can('Restore:IuranSetting');
    }

    public function forceDelete(AuthUser $authUser, IuranSetting $iuranSetting): bool
    {
        return $authUser->can('ForceDelete:IuranSetting');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:IuranSetting');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:IuranSetting');
    }

    public function replicate(AuthUser $authUser, IuranSetting $iuranSetting): bool
    {
        return $authUser->can('Replicate:IuranSetting');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:IuranSetting');
    }

}