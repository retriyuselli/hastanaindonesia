<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Make region_id nullable because it will be assigned by admin during approval
        // user_id is no longer nullable as it's automatically filled from authenticated user
        DB::statement('ALTER TABLE wedding_organizers MODIFY COLUMN region_id BIGINT UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE wedding_organizers MODIFY COLUMN region_id BIGINT UNSIGNED NOT NULL');
    }
};
