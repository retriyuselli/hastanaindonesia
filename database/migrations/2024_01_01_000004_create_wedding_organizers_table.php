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
        Schema::create('wedding_organizers', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key ke Member
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade');

            // Informasi Dasar Wedding Organizer
            $table->string('organizer_name'); // Nama Wedding Organizer
            $table->string('brand_name')->nullable(); // Nama Brand/Usaha
            $table->text('description')->nullable(); // Deskripsi layanan
            
            // Kontak & Lokasi
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->enum('certification_level', ['basic', 'intermediate', 'advanced', 'expert'])->nullable();
            
            // Informasi Bisnis
            $table->year('established_year')->nullable(); // Tahun berdiri
            $table->enum('business_type', ['individual', 'partnership', 'company'])->default('individual');
            $table->string('business_license')->nullable(); // Nomor izin usaha
            
            // Spesialisasi & Layanan
            $table->json('specializations')->nullable(); // ['traditional', 'modern', 'outdoor', 'indoor', 'destination']
            $table->json('services')->nullable(); // ['planning', 'decoration', 'catering', 'photography', 'entertainment']
            $table->decimal('price_range_min', 12, 2)->nullable(); // Budget minimum
            $table->decimal('price_range_max', 12, 2)->nullable(); // Budget maksimum
            
            // Portfolio & Rating
            $table->integer('completed_events')->default(0); // Jumlah event yang sudah ditangani
            $table->decimal('rating', 2, 1)->nullable(); // Rating 1-5
            $table->text('awards')->nullable(); // Penghargaan yang pernah diterima
            
            // Status & Verifikasi
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->boolean('is_featured')->default(false); // Featured organizer
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            
            // Metadata
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Data Legalitas Anggota
            $table->string('legal_entity_type')->nullable(); // Jenis badan hukum, misal: PT, CV, Firma, Koperasi, dll
            $table->string('deed_of_establishment')->nullable(); // Nomor akta pendirian perusahaan/organisasi
            $table->date('deed_date')->nullable(); // Tanggal akta pendirian
            $table->string('notary_name')->nullable(); // Nama notaris yang membuat akta
            $table->string('notary_license_number')->nullable(); // Nomor SK pengangkatan notaris

            // NIB (Nomor Induk Berusaha)
            $table->string('nib_number')->unique()->nullable(); // Nomor Induk Berusaha (OSS)
            $table->date('nib_issued_date')->nullable(); // Tanggal terbit NIB
            $table->date('nib_valid_until')->nullable(); // Masa berlaku NIB

            // NPWP (Nomor Pokok Wajib Pajak)
            $table->string('npwp_number')->unique()->nullable(); // Nomor NPWP
            $table->date('npwp_issued_date')->nullable(); // Tanggal terbit NPWP
            $table->string('tax_office')->nullable(); // Kantor pajak terdaftar

            // Status Verifikasi Dokumen Legalitas
            $table->enum('legal_document_status', ['incomplete', 'pending_review', 'verified', 'rejected'])->default('incomplete'); // Status verifikasi dokumen legalitas
            $table->text('legal_document_notes')->nullable(); // Catatan/verifikasi tambahan
            $table->timestamp('legal_verified_at')->nullable(); // Tanggal diverifikasi
            $table->foreignId('legal_verified_by')->nullable()->constrained('users')->onDelete('set null'); // User yang melakukan verifikasi

            // File Dokumen Legalitas (path file)
            $table->json('legal_documents')->nullable(); // Path file dokumen legalitas (format JSON)
            
            // Indexes
            $table->index(['status', 'verification_status']);
            $table->index(['city', 'province']);
            $table->index(['is_featured', 'rating']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wedding_organizers');
    }
};
