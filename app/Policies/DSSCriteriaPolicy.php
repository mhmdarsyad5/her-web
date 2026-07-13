<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\DSSCriteria;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class DSSCriteriaPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DSSCriteria');
    }

    public function view(AuthUser $authUser, DSSCriteria $dSSCriteria): bool
    {
        return $authUser->can('View:DSSCriteria');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DSSCriteria');
    }

    public function update(AuthUser $authUser, DSSCriteria $dSSCriteria): bool
    {
        return $authUser->can('Update:DSSCriteria');
    }

    public function delete(AuthUser $authUser, DSSCriteria $dSSCriteria): bool
    {
        return $authUser->can('Delete:DSSCriteria');
    }

    public function restore(AuthUser $authUser, DSSCriteria $dSSCriteria): bool
    {
        return $authUser->can('Restore:DSSCriteria');
    }

    public function forceDelete(AuthUser $authUser, DSSCriteria $dSSCriteria): bool
    {
        return $authUser->can('ForceDelete:DSSCriteria');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DSSCriteria');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DSSCriteria');
    }

    public function replicate(AuthUser $authUser, DSSCriteria $dSSCriteria): bool
    {
        return $authUser->can('Replicate:DSSCriteria');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DSSCriteria');
    }
}
