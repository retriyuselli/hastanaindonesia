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
        Schema::table('regions', function (Blueprint $table) {
            $table->string('website')->nullable()->after('contact_phone');
            $table->text('address')->nullable()->after('description');
            $table->string('postal_code', 10)->nullable()->after('address');
            $table->date('establishment_date')->nullable()->after('postal_code');
            $table->boolean('is_active')->default(true)->after('establishment_date');
            $table->string('logo')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropColumn([
                'website',
                'address', 
                'postal_code',
                'establishment_date',
                'is_active',
                'logo',
            ]);
        });
    }
};
