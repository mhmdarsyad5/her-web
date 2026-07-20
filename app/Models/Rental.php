<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rental extends Model
{
    use \App\Traits\LogsModelActivity;
    use HasFactory;

    protected $fillable = [
        'rental_code',
        'equipment_id',
        'customer_id',
        'operator_id',
        'rental_start',
        'rental_end',
        'actual_return',
        'duration_days',
        'rate_amount',
        'total_cost',
        'deposit',
        'status',
        'notes',
        'return_notes',
        'return_condition',
    ];

    protected $casts = [
        'rental_start' => 'date',
        'rental_end' => 'date',
        'actual_return' => 'date',
        'rate_amount' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'deposit' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | BOOT — Auto-code + status sync
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        // Generate kode rental otomatis
        static::creating(function (self $rental) {
            if (empty($rental->rental_code)) {
                $rental->rental_code = self::generateCode();
            }
        });

        // Saat rental diaktifkan → ubah status alat jadi 'rented'
        static::updated(function (self $rental) {
            if ($rental->wasChanged('status')) {
                $equipment = $rental->equipment;

                match ($rental->status) {
                    'active' => $equipment->update(['status' => 'rented']),
                    'returned' => $equipment->update([
                        'status' => $rental->return_condition === 'damaged'
                            ? 'maintenance'
                            : 'available',
                    ]),
                    'cancelled' => $rental->getOriginal('status') === 'active'
                        ? $equipment->update(['status' => 'available'])
                        : null,
                    default => null,
                };
            }
        });

        // Pastikan duration_days dan total_cost selalu ter-update
        static::saving(function (self $rental) {
            if ($rental->rental_start && $rental->rental_end) {
                $days = (int) $rental->rental_start->diffInDays($rental->rental_end) + 1;
                $rental->duration_days = $days;

                $months = (int) ceil($days / 30);
                $rental->total_cost = $months * (float) $rental->rate_amount;
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isOverdue(): bool
    {
        return in_array($this->status, ['active', 'pending'])
            && $this->rental_end->isPast()
            && ! $this->actual_return;
    }

    public function daysRemaining(): int
    {
        if ($this->actual_return) {
            return 0;
        }

        return max(0, now()->diffInDays($this->rental_end, false));
    }

    public function daysOverdue(): int
    {
        if (! $this->isOverdue()) {
            return 0;
        }

        return abs($this->rental_end->diffInDays(now()));
    }

    /**
     * Hitung total biaya berdasarkan bulan saja.
     */
    public function calculateTotalCost(): float
    {
        $days = (int) $this->rental_start->diffInDays($this->rental_end) + 1;
        $months = (int) ceil($days / 30);

        return $months * (float) $this->rate_amount;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'active' => 'Aktif',
            'returned' => 'Dikembalikan',
            'overdue' => 'Terlambat',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getRateTypeLabelAttribute(): string
    {
        return 'Per Bulan';
    }

    /*
    |--------------------------------------------------------------------------
    | AUTO CODE GENERATION
    |--------------------------------------------------------------------------
    */

    public static function generateCode(): string
    {
        $year = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;

        return 'RNT-'.$year.'-'.str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
