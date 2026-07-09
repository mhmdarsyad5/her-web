<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PageCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class PageCategoryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PageCategory');
    }

    public function view(AuthUser $authUser, PageCategory $pageCategory): bool
    {
        return $authUser->can('View:PageCategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PageCategory');
    }

    public function update(AuthUser $authUser, PageCategory $pageCategory): bool
    {
        return $authUser->can('Update:PageCategory');
    }

    public function delete(AuthUser $authUser, PageCategory $pageCategory): bool
    {
        return $authUser->can('Delete:PageCategory');
    }

    public function restore(AuthUser $authUser, PageCategory $pageCategory): bool
    {
        return $authUser->can('Restore:PageCategory');
    }

    public function forceDelete(AuthUser $authUser, PageCategory $pageCategory): bool
    {
        return $authUser->can('ForceDelete:PageCategory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PageCategory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PageCategory');
    }

    public function replicate(AuthUser $authUser, PageCategory $pageCategory): bool
    {
        return $authUser->can('Replicate:PageCategory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PageCategory');
    }

}