<?php

namespace App\Console\Commands;

use App\Services\EquipmentImporter;
use Illuminate\Console\Command;

class ImportEquipmentFromHTML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:equipment-from-html {filePath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import equipment from HTML file containing JavaScript DB array (DSS form data)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('filePath');

        // Resolve to absolute path if relative
        if (!str_starts_with($filePath, '/')) {
            $filePath = base_path($filePath);
        }

        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        try {
            $this->info("Starting equipment import from: {$filePath}");
            $this->info('');

            $importer = new EquipmentImporter();
            $report = $importer->importFromHTML($filePath);

            // Display results
            $this->table(
                ['Metric', 'Count'],
                [
                    ['Created', $report['created']],
                    ['Updated', $report['updated']],
                    ['Skipped', $report['skipped']],
                    ['Total Processed', $report['total']],
                ]
            );

            if (!empty($report['errors'])) {
                $this->warn('');
                $this->warn('Errors encountered:');
                foreach ($report['errors'] as $error) {
                    $this->line('  ⚠ ' . $error);
                }
            }

            $this->info('');
            $this->info('✓ Equipment import completed successfully!');

            return 0;
        } catch (\Exception $e) {
            $this->error('Import failed: ' . $e->getMessage());
            return 1;
        }
    }
}
