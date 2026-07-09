<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PageTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class PageTagPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PageTag');
    }

    public function view(AuthUser $authUser, PageTag $pageTag): bool
    {
        return $authUser->can('View:PageTag');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PageTag');
    }

    public function update(AuthUser $authUser, PageTag $pageTag): bool
    {
        return $authUser->can('Update:PageTag');
    }

    public function delete(AuthUser $authUser, PageTag $pageTag): bool
    {
        return $authUser->can('Delete:PageTag');
    }

    public function restore(AuthUser $authUser, PageTag $pageTag): bool
    {
        return $authUser->can('Restore:PageTag');
    }

    public function forceDelete(AuthUser $authUser, PageTag $pageTag): bool
    {
        return $authUser->can('ForceDelete:PageTag');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PageTag');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PageTag');
    }

    public function replicate(AuthUser $authUser, PageTag $pageTag): bool
    {
        return $authUser->can('Replicate:PageTag');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PageTag');
    }

}