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
        Schema::table('event_participants', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('event_hastana_id')->constrained('users')->onDelete('set null');
            $table->index(['event_hastana_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_participants', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['event_hastana_id', 'user_id']);
            $table->dropColumn('user_id');
        });
    }
};
