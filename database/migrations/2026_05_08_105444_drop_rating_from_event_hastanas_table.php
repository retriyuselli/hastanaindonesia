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
            $table->dropColumn('rating');
        });
    }

    public function down(): void
    {
        Schema::table('event_hastanas', function (Blueprint $table) {
            $table->decimal('rating', 3, 1)->default(0)->after('total_reviews');
        });
    }
};
