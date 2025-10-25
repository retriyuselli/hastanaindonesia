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
            // Add slug column
            $table->string('slug')->unique()->after('organizer_name')->nullable();
            
            // Add is_approved and is_active columns for registration workflow
            $table->boolean('is_approved')->default(false)->after('is_featured');
            $table->boolean('is_active')->default(false)->after('is_approved');
            
            // Add subscribe_newsletter column
            $table->boolean('subscribe_newsletter')->default(false)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wedding_organizers', function (Blueprint $table) {
            $table->dropColumn(['slug', 'is_approved', 'is_active', 'subscribe_newsletter']);
        });
    }
};
