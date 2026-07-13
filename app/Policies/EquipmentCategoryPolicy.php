<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\EquipmentCategory;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class EquipmentCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:EquipmentCategory');
    }

    public function view(AuthUser $authUser, EquipmentCategory $equipmentCategory): bool
    {
        return $authUser->can('View:EquipmentCategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:EquipmentCategory');
    }

    public function update(AuthUser $authUser, EquipmentCategory $equipmentCategory): bool
    {
        return $authUser->can('Update:EquipmentCategory');
    }

    public function delete(AuthUser $authUser, EquipmentCategory $equipmentCategory): bool
    {
        return $authUser->can('Delete:EquipmentCategory');
    }

    public function restore(AuthUser $authUser, EquipmentCategory $equipmentCategory): bool
    {
        return $authUser->can('Restore:EquipmentCategory');
    }

    public function forceDelete(AuthUser $authUser, EquipmentCategory $equipmentCategory): bool
    {
        return $authUser->can('ForceDelete:EquipmentCategory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:EquipmentCategory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:EquipmentCategory');
    }

    public function replicate(AuthUser $authUser, EquipmentCategory $equipmentCategory): bool
    {
        return $authUser->can('Replicate:EquipmentCategory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:EquipmentCategory');
    }
}
