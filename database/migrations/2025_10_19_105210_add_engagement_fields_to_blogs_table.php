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
        Schema::table('blogs', function (Blueprint $table) {
            $table->integer('likes_count')->default(0)->after('views_count');
            $table->integer('comments_count')->default(0)->after('likes_count');
            $table->string('status')->default('draft')->after('is_published'); // draft, published, scheduled
            $table->json('seo_keywords')->nullable()->after('meta_description');
            $table->text('summary')->nullable()->after('excerpt'); // Auto-generated summary
            $table->decimal('engagement_score', 5, 2)->default(0)->after('comments_count'); // Calculated engagement
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn([
                'likes_count',
                'comments_count', 
                'status',
                'seo_keywords',
                'summary',
                'engagement_score'
            ]);
        });
    }
};
