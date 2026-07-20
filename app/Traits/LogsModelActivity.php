<?php

namespace App\Traits;

use App\Support\ActivityLogger;

trait LogsModelActivity
{
    public static function bootLogsModelActivity(): void
    {
        static::created(function ($model) {
            $modelName = class_basename($model);
            $identifier = $model->title ?? $model->name ?? $model->key ?? $model->id;
            ActivityLogger::log('create', "Membuat {$modelName} baru: {$identifier}", $modelName, (string) $model->id);
        });

        static::updated(function ($model) {
            $modelName = class_basename($model);
            $identifier = $model->title ?? $model->name ?? $model->key ?? $model->id;
            ActivityLogger::log('update', "Mengubah {$modelName}: {$identifier}", $modelName, (string) $model->id);
        });

        static::deleted(function ($model) {
            $modelName = class_basename($model);
            $identifier = $model->title ?? $model->name ?? $model->key ?? $model->id;
            ActivityLogger::log('delete', "Menghapus {$modelName}: {$identifier}", $modelName, (string) $model->id);
        });
    }
}
