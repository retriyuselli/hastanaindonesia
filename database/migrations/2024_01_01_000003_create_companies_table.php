<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('business_license')->unique();
            $table->string('owner_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->string('logo_url')->nullable();
            $table->year('established_year')->nullable();
            $table->integer('employee_count')->nullable();
            
            // Data Legalitas
            $table->string('legal_entity_type')->nullable(); // PT, CV, Firma, UD, Koperasi, dll
            $table->string('deed_of_establishment')->nullable(); // Nomor akta pendirian
            $table->date('deed_date')->nullable(); // Tanggal akta pendirian
            $table->string('notary_name')->nullable(); // Nama notaris
            $table->string('notary_license_number')->nullable(); // Nomor SK notaris
            
            // NIB (Nomor Induk Berusaha) - OSS
            $table->string('nib_number')->unique()->nullable(); // Nomor Induk Berusaha
            $table->date('nib_issued_date')->nullable(); // Tanggal terbit NIB
            $table->date('nib_valid_until')->nullable(); // Berlaku sampai
            
            // NPWP
            $table->string('npwp_number')->unique()->nullable(); // Nomor NPWP
            $table->date('npwp_issued_date')->nullable(); // Tanggal terbit NPWP
            $table->string('tax_office')->nullable(); // KPP terdaftar
            
            // Status Verifikasi Dokumen
            $table->enum('legal_document_status', ['incomplete', 'pending_review', 'verified', 'rejected'])->default('incomplete');
            $table->text('legal_document_notes')->nullable(); // Catatan verifikasi
            $table->timestamp('legal_verified_at')->nullable(); // Tanggal verifikasi
            $table->foreignId('legal_verified_by')->nullable()->constrained('users')->onDelete('set null'); // User yang verifikasi
            
            // File Upload Paths
            $table->json('legal_documents')->nullable(); // Path file dokumen legalitas
            
            $table->timestamps();
            
            // Indexes untuk performa
            $table->index(['legal_document_status']);
            $table->index(['nib_number']);
            $table->index(['npwp_number']);
            $table->index(['legal_entity_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
