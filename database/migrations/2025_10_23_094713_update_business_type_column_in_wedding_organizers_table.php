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
        // Change business_type from enum to varchar for flexibility
        DB::statement('ALTER TABLE wedding_organizers MODIFY COLUMN business_type VARCHAR(100) NOT NULL DEFAULT "Perorangan"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to enum
        DB::statement('ALTER TABLE wedding_organizers MODIFY COLUMN business_type ENUM("individual","partnership","company") NOT NULL DEFAULT "individual"');
    }
};
