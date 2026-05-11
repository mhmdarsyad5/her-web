<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\Equipment;
use App\Models\Faq;
use App\Models\HeroSection;
use App\Models\Page;
use App\Models\Rental;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $overdueCount = Rental::where('status', 'overdue')->count();

        return [
            // ── ALAT ─────────────────────────────────────────────
            Stat::make('Alat Tersedia', Equipment::where('status', 'available')->count())
                ->description('Siap disewakan')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Sedang Disewa', Equipment::where('status', 'rented')->count())
                ->description('Dalam penggunaan pelanggan')
                ->icon('heroicon-o-truck')
                ->color('primary'),

            Stat::make('Dalam Maintenance', Equipment::where('status', 'maintenance')->count())
                ->description('Sedang diperbaiki / diservis')
                ->icon('heroicon-o-wrench')
                ->color('warning'),

            // ── RENTAL ───────────────────────────────────────────
            Stat::make('Rental Aktif', Rental::where('status', 'active')->count())
                ->description('Transaksi berjalan')
                ->icon('heroicon-o-clipboard-document-list')
                ->color('info'),

            Stat::make('Rental Terlambat', $overdueCount)
                ->description($overdueCount > 0 ? '⚠️ Perlu tindakan segera' : 'Semua tepat waktu')
                ->icon('heroicon-o-exclamation-triangle')
                ->color($overdueCount > 0 ? 'danger' : 'success'),

            Stat::make('Rental Selesai Bulan Ini',
                Rental::where('status', 'returned')
                    ->whereMonth('actual_return', now()->month)
                    ->whereYear('actual_return', now()->year)
                    ->count()
            )
                ->description('Pengembalian ' . now()->translatedFormat('F Y'))
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('gray'),

            // ── WEBSITE ───────────────────────────────────────────
            Stat::make('Total Blogs', Page::count())
                ->description('Jumlah artikel blog')
                ->icon('heroicon-o-document-text'),

            Stat::make('Total Users', User::count())
                ->description('Jumlah pengguna terdaftar')
                ->icon('heroicon-o-users'),

            Stat::make('Total Messages', ContactMessage::count())
                ->description('Jumlah pesan masuk')
                ->icon('heroicon-o-envelope'),
        ];
    }
}
