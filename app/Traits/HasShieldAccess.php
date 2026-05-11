<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasShieldAccess
{
    protected static function resolvePermission(string $action): string
    {
        $modelClass = static::getModel();
        $modelName = class_basename($modelClass); // Contoh: User

        // Format permission: ViewAny:User
        return ucfirst($action) . ':' . $modelName;
    }

    public static function canViewAny(): bool
    {
        return auth()->check() &&
            auth()->user()->can(static::resolvePermission('ViewAny'));
    }

    public static function canCreate(): bool
    {
        return auth()->check() &&
            auth()->user()->can(static::resolvePermission('Create'));
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->check() &&
            auth()->user()->can(static::resolvePermission('Update'));
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->check() &&
            auth()->user()->can(static::resolvePermission('Delete'));
    }

    public static function canView(Model $record): bool
    {
        return auth()->check() &&
            auth()->user()->can(static::resolvePermission('View'));
    }
}
