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
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->text('history')->nullable(); // Sejarah Hastana
            $table->text('vision')->nullable(); // Visi
            $table->text('mission')->nullable(); // Misi
            $table->json('values')->nullable(); // Nilai-nilai (array of {title, description})
            $table->json('programs')->nullable(); // Program dan Layanan (array of {title, description})
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
