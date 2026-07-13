<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('settings')->insertOrIgnore([
            [
                'key' => 'custom_header_scripts',
                'value' => json_encode(['id' => '']),
                'type' => 'text',
                'category' => 'system',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'custom_footer_scripts',
                'value' => json_encode(['id' => '']),
                'type' => 'text',
                'category' => 'system',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['custom_header_scripts', 'custom_footer_scripts'])->delete();
    }
};
