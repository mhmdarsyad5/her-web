<?php

namespace App\Support;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(
        string $action,
        string $description,
        ?string $subjectType = null,
        ?string $subjectId = null,
        array $properties = []
    ): ?ActivityLog {
        try {
            $user = Auth::user();

            return ActivityLog::create([
                'user_id' => $user?->id,
                'user_name' => $user?->name ?? 'Guest / System',
                'action' => $action,
                'subject_type' => $subjectType,
                'subject_id' => $subjectId,
                'description' => $description,
                'ip_address' => Request::ip(),
                'properties' => $properties,
            ]);
        } catch (\Throwable $e) {
            // Log silently to avoid breaking main workflow
            logger()->error('Failed to record activity log: '.$e->getMessage());

            return null;
        }
    }
}
