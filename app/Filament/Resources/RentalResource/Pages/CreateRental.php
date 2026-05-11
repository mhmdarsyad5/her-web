<?php

namespace App\Filament\Resources\RentalResource\Pages;

use App\Filament\Resources\RentalResource;
use App\Models\Rental;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateRental extends CreateRecord
{
    protected static string $resource = RentalResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-generate kode rental
        $data['rental_code'] = Rental::generateCode();

        // Simpan user yang membuat
        $data['operator_id'] = Auth::id();

        // Hitung durasi hari jika belum dihitung
        if (isset($data['rental_start'], $data['rental_end']) && empty($data['duration_days'])) {
            $start = Carbon::parse($data['rental_start']);
            $end   = Carbon::parse($data['rental_end']);
            $data['duration_days'] = $start->diffInDays($end) + 1;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
