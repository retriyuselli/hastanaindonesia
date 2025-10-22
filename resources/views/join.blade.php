@extends('layouts.app')

@section('title', 'Bergabung dengan HASTANA Indonesia - Daftar Keanggotaan')
@section('description', 'Bergabung dengan Himpunan Perusahaan Penata Acara Seluruh Indonesia. Tingkatkan profesionalisme wedding organizer Anda bersama komunitas terbaik Indonesia.')

@push('styles')
<style>
    /* Custom Styles for Join Page */
    .hero-join-bg {
        background: linear-gradient(135deg, rgba(30, 64, 175, 0.9), rgba(220, 38, 38, 0.8)),
                   url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><pattern id="diamond-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse"><polygon points="50,0 100,50 50,100 0,50" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23diamond-pattern)"/></svg>');
        background-size: cover, 100px 100px;
        background-position: center, 0 0;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #374151;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #fff;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #1e40af;
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }
    
    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }
    
    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 1rem;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%236b7280'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1.25rem;
        padding-right: 3rem;
        appearance: none;
    }
    
    .form-select:focus {
        outline: none;
        border-color: #1e40af;
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }
    
    .benefit-card {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .benefit-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: #1e40af;
    }
    
    .step-number {
        background: linear-gradient(135deg, #1e40af, #dc2626);
        color: white;
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.25rem;
    }
    
    .requirement-item {
        display: flex;
        align-items: flex-start;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #1e40af;
    }
    
    .floating-label {
        position: relative;
    }
    
    .floating-label input:focus + label,
    .floating-label input:not(:placeholder-shown) + label {
        transform: translateY(-1.5rem) scale(0.875);
        color: #1e40af;
    }
    
    .floating-label label {
        position: absolute;
        top: 0.75rem;
        left: 1rem;
        transition: all 0.3s ease;
        pointer-events: none;
        color: #6b7280;
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-join-bg py-20 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                    <i class="fas fa-handshake text-white text-3xl"></i>
                </div>
            </div>
            
            <h1 class="font-poppins text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Bergabung dengan <span class="text-yellow-300">HASTANA</span>
            </h1>
            
            <p class="text-xl md:text-2xl mb-8 leading-relaxed opacity-90">
                Tingkatkan profesionalisme wedding organizer Anda bersama komunitas terbaik Indonesia
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                    <div class="text-3xl font-bold mb-2">1000+</div>
                    <div class="text-sm opacity-80">Anggota Aktif</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                    <div class="text-3xl font-bold mb-2">34</div>
                    <div class="text-sm opacity-80">Provinsi</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                    <div class="text-3xl font-bold mb-2">5</div>
                    <div class="text-sm opacity-80">Tahun Berpengalaman</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Mengapa Bergabung dengan <span class="text-blue-600">HASTANA</span>?
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Dapatkan akses eksklusif ke berbagai manfaat dan fasilitas yang akan memajukan bisnis wedding organizer Anda
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Benefit 1 -->
            <div class="benefit-card p-8 rounded-2xl">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-certificate text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Sertifikasi Resmi</h3>
                <p class="text-gray-600 leading-relaxed">
                    Dapatkan sertifikasi resmi HASTANA yang diakui secara nasional untuk meningkatkan kredibilitas bisnis Anda
                </p>
            </div>
            
            <!-- Benefit 2 -->
            <div class="benefit-card p-8 rounded-2xl">
                <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-network-wired text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Jaringan Nasional</h3>
                <p class="text-gray-600 leading-relaxed">
                    Terhubung dengan 1000+ wedding organizer profesional di seluruh Indonesia untuk kolaborasi dan referensi
                </p>
            </div>
            
            <!-- Benefit 3 -->
            <div class="benefit-card p-8 rounded-2xl">
                <div class="w-16 h-16 bg-gradient-to-br from-green-600 to-green-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Pelatihan Eksklusif</h3>
                <p class="text-gray-600 leading-relaxed">
                    Akses ke workshop, seminar, dan pelatihan khusus untuk meningkatkan skill dan pengetahuan industri
                </p>
            </div>
            
            <!-- Benefit 4 -->
            <div class="benefit-card p-8 rounded-2xl">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-bullhorn text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Platform Marketing</h3>
                <p class="text-gray-600 leading-relaxed">
                    Promosikan bisnis Anda melalui direktori resmi HASTANA dan platform digital kami
                </p>
            </div>
            
            <!-- Benefit 5 -->
            <div class="benefit-card p-8 rounded-2xl">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-600 to-yellow-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Perlindungan Legal</h3>
                <p class="text-gray-600 leading-relaxed">
                    Bantuan konsultasi hukum dan perlindungan dalam menghadapi isu legal bisnis wedding organizer
                </p>
            </div>
            
            <!-- Benefit 6 -->
            <div class="benefit-card p-8 rounded-2xl">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-handshake text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Kolaborasi Vendor</h3>
                <p class="text-gray-600 leading-relaxed">
                    Akses ke jaringan vendor terpercaya dengan harga khusus untuk member HASTANA
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Membership Types -->
{{-- <section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Pilihan <span class="text-red-600">Keanggotaan</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Pilih paket keanggotaan yang sesuai dengan kebutuhan dan skala bisnis wedding organizer Anda
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Silver Member -->
            <div class="bg-white border-2 border-gray-200 rounded-2xl p-8 relative hover:border-gray-400 transition-all duration-300">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-white text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Silver Member</h3>
                    <p class="text-gray-600 mb-4">Untuk WO pemula & menengah</p>
                    <div class="text-3xl font-bold text-gray-900 mb-2">Rp 500.000</div>
                    <div class="text-sm text-gray-500">per tahun</div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Sertifikasi HASTANA</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Akses direktori member</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Newsletter bulanan</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Event networking dasar</span>
                    </li>
                </ul>
                <button class="w-full bg-gray-600 text-white py-3 rounded-xl font-semibold hover:bg-gray-700 transition-colors">
                    Pilih Silver
                </button>
            </div>
            
            <!-- Gold Member -->
            <div class="bg-white border-2 border-yellow-400 rounded-2xl p-8 relative hover:border-yellow-500 transition-all duration-300 transform scale-105">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-yellow-400 text-white px-4 py-1 rounded-full text-sm font-semibold">Populer</span>
                </div>
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-crown text-white text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Gold Member</h3>
                    <p class="text-gray-600 mb-4">Untuk WO berpengalaman</p>
                    <div class="text-3xl font-bold text-gray-900 mb-2">Rp 1.000.000</div>
                    <div class="text-sm text-gray-500">per tahun</div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Semua fitur Silver</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Workshop eksklusif</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Listing prioritas</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Konsultasi bisnis</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Diskon vendor 10%</span>
                    </li>
                </ul>
                <button class="w-full bg-yellow-500 text-white py-3 rounded-xl font-semibold hover:bg-yellow-600 transition-colors">
                    Pilih Gold
                </button>
            </div>
            
            <!-- Platinum Member -->
            <div class="bg-white border-2 border-purple-400 rounded-2xl p-8 relative hover:border-purple-500 transition-all duration-300">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-gem text-white text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Platinum Member</h3>
                    <p class="text-gray-600 mb-4">Untuk WO enterprise</p>
                    <div class="text-3xl font-bold text-gray-900 mb-2">Rp 2.000.000</div>
                    <div class="text-sm text-gray-500">per tahun</div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Semua fitur Gold</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Dedicated account manager</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Marketing premium</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Event VIP access</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Diskon vendor 20%</span>
                    </li>
                </ul>
                <button class="w-full bg-purple-600 text-white py-3 rounded-xl font-semibold hover:bg-purple-700 transition-colors">
                    Pilih Platinum
                </button>
            </div>
        </div>
    </div>
</section> --}}

<!-- Registration Process -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Proses <span class="text-blue-600">Pendaftaran</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Ikuti langkah mudah untuk menjadi bagian dari komunitas wedding organizer terbesar Indonesia
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="step-number mx-auto mb-6">1</div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Isi Formulir</h3>
                <p class="text-gray-600">Lengkapi formulir pendaftaran dengan data perusahaan dan dokumen yang diperlukan</p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center">
                <div class="step-number mx-auto mb-6">2</div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Verifikasi</h3>
                <p class="text-gray-600">Tim HASTANA akan memverifikasi dokumen dan kelengkapan data dalam 3-5 hari kerja</p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center">
                <div class="step-number mx-auto mb-6">3</div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Pembayaran</h3>
                <p class="text-gray-600">Lakukan pembayaran biaya keanggotaan sesuai paket yang dipilih</p>
            </div>
            
            <!-- Step 4 -->
            <div class="text-center">
                <div class="step-number mx-auto mb-6">4</div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Aktivasi</h3>
                <p class="text-gray-600">Akun member aktif dan mulai nikmati semua fasilitas HASTANA</p>
            </div>
        </div>
    </div>
</section>

<!-- Registration Form -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Formulir <span class="text-red-600">Pendaftaran</span>
            </h2>
            <p class="text-xl text-gray-600">
                Isi data dengan lengkap dan benar untuk proses verifikasi yang lebih cepat
            </p>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Company Information -->
                <div class="mb-12">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                        <i class="fas fa-building text-blue-600 mr-3"></i>
                        Informasi Perusahaan
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">Nama Perusahaan *</label>
                            <input type="text" name="company_name" class="form-input" placeholder="PT. Wedding Organizer Indonesia" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Nama Pemilik/Direktur *</label>
                            <input type="text" name="owner_name" class="form-input" placeholder="John Doe" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email Perusahaan *</label>
                            <input type="email" name="email" class="form-input" placeholder="info@weddingorganizer.com" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Nomor Telepon *</label>
                            <input type="tel" name="phone" class="form-input" placeholder="+62 21 1234 5678" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tahun Berdiri *</label>
                            <input type="number" name="established_year" class="form-input" placeholder="2020" min="1990" max="2025" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Jumlah Karyawan</label>
                            <select name="employee_count" class="form-select">
                                <option value="">Pilih jumlah karyawan</option>
                                <option value="1-5">1-5 orang</option>
                                <option value="6-10">6-10 orang</option>
                                <option value="11-25">11-25 orang</option>
                                <option value="26-50">26-50 orang</option>
                                <option value="50+">Lebih dari 50 orang</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap *</label>
                        <textarea name="address" class="form-input form-textarea" placeholder="Jl. Wedding Street No. 123, Jakarta Selatan 12345" required></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="form-group">
                            <label class="form-label">Kota *</label>
                            <input type="text" name="city" class="form-input" placeholder="Jakarta" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Provinsi *</label>
                            <select name="province" class="form-select" required>
                                <option value="">Pilih Provinsi</option>
                                <option value="DKI Jakarta">DKI Jakarta</option>
                                <option value="Jawa Barat">Jawa Barat</option>
                                <option value="Jawa Tengah">Jawa Tengah</option>
                                <option value="Jawa Timur">Jawa Timur</option>
                                <option value="Bali">Bali</option>
                                <option value="Sumatera Utara">Sumatera Utara</option>
                                <option value="Sumatera Barat">Sumatera Barat</option>
                                <option value="Riau">Riau</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="postal_code" class="form-input" placeholder="12345">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Website/Instagram</label>
                        <input type="url" name="website" class="form-input" placeholder="https://www.instagram.com/weddingorganizer">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Deskripsi Perusahaan</label>
                        <textarea name="description" class="form-input form-textarea" placeholder="Ceritakan tentang perusahaan wedding organizer Anda, spesialisasi, dan pengalaman..."></textarea>
                    </div>
                </div>
                
                <!-- Legal Documents -->
                <div class="mb-12">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                        <i class="fas fa-file-alt text-red-600 mr-3"></i>
                        Dokumen Legal
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">Nomor Izin Usaha (SIUP/NIB) *</label>
                            <input type="text" name="business_license" class="form-input" placeholder="1234567890123456" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">NPWP Perusahaan</label>
                            <input type="text" name="tax_number" class="form-input" placeholder="12.345.678.9-012.345">
                        </div>
                    </div>
                    
                    <div class="requirement-item">
                        <i class="fas fa-info-circle text-blue-600 mr-3 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Dokumen yang Diperlukan:</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Scan SIUP/NIB (format PDF/JPG, max 2MB)</li>
                                <li>• Scan NPWP Perusahaan (format PDF/JPG, max 2MB)</li>
                                <li>• Logo perusahaan (format PNG/JPG, max 1MB)</li>
                                <li>• Portfolio minimal 3 proyek (format PDF/JPG, max 5MB)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Membership Selection -->
                {{-- <div class="mb-12">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                        <i class="fas fa-crown text-yellow-600 mr-3"></i>
                        Pilihan Keanggotaan
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="relative">
                            <input type="radio" name="membership_type" value="silver" class="sr-only peer" required>
                            <div class="p-6 border-2 border-gray-200 rounded-xl cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                <div class="text-center">
                                    <i class="fas fa-star text-gray-500 text-2xl mb-3"></i>
                                    <h4 class="font-bold text-lg">Silver</h4>
                                    <p class="text-2xl font-bold text-gray-900 mt-2">Rp 500.000</p>
                                    <p class="text-sm text-gray-500">per tahun</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="membership_type" value="gold" class="sr-only peer">
                            <div class="p-6 border-2 border-gray-200 rounded-xl cursor-pointer peer-checked:border-yellow-500 peer-checked:bg-yellow-50 transition-all">
                                <div class="text-center">
                                    <i class="fas fa-crown text-yellow-500 text-2xl mb-3"></i>
                                    <h4 class="font-bold text-lg">Gold</h4>
                                    <p class="text-2xl font-bold text-gray-900 mt-2">Rp 1.000.000</p>
                                    <p class="text-sm text-gray-500">per tahun</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="membership_type" value="platinum" class="sr-only peer">
                            <div class="p-6 border-2 border-gray-200 rounded-xl cursor-pointer peer-checked:border-purple-500 peer-checked:bg-purple-50 transition-all">
                                <div class="text-center">
                                    <i class="fas fa-gem text-purple-500 text-2xl mb-3"></i>
                                    <h4 class="font-bold text-lg">Platinum</h4>
                                    <p class="text-2xl font-bold text-gray-900 mt-2">Rp 2.000.000</p>
                                    <p class="text-sm text-gray-500">per tahun</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div> --}}
                
                <!-- Terms and Conditions -->
                <div class="mb-8">
                    <label class="flex items-start space-x-3">
                        <input type="checkbox" name="terms" class="mt-1 h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" required>
                        <span class="text-gray-700">
                            Saya menyetujui <a href="{{ route('terms') }}" target="_blank" class="text-blue-600 hover:underline font-semibold">syarat dan ketentuan</a> 
                            serta <a href="{{ route('privacy') }}" target="_blank" class="text-blue-600 hover:underline font-semibold">kebijakan privasi</a> 
                            keanggotaan HASTANA Indonesia dan bersedia mematuhi kode etik organisasi.
                        </span>
                    </label>
                </div>
                
                <div class="mb-8">
                    <label class="flex items-start space-x-3">
                        <input type="checkbox" name="newsletter" class="mt-1 h-5 w-5 text-blue-600 border-gray-300 rounded">
                        <span class="text-gray-700">
                            Saya ingin menerima newsletter dan informasi terbaru dari HASTANA Indonesia.
                        </span>
                    </label>
                </div>
                
                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="inline-flex items-center px-12 py-4 bg-gradient-to-r from-blue-600 to-red-600 text-white font-bold text-lg rounded-full hover:from-blue-700 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-paper-plane mr-3"></i>
                        Daftar Sekarang
                    </button>
                    <p class="text-sm text-gray-500 mt-4">
                        * Tim HASTANA akan menghubungi Anda dalam 3-5 hari kerja
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-20 bg-gray-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
            Butuh Bantuan dengan Pendaftaran?
        </h2>
        <p class="text-xl text-gray-300 mb-8">
            Tim customer service kami siap membantu Anda dalam proses pendaftaran
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-phone text-white text-xl"></i>
                </div>
                <h3 class="font-semibold mb-2">Telepon</h3>
                <p class="text-gray-300">+62 21 1234 5678</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-white text-xl"></i>
                </div>
                <h3 class="font-semibold mb-2">Email</h3>
                <p class="text-gray-300">membership@hastana.id</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fab fa-whatsapp text-white text-xl"></i>
                </div>
                <h3 class="font-semibold mb-2">WhatsApp</h3>
                <p class="text-gray-300">+62 812 3456 7890</p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Form validation and interactive elements
    document.addEventListener('DOMContentLoaded', function() {
        // Membership type selection highlighting
        const membershipRadios = document.querySelectorAll('input[name="membership_type"]');
        membershipRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove highlight from all options
                membershipRadios.forEach(r => {
                    const label = r.closest('label');
                    const div = label.querySelector('div');
                    div.classList.remove('ring-4', 'ring-blue-200', 'ring-yellow-200', 'ring-purple-200');
                });
                
                // Add highlight to selected option
                if (this.checked) {
                    const label = this.closest('label');
                    const div = label.querySelector('div');
                    if (this.value === 'silver') {
                        div.classList.add('ring-4', 'ring-blue-200');
                    } else if (this.value === 'gold') {
                        div.classList.add('ring-4', 'ring-yellow-200');
                    } else if (this.value === 'platinum') {
                        div.classList.add('ring-4', 'ring-purple-200');
                    }
                }
            });
        });

        // Form submission handling
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Memproses...';
            submitButton.disabled = true;
            
            // Simulate form submission (replace with actual submission logic)
            setTimeout(() => {
                alert('Formulir pendaftaran telah berhasil dikirim! Tim HASTANA akan menghubungi Anda dalam 3-5 hari kerja.');
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }, 2000);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
@endpush
