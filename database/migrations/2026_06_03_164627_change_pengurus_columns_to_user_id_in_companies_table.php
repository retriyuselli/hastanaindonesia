<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $columns = [
        'nama_sekretaris_umum',
        'nama_bendahara_umum',
        'nama_bid_organisasi',
        'nama_bid_pengembangan',
        'nama_bid_humas_1',
        'nama_bid_humas_2',
        'nama_bid_sosial',
        'nama_bid_bisnis',
        'nama_bid_hukum',
    ];

    public function up(): void
    {
        // Drop string columns dulu, lalu buat ulang sebagai FK ke users
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn($this->columns);
        });

        Schema::table('companies', function (Blueprint $table) {
            foreach ($this->columns as $col) {
                $table->foreignId($col)
                    ->nullable()
                    ->after('owner_name')
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            foreach ($this->columns as $col) {
                $table->dropForeign([$col]);
                $table->dropColumn($col);
            }
        });

        Schema::table('companies', function (Blueprint $table) {
            foreach ($this->columns as $col) {
                $table->string($col)->nullable()->after('owner_name');
            }
        });
    }
};
