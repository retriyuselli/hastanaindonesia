<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('region_name');
            $table->string('province');
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('description')->nullable();
            
            // Struktur Kepengurusan DPW (Dewan Pimpinan Wilayah)
            $table->foreignId('ketua_dpw')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('wk_ketua_dpw')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('sekretaris_dpw')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('bendahara_dpw')
                ->constrained('users')
                ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('regions');
    }
};
