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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image'); // Path to main image
            $table->string('category'); // Resepsi, Akad Nikah, Outdoor Wedding, etc.
            $table->date('date')->nullable(); // Event date
            $table->string('location')->nullable(); // Event location
            $table->string('photographer')->nullable(); // Photographer name
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade'); // Wedding organizer company
            $table->integer('views_count')->default(0); // Number of views
            $table->boolean('is_featured')->default(false); // Featured gallery
            $table->boolean('is_published')->default(true); // Published status
            $table->string('slug')->unique(); // SEO friendly URL
            $table->json('tags')->nullable(); // Tags for search
            $table->timestamps();
            $table->softDeletes(); // Soft delete support
            
            // Indexes for better performance
            $table->index('category');
            $table->index('is_published');
            $table->index('is_featured');
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
