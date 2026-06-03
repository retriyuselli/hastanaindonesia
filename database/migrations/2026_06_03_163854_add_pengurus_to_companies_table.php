<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('nama_sekretaris_umum')->nullable()->after('owner_name');
            $table->string('nama_bendahara_umum')->nullable()->after('nama_sekretaris_umum');
            $table->string('nama_bid_organisasi')->nullable()->after('nama_bendahara_umum');
            $table->string('nama_bid_pengembangan')->nullable()->after('nama_bid_organisasi');
            $table->string('nama_bid_humas_1')->nullable()->after('nama_bid_pengembangan');
            $table->string('nama_bid_humas_2')->nullable()->after('nama_bid_humas_1');
            $table->string('nama_bid_sosial')->nullable()->after('nama_bid_humas_2');
            $table->string('nama_bid_bisnis')->nullable()->after('nama_bid_sosial');
            $table->string('nama_bid_hukum')->nullable()->after('nama_bid_bisnis');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'nama_sekretaris_umum',
                'nama_bendahara_umum',
                'nama_bid_organisasi',
                'nama_bid_pengembangan',
                'nama_bid_humas_1',
                'nama_bid_humas_2',
                'nama_bid_sosial',
                'nama_bid_bisnis',
                'nama_bid_hukum',
            ]);
        });
    }
};
