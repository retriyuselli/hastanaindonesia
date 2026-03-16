<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\EventReview;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class EventReviewPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:EventReview');
    }

    public function view(AuthUser $authUser, EventReview $eventReview): bool
    {
        return $authUser->can('View:EventReview');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:EventReview');
    }

    public function update(AuthUser $authUser, EventReview $eventReview): bool
    {
        return $authUser->can('Update:EventReview');
    }

    public function delete(AuthUser $authUser, EventReview $eventReview): bool
    {
        return $authUser->can('Delete:EventReview');
    }

    public function restore(AuthUser $authUser, EventReview $eventReview): bool
    {
        return $authUser->can('Restore:EventReview');
    }

    public function forceDelete(AuthUser $authUser, EventReview $eventReview): bool
    {
        return $authUser->can('ForceDelete:EventReview');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:EventReview');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:EventReview');
    }

    public function replicate(AuthUser $authUser, EventReview $eventReview): bool
    {
        return $authUser->can('Replicate:EventReview');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:EventReview');
    }
}
