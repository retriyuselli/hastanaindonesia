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
            $table->string('online_link', 500)
                  ->nullable()
                  ->after('location_type')
                  ->comment('Link meeting online (Zoom, Google Meet, dll)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_hastanas', function (Blueprint $table) {
            $table->dropColumn('online_link');
        });
    }
};
