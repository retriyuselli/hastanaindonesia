<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('ALTER TABLE wedding_organizers MODIFY COLUMN price_range_min DECIMAL(18,2) NULL');
        DB::statement('ALTER TABLE wedding_organizers MODIFY COLUMN price_range_max DECIMAL(18,2) NULL');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('ALTER TABLE wedding_organizers MODIFY COLUMN price_range_min DECIMAL(12,2) NULL');
        DB::statement('ALTER TABLE wedding_organizers MODIFY COLUMN price_range_max DECIMAL(12,2) NULL');
    }
};
