<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_hastanas', function (Blueprint $table) {
            $table->index(['status', 'is_active', 'start_date'], 'event_hastanas_status_active_start_idx');
            $table->index(['is_featured', 'start_date'], 'event_hastanas_featured_start_idx');
            $table->index(['is_trending', 'start_date'], 'event_hastanas_trending_start_idx');
            $table->index('city', 'event_hastanas_city_idx');
            $table->index('current_participants', 'event_hastanas_current_participants_idx');
        });
    }

    public function down(): void
    {
        Schema::table('event_hastanas', function (Blueprint $table) {
            $table->dropIndex('event_hastanas_status_active_start_idx');
            $table->dropIndex('event_hastanas_featured_start_idx');
            $table->dropIndex('event_hastanas_trending_start_idx');
            $table->dropIndex('event_hastanas_city_idx');
            $table->dropIndex('event_hastanas_current_participants_idx');
        });
    }
};
