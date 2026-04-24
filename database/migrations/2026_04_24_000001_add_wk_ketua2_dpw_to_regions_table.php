<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table
                ->foreignId('wk_ketua2_dpw')
                ->nullable()
                ->after('wk_ketua_dpw')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropForeign(['wk_ketua2_dpw']);
            $table->dropColumn('wk_ketua2_dpw');
        });
    }
};
