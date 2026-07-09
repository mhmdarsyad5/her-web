<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DSSRule;
use Illuminate\Auth\Access\HandlesAuthorization;

class DSSRulePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DSSRule');
    }

    public function view(AuthUser $authUser, DSSRule $dSSRule): bool
    {
        return $authUser->can('View:DSSRule');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DSSRule');
    }

    public function update(AuthUser $authUser, DSSRule $dSSRule): bool
    {
        return $authUser->can('Update:DSSRule');
    }

    public function delete(AuthUser $authUser, DSSRule $dSSRule): bool
    {
        return $authUser->can('Delete:DSSRule');
    }

    public function restore(AuthUser $authUser, DSSRule $dSSRule): bool
    {
        return $authUser->can('Restore:DSSRule');
    }

    public function forceDelete(AuthUser $authUser, DSSRule $dSSRule): bool
    {
        return $authUser->can('ForceDelete:DSSRule');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DSSRule');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DSSRule');
    }

    public function replicate(AuthUser $authUser, DSSRule $dSSRule): bool
    {
        return $authUser->can('Replicate:DSSRule');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DSSRule');
    }

}