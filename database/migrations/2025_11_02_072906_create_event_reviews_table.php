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
        Schema::create('event_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_hastana_id')->constrained('event_hastanas')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('event_participant_id')->nullable()->constrained('event_participants')->onDelete('set null');
            
            // Rating & Review
            $table->unsignedTinyInteger('rating')->comment('Rating 1-5');
            $table->string('title', 255)->nullable()->comment('Review title');
            $table->text('review')->comment('Review content');
            $table->text('pros')->nullable()->comment('Positive points');
            $table->text('cons')->nullable()->comment('Negative points');
            
            // Flags
            $table->boolean('would_recommend')->default(true)->comment('Would recommend this event');
            $table->boolean('is_verified_participant')->default(false)->comment('Review from verified participant');
            $table->boolean('is_approved')->default(false)->comment('Approved by moderator');
            $table->boolean('is_featured')->default(false)->comment('Featured review');
            
            // Engagement
            $table->unsignedInteger('helpful_count')->default(0)->comment('Number of helpful votes');
            $table->unsignedInteger('reported_count')->default(0)->comment('Number of reports');
            
            // Moderation
            $table->text('moderator_notes')->nullable()->comment('Notes from moderator');
            $table->string('ip_address', 45)->nullable()->comment('Reviewer IP address');
            
            $table->timestamps();
            
            // Indexes
            $table->index(['event_hastana_id', 'is_approved']);
            $table->index(['user_id']);
            $table->index(['rating']);
            $table->index(['is_featured']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_reviews');
    }
};
