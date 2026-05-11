<?php

namespace App\Console\Commands;

use App\Models\Rental;
use Illuminate\Console\Command;

class MarkOverdueRentals extends Command
{
    protected $signature   = 'rentals:mark-overdue';
    protected $description = 'Tandai penyewaan yang melewati tanggal estimasi kembali sebagai Terlambat (overdue)';

    public function handle(): int
    {
        $count = Rental::query()
            ->whereIn('status', ['active', 'pending'])
            ->whereDate('rental_end', '<', now()->toDateString())
            ->whereNull('actual_return')
            ->update(['status' => 'overdue']);

        $this->info("✅ {$count} rental ditandai overdue.");

        return self::SUCCESS;
    }
}
