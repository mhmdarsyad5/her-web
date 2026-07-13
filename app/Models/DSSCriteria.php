<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DSSCriteria extends Model
{
    protected $table = 'dss_criteria';

    protected $fillable = [
        'field_type',
        'code',
        'name',
        'equipment_map',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'equipment_map' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get criteria by field type
     */
    public static function getByFieldType(string $fieldType)
    {
        return static::where('field_type', $fieldType)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get all active criteria grouped by field type
     */
    public static function getForForm()
    {
        return static::where('is_active', true)
            ->orderBy('field_type')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('field_type');
    }

    /**
     * Get active criteria
     */
    public static function getActive()
    {
        return static::where('is_active', true)
            ->orderBy('field_type')
            ->orderBy('sort_order')
            ->get();
    }
}
