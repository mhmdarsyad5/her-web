<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'brand',
        'model',
        'year',
        'condition',
        'status',
        'description',
        'specifications',
        'images',
        'monthly_rate',
        'deposit',
        'location',
        'notes',
        'sort_order',
    ];

    protected $casts = [
        'specifications' => 'array',
        'images' => 'array',
        'monthly_rate' => 'decimal:2',
        'deposit' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function category(): BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function dssRule(): HasOne
    {
        return $this->hasOne(DSSRule::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(EquipmentMaintenance::class);
    }

    /**
     * Rental aktif saat ini (jika ada)
     */
    public function activeRental(): HasOne
    {
        return $this->hasOne(Rental::class)->whereIn('status', ['pending', 'active', 'overdue']);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeRented($query)
    {
        return $query->where('status', 'rented');
    }

    public function scopeMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'retired');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function getThumbnailAttribute(): ?string
    {
        return $this->images[0] ?? null;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available' => 'Tersedia',
            'rented' => 'Disewa',
            'maintenance' => 'Maintenance',
            'retired' => 'Tidak Aktif',
            default => $this->status,
        };
    }

    public function getConditionLabelAttribute(): string
    {
        return match ($this->condition) {
            'excellent' => 'Sangat Baik',
            'good' => 'Baik',
            'fair' => 'Cukup',
            'poor' => 'Perlu Perbaikan',
            default => $this->condition,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | AUTO CODE GENERATION
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (self $equipment) {
            if (empty($equipment->code)) {
                $equipment->code = self::generateCode();
            }
        });
    }

    public static function generateCode(): string
    {
        $last = self::orderByDesc('id')->value('code');

        if (! $last) {
            return 'ALT-001';
        }

        preg_match('/(\d+)$/', $last, $matches);
        $next = isset($matches[1]) ? (int) $matches[1] + 1 : 1;

        return 'ALT-'.str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}
