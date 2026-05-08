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
        Schema::table('wedding_organizers', function (Blueprint $table) {
            $table->dropColumn(['price_range_min', 'price_range_max']);
        });
    }

    public function down(): void
    {
        Schema::table('wedding_organizers', function (Blueprint $table) {
            $table->decimal('price_range_min', 18, 2)->nullable()->after('rating');
            $table->decimal('price_range_max', 18, 2)->nullable()->after('price_range_min');
        });
    }
};
