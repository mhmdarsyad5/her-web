<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'customer_type',
        'company_name',
        'phone',
        'email',
        'address',
        'id_number',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function getDisplayNameAttribute(): string
    {
        if ($this->customer_type === 'company' && $this->company_name) {
            return "{$this->company_name} ({$this->name})";
        }

        return $this->name;
    }

    public function getCustomerTypeLabelAttribute(): string
    {
        return match ($this->customer_type) {
            'individual' => 'Perorangan',
            'company' => 'Perusahaan',
            default => $this->customer_type,
        };
    }

    public function activeRentals(): HasMany
    {
        return $this->rentals()->whereIn('status', ['pending', 'active', 'overdue']);
    }

    public function hasActiveRental(): bool
    {
        return $this->activeRentals()->exists();
    }
}
