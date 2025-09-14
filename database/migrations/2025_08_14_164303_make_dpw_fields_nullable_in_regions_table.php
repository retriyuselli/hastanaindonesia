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
            $table->dropForeign(['ketua_dpw']);
            $table->dropForeign(['wk_ketua_dpw']);
            $table->dropForeign(['sekretaris_dpw']);
            $table->dropForeign(['bendahara_dpw']);
            
            $table->foreignId('ketua_dpw')->nullable()->change();
            $table->foreignId('wk_ketua_dpw')->nullable()->change();
            $table->foreignId('sekretaris_dpw')->nullable()->change();
            $table->foreignId('bendahara_dpw')->nullable()->change();
            
            $table->foreign('ketua_dpw')->references('id')->on('users')->onDelete('set null');
            $table->foreign('wk_ketua_dpw')->references('id')->on('users')->onDelete('set null');
            $table->foreign('sekretaris_dpw')->references('id')->on('users')->onDelete('set null');
            $table->foreign('bendahara_dpw')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropForeign(['ketua_dpw']);
            $table->dropForeign(['wk_ketua_dpw']);
            $table->dropForeign(['sekretaris_dpw']);
            $table->dropForeign(['bendahara_dpw']);
            
            $table->foreignId('ketua_dpw')->nullable(false)->change();
            $table->foreignId('wk_ketua_dpw')->nullable(false)->change();
            $table->foreignId('sekretaris_dpw')->nullable(false)->change();
            $table->foreignId('bendahara_dpw')->nullable(false)->change();
            
            $table->foreign('ketua_dpw')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('wk_ketua_dpw')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sekretaris_dpw')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bendahara_dpw')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
