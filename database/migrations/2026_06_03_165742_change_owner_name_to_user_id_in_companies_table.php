<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('owner_name');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->foreignId('owner_name')
                ->nullable()
                ->after('company_name')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['owner_name']);
            $table->dropColumn('owner_name');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->string('owner_name')->nullable()->after('company_name');
        });
    }
};
