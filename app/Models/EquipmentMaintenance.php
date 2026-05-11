<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentMaintenance extends Model
{
    use HasFactory;

    protected $table = 'equipment_maintenances';

    protected $fillable = [
        'equipment_id',
        'performed_by',
        'maintenance_type',
        'title',
        'description',
        'cost',
        'start_date',
        'end_date',
        'next_maintenance_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'cost'                  => 'decimal:2',
        'start_date'            => 'date',
        'end_date'              => 'date',
        'next_maintenance_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | BOOT — Sync equipment status
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        // Saat maintenance dibuat dengan status in_progress → alat jadi 'maintenance'
        static::created(function (self $maintenance) {
            if ($maintenance->status === 'in_progress') {
                $maintenance->equipment->update(['status' => 'maintenance']);
            }
        });

        // Saat status maintenance berubah
        static::updated(function (self $maintenance) {
            if ($maintenance->wasChanged('status')) {
                if ($maintenance->status === 'in_progress') {
                    $maintenance->equipment->update(['status' => 'maintenance']);
                }

                if ($maintenance->status === 'completed') {
                    // Cek apakah masih ada maintenance lain yang aktif
                    $hasOtherActive = EquipmentMaintenance::where('equipment_id', $maintenance->equipment_id)
                        ->where('id', '!=', $maintenance->id)
                        ->whereIn('status', ['scheduled', 'in_progress'])
                        ->exists();

                    if (! $hasOtherActive) {
                        $maintenance->equipment->update(['status' => 'available']);
                    }
                }
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

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function getMaintenanceTypeLabelAttribute(): string
    {
        return match ($this->maintenance_type) {
            'routine'    => 'Rutin',
            'repair'     => 'Perbaikan',
            'inspection' => 'Inspeksi',
            default      => $this->maintenance_type,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'scheduled'   => 'Terjadwal',
            'in_progress' => 'Sedang Dikerjakan',
            'completed'   => 'Selesai',
            default       => $this->status,
        };
    }
}
