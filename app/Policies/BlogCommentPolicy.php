<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\BlogComment;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class BlogCommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:BlogComment');
    }

    public function view(AuthUser $authUser, BlogComment $blogComment): bool
    {
        return $authUser->can('View:BlogComment');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:BlogComment');
    }

    public function update(AuthUser $authUser, BlogComment $blogComment): bool
    {
        return $authUser->can('Update:BlogComment');
    }

    public function delete(AuthUser $authUser, BlogComment $blogComment): bool
    {
        return $authUser->can('Delete:BlogComment');
    }

    public function restore(AuthUser $authUser, BlogComment $blogComment): bool
    {
        return $authUser->can('Restore:BlogComment');
    }

    public function forceDelete(AuthUser $authUser, BlogComment $blogComment): bool
    {
        return $authUser->can('ForceDelete:BlogComment');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:BlogComment');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:BlogComment');
    }

    public function replicate(AuthUser $authUser, BlogComment $blogComment): bool
    {
        return $authUser->can('Replicate:BlogComment');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:BlogComment');
    }
}
