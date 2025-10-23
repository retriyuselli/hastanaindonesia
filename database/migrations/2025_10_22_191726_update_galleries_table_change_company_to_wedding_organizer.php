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
        Schema::table('galleries', function (Blueprint $table) {
            // Drop foreign key constraint if exists
            $table->dropForeign(['company_id']);
            
            // Rename column
            $table->renameColumn('company_id', 'wedding_organizer_id');
            
            // Add new foreign key constraint
            $table->foreign('wedding_organizer_id')
                  ->references('id')
                  ->on('wedding_organizers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['wedding_organizer_id']);
            
            // Rename column back
            $table->renameColumn('wedding_organizer_id', 'company_id');
            
            // Add old foreign key constraint
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');
        });
    }
};
