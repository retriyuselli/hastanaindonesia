<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('wedding_organizers', 'legal_entity_type')) {
            return;
        }

        Schema::table('wedding_organizers', function (Blueprint $table) {
            $table->dropColumn('legal_entity_type');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('wedding_organizers', 'legal_entity_type')) {
            return;
        }

        Schema::table('wedding_organizers', function (Blueprint $table) {
            $table->string('legal_entity_type')->nullable()->after('verified_by');
        });
    }
};
