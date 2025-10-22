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
        // Remove old author_name and author_avatar columns
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['author_name', 'author_avatar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('author_name')->nullable()->after('blog_category_id');
            $table->string('author_avatar')->nullable()->after('author_name');
        });
    }
};
