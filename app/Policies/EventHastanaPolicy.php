<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\EventHastana;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventHastanaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:EventHastana');
    }

    public function view(AuthUser $authUser, EventHastana $eventHastana): bool
    {
        return $authUser->can('View:EventHastana');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:EventHastana');
    }

    public function update(AuthUser $authUser, EventHastana $eventHastana): bool
    {
        return $authUser->can('Update:EventHastana');
    }

    public function delete(AuthUser $authUser, EventHastana $eventHastana): bool
    {
        return $authUser->can('Delete:EventHastana');
    }

    public function restore(AuthUser $authUser, EventHastana $eventHastana): bool
    {
        return $authUser->can('Restore:EventHastana');
    }

    public function forceDelete(AuthUser $authUser, EventHastana $eventHastana): bool
    {
        return $authUser->can('ForceDelete:EventHastana');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:EventHastana');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:EventHastana');
    }

    public function replicate(AuthUser $authUser, EventHastana $eventHastana): bool
    {
        return $authUser->can('Replicate:EventHastana');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:EventHastana');
    }

}