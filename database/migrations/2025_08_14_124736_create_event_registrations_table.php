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
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade'); // Penyelenggara
            $table->foreignId('event_hastana_id')->constrained('event_hastanas')->onDelete('cascade'); // Kegiatan yang didaftarkan
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Peserta
            $table->string('event_name'); // Nama kegiatan

            // Data Sertifikat
            $table->boolean('is_attended')->default(false); // Apakah peserta hadir
            $table->boolean('is_certificate_provided')->default(false); // Apakah peserta mendapat sertifikat
            $table->string('certificate_title')->nullable(); // Judul/nama sertifikat
            $table->string('certificate_file')->nullable(); // Path file template sertifikat
            $table->string('certificate_issuer')->nullable(); // Penerbit sertifikat
            $table->text('certificate_notes')->nullable(); // Catatan khusus sertifikat

            // Pengaturan Sertifikat Peserta
            $table->string('certificate_number_format')->nullable(); // Format penomoran sertifikat
            $table->date('certificate_issue_date')->nullable(); // Tanggal sertifikat diterbitkan
            $table->string('certificate_signature')->nullable(); // Nama penandatangan sertifikat
            $table->string('certificate_sign_position')->nullable(); // Jabatan penandatangan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
