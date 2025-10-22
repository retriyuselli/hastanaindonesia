<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('event_hastanas', function (Blueprint $table) {
            $table->enum('location_type', ['offline', 'online', 'hybrid'])
                  ->default('offline')
                  ->after('event_type')
                  ->comment('Tipe lokasi: offline (fisik), online (virtual), atau hybrid (keduanya)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_hastanas', function (Blueprint $table) {
            $table->dropColumn('location_type');
        });
    }
};
