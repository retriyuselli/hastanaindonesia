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
        font-size: 0.875rem;
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
        font-size: 0.875rem;
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
        font-size: 1rem;
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

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.75);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-content {
        background: white;
        border-radius: 1rem;
        max-width: 800px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        transform: scale(0.9);
        transition: transform 0.3s ease;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    }

    .modal-overlay.active .modal-content {
        transform: scale(1);
    }

    .form-disabled {
        pointer-events: none;
        opacity: 0.6;
        filter: grayscale(50%);
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
                    <i class="fas fa-handshake text-white text-lg"></i>
                </div>
            </div>
            
            <h1 class="font-poppins text-2xl md:text-4xl font-bold mb-6 leading-tight">
                Bergabung dengan <span class="text-yellow-300">HASTANA</span>
            </h1>
            
            <p class="text-base md:text-lg mb-8 leading-relaxed opacity-90">
                Tingkatkan profesionalisme wedding organizer Anda bersama komunitas terbaik Indonesia
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                    <div class="text-2xl font-bold mb-2">1000+</div>
                    <div class="text-xs opacity-80">Anggota Aktif</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                    <div class="text-2xl font-bold mb-2">34</div>
                    <div class="text-xs opacity-80">Provinsi</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                    <div class="text-2xl font-bold mb-2">5</div>
                    <div class="text-xs opacity-80">Tahun Berpengalaman</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                Mengapa Bergabung dengan <span class="text-blue-600">HASTANA</span>?
            </h2>
            <p class="text-base text-gray-600 max-w-3xl mx-auto">
                Dapatkan akses eksklusif ke berbagai manfaat dan fasilitas yang akan memajukan bisnis wedding organizer Anda
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Benefit 1 -->
            <div class="benefit-card p-8 rounded-2xl">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-certificate text-white text-lg"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-4">Sertifikasi Resmi</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Dapatkan sertifikasi resmi HASTANA yang diakui secara nasional untuk meningkatkan kredibilitas bisnis Anda
                </p>
            </div>
            
            <!-- Benefit 2 -->
            <div class="benefit-card p-8 rounded-2xl">
                <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-network-wired text-white text-lg"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-4">Jaringan Nasional</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Terhubung dengan 1000+ wedding organizer profesional di seluruh Indonesia untuk kolaborasi dan referensi
                </p>
            </div>
            
            <!-- Benefit 3 -->
            <div class="benefit-card p-8 rounded-2xl">
                <div class="w-16 h-16 bg-gradient-to-br from-green-600 to-green-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-4">Pelatihan Eksklusif</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Akses ke workshop, seminar, dan pelatihan khusus untuk meningkatkan skill dan pengetahuan industri
                </p>
            </div>
            
            <!-- Benefit 4 -->
            <div class="benefit-card p-8 rounded-2xl">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-bullhorn text-white text-lg"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-4">Platform Marketing</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Promosikan bisnis Anda melalui direktori resmi HASTANA dan platform digital kami
                </p>
            </div>
            
            <!-- Benefit 5 -->
            <div class="benefit-card p-8 rounded-2xl">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-600 to-yellow-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shield-alt text-white text-lg"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-4">Perlindungan Legal</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Bantuan konsultasi hukum dan perlindungan dalam menghadapi isu legal bisnis wedding organizer
                </p>
            </div>
            
            <!-- Benefit 6 -->
            <div class="benefit-card p-8 rounded-2xl">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-handshake text-white text-lg"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-4">Kolaborasi Vendor</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Akses ke jaringan vendor terpercaya dengan harga khusus untuk member HASTANA
                </p>
            </div>
        </div>
    </div>
</section>

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
                <h3 class="text-base font-bold text-gray-900 mb-4">Isi Formulir</h3>
                <p class="text-gray-600">Lengkapi formulir pendaftaran dengan data perusahaan dan dokumen yang diperlukan</p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center">
                <div class="step-number mx-auto mb-6">2</div>
                <h3 class="text-base font-bold text-gray-900 mb-4">Verifikasi</h3>
                <p class="text-gray-600">Tim HASTANA akan memverifikasi dokumen dan kelengkapan data dalam 3-5 hari kerja</p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center">
                <div class="step-number mx-auto mb-6">3</div>
                <h3 class="text-base font-bold text-gray-900 mb-4">Pembayaran</h3>
                <p class="text-gray-600">Lakukan pembayaran biaya keanggotaan sesuai paket yang dipilih</p>
            </div>
            
            <!-- Step 4 -->
            <div class="text-center">
                <div class="step-number mx-auto mb-6">4</div>
                <h3 class="text-base font-bold text-gray-900 mb-4">Aktivasi</h3>
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
        
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8 {{ $alreadyRegistered ? 'form-disabled' : '' }}">
            <!-- Already Registered Warning -->
            @if($alreadyRegistered)
            <div class="mb-6 bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-400 text-yellow-900 rounded-xl p-6 flex items-start shadow-lg">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-3xl mr-4 mt-1 animate-pulse"></i>
                <div class="flex-1">
                    <h4 class="font-bold text-lg mb-2 flex items-center">
                        <i class="fas fa-lock mr-2"></i>
                        Form Pendaftaran Tidak Tersedia
                    </h4>
                    <p class="text-sm mb-3">
                        Akun Anda sudah memiliki wedding organizer yang terdaftar: 
                        <strong class="text-yellow-800">{{ $existingOrganizer->organizer_name }}</strong>
                    </p>
                    <div class="bg-white rounded-lg p-3 border border-yellow-300">
                        <p class="text-xs text-gray-700">
                            <i class="fas fa-info-circle text-yellow-600 mr-1"></i>
                            Satu akun hanya dapat mendaftarkan 1 wedding organizer. Untuk perubahan data atau pertanyaan, silakan hubungi admin HASTANA.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- User Info Section -->
            @auth
            <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 rounded-lg p-4 flex items-start">
                <i class="fas fa-user-circle text-blue-600 text-xl mr-3 mt-1"></i>
                <div class="flex-1">
                    <h4 class="font-semibold mb-1">Pendaftaran atas nama:</h4>
                    <p class="text-sm">
                        <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})
                    </p>
                    <p class="text-xs mt-2 text-blue-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Wedding organizer yang Anda daftarkan akan terhubung dengan akun Anda
                    </p>
                </div>
            </div>
            @endauth

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 flex items-start">
                <i class="fas fa-check-circle text-green-600 text-xl mr-3 mt-1"></i>
                <div>
                    <h4 class="font-semibold mb-1">Pendaftaran Berhasil!</h4>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 flex items-start">
                <i class="fas fa-exclamation-circle text-red-600 text-xl mr-3 mt-1"></i>
                <div>
                    <h4 class="font-semibold mb-1">Terjadi Kesalahan!</h4>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-lg p-4">
                <div class="flex items-start mb-2">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl mr-3 mt-1"></i>
                    <h4 class="font-semibold">Terdapat kesalahan pada form:</h4>
                </div>
                <ul class="list-disc list-inside text-sm ml-9 space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('join.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Company Information -->
                <div class="mb-12">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                        <i class="fas fa-building text-blue-600 mr-3"></i>
                        Informasi Wedding Organizer
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">Nama Wedding Organizer *</label>
                            <input type="text" name="organizer_name" class="form-input @error('organizer_name') border-red-500 @enderror" placeholder="Elegant Wedding Organizer" value="{{ old('organizer_name') }}" required>
                            @error('organizer_name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @else
                            <p class="text-xs text-gray-500 mt-1">Nama resmi perusahaan WO Anda</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Nama PT/CV (Optional)</label>
                            <input type="text" name="brand_name" class="form-input @error('brand_name') border-red-500 @enderror" placeholder="Elegant WO" value="{{ old('brand_name') }}">
                            @error('brand_name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @else
                            <p class="text-xs text-gray-500 mt-1">Nama brand untuk pemasaran (opsional)</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-input @error('email') border-red-500 @enderror" placeholder="info@elegantwedding.com" value="{{ old('email') }}" required>
                            @error('email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Nomor Telepon/WhatsApp *</label>
                            <input type="tel" name="phone" class="form-input @error('phone') border-red-500 @enderror" placeholder="081234567890" value="{{ old('phone') }}" required>
                            @error('phone')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tahun Berdiri *</label>
                            <input type="number" name="established_year" class="form-input @error('established_year') border-red-500 @enderror" placeholder="2020" min="1990" max="2025" value="{{ old('established_year') }}" required>
                            @error('established_year')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Jenis Usaha *</label>
                            <select name="business_type" class="form-select @error('business_type') border-red-500 @enderror" required>
                                <option value="">Pilih Jenis Usaha</option>
                                @foreach(config('indonesia.business_types') as $value => $label)
                                <option value="{{ $value }}" {{ old('business_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('business_type')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Wilayah Operasional *</label>
                        <select name="region_id" class="form-select @error('region_id') border-red-500 @enderror" required>
                            <option value="">Pilih Wilayah</option>
                            @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                {{ $region->region_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('region_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @else
                        <p class="text-xs text-gray-500 mt-1">Pilih wilayah operasional wedding organizer Anda</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap *</label>
                        <textarea name="address" class="form-input form-textarea @error('address') border-red-500 @enderror" rows="2" placeholder="Jl. Wedding Street No. 123" required>{{ old('address') }}</textarea>
                        @error('address')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="form-group">
                            <label class="form-label">Provinsi *</label>
                            <select name="province" id="province-select" class="form-select @error('province') border-red-500 @enderror" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach(config('indonesia.provinces') as $key => $province)
                                <option value="{{ $key }}" {{ old('province') == $key ? 'selected' : '' }}>{{ $province }}</option>
                                @endforeach
                            </select>
                            @error('province')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Kota *</label>
                            <select name="city" id="city-select" class="form-select @error('city') border-red-500 @enderror" required>
                                <option value="">Pilih provinsi terlebih dahulu</option>
                            </select>
                            @error('city')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @else
                            <p class="text-xs text-gray-500 mt-1">Pilih provinsi untuk melihat daftar kota</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="postal_code" class="form-input @error('postal_code') border-red-500 @enderror" placeholder="12345" maxlength="5" value="{{ old('postal_code') }}">
                            @error('postal_code')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">Website</label>
                            <input type="url" name="website" class="form-input @error('website') border-red-500 @enderror" placeholder="https://www.elegantwedding.com" value="{{ old('website') }}">
                            @error('website')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Instagram</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">@</span>
                                <input type="text" name="instagram" class="form-input pl-8 @error('instagram') border-red-500 @enderror" placeholder="elegantwedding" value="{{ old('instagram') }}">
                            </div>
                            @error('instagram')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Deskripsi Singkat *</label>
                        <textarea name="description" class="form-input form-textarea @error('description') border-red-500 @enderror" rows="3" placeholder="Ceritakan tentang wedding organizer Anda, spesialisasi, dan pengalaman..." required>{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @else
                        <p class="text-xs text-gray-500 mt-1">Minimal 50 karakter</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Spesialisasi/Layanan *</label>
                        <textarea name="specializations" class="form-input form-textarea @error('specializations') border-red-500 @enderror" rows="2" placeholder="Contoh: Traditional Wedding, Modern Wedding, Intimate Wedding, etc" required>{{ old('specializations') }}</textarea>
                        @error('specializations')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @else
                        <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Layanan yang Ditawarkan</label>
                        <textarea name="services" class="form-input form-textarea @error('services') border-red-500 @enderror" rows="2" placeholder="Contoh: Full Planning, Decoration, Catering Coordination, Photography, Videography, etc">{{ old('services') }}</textarea>
                        @error('services')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @else
                        <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma (opsional)</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">Harga Minimum Paket</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" name="price_range_min" class="form-input pl-12 @error('price_range_min') border-red-500 @enderror" placeholder="50000000" value="{{ old('price_range_min') }}" min="0">
                            </div>
                            @error('price_range_min')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @else
                            <p class="text-xs text-gray-500 mt-1">Contoh: 50000000 (50 juta)</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Harga Maksimum Paket</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" name="price_range_max" class="form-input pl-12 @error('price_range_max') border-red-500 @enderror" placeholder="500000000" value="{{ old('price_range_max') }}" min="0">
                            </div>
                            @error('price_range_max')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @else
                            <p class="text-xs text-gray-500 mt-1">Contoh: 500000000 (500 juta)</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jumlah Event yang Telah Diselesaikan</label>
                        <input type="number" name="completed_events" class="form-input @error('completed_events') border-red-500 @enderror" placeholder="25" value="{{ old('completed_events', 0) }}" min="0">
                        @error('completed_events')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @else
                        <p class="text-xs text-gray-500 mt-1">Total jumlah acara pernikahan yang sudah ditangani</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Penghargaan</label>
                        <textarea name="awards" class="form-input form-textarea @error('awards') border-red-500 @enderror" rows="2" placeholder="Contoh: Best Wedding Organizer 2023, TOP 10 WO Indonesia 2022, dll">{{ old('awards') }}</textarea>
                        @error('awards')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @else
                        <p class="text-xs text-gray-500 mt-1">Sebutkan penghargaan yang pernah diterima (opsional)</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Level Sertifikasi (opsional)</label>
                        <select name="certification_level" class="form-select @error('certification_level') border-red-500 @enderror">
                            <option value="">-- Pilih Level Sertifikasi --</option>
                            @foreach(config('indonesia.certification_levels') as $key => $value)
                                <option value="{{ $key }}" {{ old('certification_level') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('certification_level')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @else
                        <p class="text-xs text-gray-500 mt-1">Level kompetensi akan dinilai oleh tim HASTANA (opsional)</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Legal Documents -->
                <div class="mb-12">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                        <i class="fas fa-file-contract text-red-600 mr-3"></i>
                        Informasi Legal
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label">Nomor Izin Usaha (NIB/SIUP/TDP) *</label>
                        <input type="text" name="business_license" class="form-input @error('business_license') border-red-500 @enderror" placeholder="1234567890123456" value="{{ old('business_license') }}" required>
                        @error('business_license')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @else
                        <p class="text-xs text-gray-500 mt-1">Masukkan nomor izin usaha yang valid</p>
                        @enderror
                    </div>

                    <!-- Legal Detail Fields (Opsional) -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 mb-6">
                        <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-file-alt text-blue-600 mr-2"></i>
                            Detail Legalitas (Opsional - dapat dilengkapi nanti)
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group mb-0">
                                <label class="form-label">Jenis Badan Hukum</label>
                                <select name="legal_entity_type" class="form-select @error('legal_entity_type') border-red-500 @enderror">
                                    <option value="">Pilih Jenis Badan Hukum</option>
                                    <option value="PT" {{ old('legal_entity_type') == 'PT' ? 'selected' : '' }}>Perseroan Terbatas (PT)</option>
                                    <option value="CV" {{ old('legal_entity_type') == 'CV' ? 'selected' : '' }}>Commanditaire Vennootschap (CV)</option>
                                    <option value="Firma" {{ old('legal_entity_type') == 'Firma' ? 'selected' : '' }}>Firma</option>
                                    <option value="UD" {{ old('legal_entity_type') == 'UD' ? 'selected' : '' }}>Usaha Dagang (UD)</option>
                                    <option value="Koperasi" {{ old('legal_entity_type') == 'Koperasi' ? 'selected' : '' }}>Koperasi</option>
                                    <option value="Yayasan" {{ old('legal_entity_type') == 'Yayasan' ? 'selected' : '' }}>Yayasan</option>
                                </select>
                                @error('legal_entity_type')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label">Nomor Akta Pendirian</label>
                                <input type="text" name="deed_of_establishment" class="form-input @error('deed_of_establishment') border-red-500 @enderror" placeholder="No. 123/2020" value="{{ old('deed_of_establishment') }}">
                                @error('deed_of_establishment')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label">Tanggal Akta</label>
                                <input type="date" name="deed_date" class="form-input @error('deed_date') border-red-500 @enderror" value="{{ old('deed_date') }}">
                                @error('deed_date')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label">Nama Notaris</label>
                                <input type="text" name="notary_name" class="form-input @error('notary_name') border-red-500 @enderror" placeholder="Dr. John Doe, S.H., M.Kn." value="{{ old('notary_name') }}">
                                @error('notary_name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label">Nomor Izin Notaris</label>
                                <input type="text" name="notary_license_number" class="form-input @error('notary_license_number') border-red-500 @enderror" placeholder="123/KEP/2020" value="{{ old('notary_license_number') }}">
                                @error('notary_license_number')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label">Nomor NIB (Nomor Induk Berusaha)</label>
                                <input type="text" name="nib_number" class="form-input @error('nib_number') border-red-500 @enderror" placeholder="1234567890123" value="{{ old('nib_number') }}">
                                @error('nib_number')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @else
                                <p class="text-xs text-gray-500 mt-1">13 digit NIB dari OSS</p>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label">Tanggal Terbit NIB</label>
                                <input type="date" name="nib_issued_date" class="form-input @error('nib_issued_date') border-red-500 @enderror" value="{{ old('nib_issued_date') }}">
                                @error('nib_issued_date')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label">NIB Berlaku Sampai</label>
                                <input type="date" name="nib_valid_until" class="form-input @error('nib_valid_until') border-red-500 @enderror" value="{{ old('nib_valid_until') }}">
                                @error('nib_valid_until')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label">Nomor NPWP</label>
                                <input type="text" name="npwp_number" class="form-input @error('npwp_number') border-red-500 @enderror" placeholder="12.345.678.9-012.000" value="{{ old('npwp_number') }}">
                                @error('npwp_number')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @else
                                <p class="text-xs text-gray-500 mt-1">Format: XX.XXX.XXX.X-XXX.XXX</p>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label">Tanggal Terbit NPWP</label>
                                <input type="date" name="npwp_issued_date" class="form-input @error('npwp_issued_date') border-red-500 @enderror" value="{{ old('npwp_issued_date') }}">
                                @error('npwp_issued_date')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-0 md:col-span-2">
                                <label class="form-label">Kantor Pajak Terdaftar</label>
                                <input type="text" name="tax_office" class="form-input @error('tax_office') border-red-500 @enderror" placeholder="KPP Pratama Jakarta Selatan" value="{{ old('tax_office') }}">
                                @error('tax_office')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Dokumen Legal</label>
                        <input type="file" name="legal_documents[]" class="form-input @error('legal_documents') border-red-500 @enderror" multiple accept=".pdf,.jpg,.jpeg,.png">
                        @error('legal_documents')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @else
                        <p class="text-xs text-gray-500 mt-1">Upload dokumen: NIB, NPWP, Akta, KTP (PDF/JPG, max 5MB per file, opsional saat pendaftaran)</p>
                        @enderror
                    </div>
                    
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-5 mt-6">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-info-circle text-amber-600 text-xl mt-1"></i>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-3">Dokumen Tambahan yang Akan Dibutuhkan</h4>
                                <ul class="text-sm text-gray-700 space-y-2 mb-4">
                                    <li class="flex items-center">
                                        <i class="fas fa-file-pdf text-red-500 w-5 mr-2"></i>
                                        NPWP Perusahaan
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-file-pdf text-red-500 w-5 mr-2"></i>
                                        Akta Pendirian untuk PT/CV
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-id-card text-blue-500 w-5 mr-2"></i>
                                        KTP Pemilik/Penanggung Jawab
                                    </li>
                                </ul>
                                <div class="bg-white rounded-lg px-4 py-3 border border-amber-100">
                                    <p class="text-xs text-gray-700 flex items-center">
                                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                        <span><strong>Catatan:</strong> Dokumen lengkap dapat dilengkapi setelah pendaftaran disetujui melalui dashboard admin Anda</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Terms and Conditions -->
                <div class="mb-8">
                    <label class="flex items-start space-x-3">
                        <input type="checkbox" name="terms" class="mt-1 h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 @error('terms') border-red-500 @enderror" required {{ old('terms') ? 'checked' : '' }}>
                        <span class="text-gray-700">
                            Saya menyetujui <a href="{{ route('terms') }}" target="_blank" class="text-blue-600 hover:underline font-semibold">syarat dan ketentuan</a> 
                            serta <a href="{{ route('privacy') }}" target="_blank" class="text-blue-600 hover:underline font-semibold">kebijakan privasi</a> 
                            keanggotaan HASTANA Indonesia dan bersedia mematuhi kode etik organisasi. *
                        </span>
                    </label>
                    @error('terms')
                    <p class="text-xs text-red-600 mt-1 ml-8">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Submit Button -->
                <div class="text-center">
                    @if($alreadyRegistered)
                    <button type="submit" class="inline-flex items-center px-12 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold text-lg rounded-full hover:from-green-700 hover:to-green-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-save mr-3"></i>
                        Update Data
                    </button>
                    <p class="text-sm text-gray-500 mt-4">
                        * Klik tombol "Edit" terlebih dahulu untuk mengubah data
                    </p>
                    @else
                    <button type="submit" class="inline-flex items-center px-12 py-4 bg-gradient-to-r from-blue-600 to-red-600 text-white font-bold text-lg rounded-full hover:from-blue-700 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-paper-plane mr-3"></i>
                        Daftar Sekarang
                    </button>
                    <p class="text-sm text-gray-500 mt-4">
                        * Tim HASTANA akan menghubungi Anda dalam 3-5 hari kerja
                    </p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Modal - Already Registered -->
@if($alreadyRegistered)
<div id="alreadyRegisteredModal" class="modal-overlay active">
    <div class="modal-content">
        <div class="p-6">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-3 animate-bounce">
                    <i class="fas fa-check-circle text-white text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Anda Sudah Terdaftar!
                </h2>
                <p class="text-sm text-gray-600">
                    Akun Anda sudah memiliki wedding organizer yang terdaftar di Hastana Indonesia
                </p>
            </div>

            <!-- Organizer Info -->
            @if($existingOrganizer)
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 mb-4 border border-blue-200">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        @if($existingOrganizer->user && $existingOrganizer->user->avatar)
                            <img src="{{ asset('storage/' . $existingOrganizer->user->avatar) }}" 
                                 alt="{{ $existingOrganizer->user->name }}" 
                                 class="w-12 h-12 rounded-full object-cover border-2 border-blue-300">
                        @else
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center border-2 border-blue-300">
                                <span class="text-white text-lg font-bold">
                                    {{ strtoupper(substr($existingOrganizer->user->name ?? $existingOrganizer->organizer_name, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-base text-gray-900 mb-1">
                            {{ $existingOrganizer->organizer_name }}
                        </h3>
                        @if($existingOrganizer->brand_name)
                        <p class="text-xs text-gray-600 mb-2">
                            <i class="fas fa-building mr-1"></i>
                            {{ $existingOrganizer->brand_name }}
                        </p>
                        @endif
                        <div class="flex flex-wrap gap-2 text-xs">
                            <span class="px-3 py-1 bg-white rounded-full border border-blue-200 text-blue-700">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $existingOrganizer->city }}
                            </span>
                            @if($existingOrganizer->verification_status === 'verified')
                                <span class="px-3 py-1 bg-green-100 rounded-full border border-green-300 text-green-700">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Terverifikasi
                                </span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 rounded-full border border-yellow-300 text-yellow-700">
                                    <i class="fas fa-clock mr-1"></i>
                                    Menunggu Approval
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Legal Information Warning -->
            @if($existingOrganizer)
            @php
                $missingLegalFields = [];
                $legalFields = [
                    'legal_entity_type' => 'Jenis Badan Hukum',
                    'deed_of_establishment' => 'Nomor Akta Pendirian',
                    'deed_date' => 'Tanggal Akta',
                    'notary_name' => 'Nama Notaris',
                    'notary_license_number' => 'Nomor Izin Notaris',
                    'nib_number' => 'Nomor NIB',
                    'nib_issued_date' => 'Tanggal Terbit NIB',
                    'nib_valid_until' => 'NIB Berlaku Sampai',
                    'npwp_number' => 'Nomor NPWP',
                    'npwp_issued_date' => 'Tanggal Terbit NPWP',
                    'tax_office' => 'Kantor Pajak Terdaftar'
                ];
                
                foreach ($legalFields as $field => $label) {
                    if (empty($existingOrganizer->$field)) {
                        $missingLegalFields[$field] = $label;
                    }
                }
            @endphp

            @if(count($missingLegalFields) > 0)
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-2 border-red-300 rounded-xl p-4 mb-4 shadow-md">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center animate-pulse">
                            <i class="fas fa-exclamation text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-base text-red-900 mb-2 flex items-center">
                            <i class="fas fa-file-contract mr-2 text-sm"></i>
                            Tambah Keterangan Legal
                        </h4>
                        <p class="text-xs text-red-800 mb-2">
                            Dokumen legal Anda belum lengkap. Untuk meningkatkan kredibilitas dan mempercepat proses verifikasi, silakan lengkapi data berikut:
                        </p>
                        <div class="bg-white rounded-lg p-3 border border-red-200 mb-2">
                            <ul class="grid grid-cols-1 gap-1 text-xs text-red-700">
                                @foreach($missingLegalFields as $field => $label)
                                <li class="flex items-start">
                                    <i class="fas fa-times-circle text-red-500 text-xs mt-0.5 mr-2"></i>
                                    <span><strong>{{ $label }}</strong> - Belum diisi</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="bg-red-100 rounded-lg px-3 py-2 border border-red-200">
                            <p class="text-xs text-red-800 flex items-center">
                                <i class="fas fa-lightbulb text-red-600 mr-2 text-xs"></i>
                                <span><strong>Tips:</strong> Klik tombol "Edit" di bawah untuk melengkapi data legal Anda. Data legal yang lengkap akan mempercepat proses verifikasi dan meningkatkan kepercayaan klien.</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endif

            <!-- Info Box -->
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-4">
                <div class="flex items-start space-x-2">
                    <i class="fas fa-info-circle text-amber-600 text-sm mt-0.5"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-sm text-gray-900 mb-2">Informasi Penting:</h4>
                        <ul class="text-xs text-gray-700 space-y-1">
                            <li class="flex items-start">
                                <i class="fas fa-chevron-right text-amber-600 text-xs mt-0.5 mr-2"></i>
                                <span>Satu akun hanya dapat memiliki 1 wedding organizer</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-chevron-right text-amber-600 text-xs mt-0.5 mr-2"></i>
                                <span>Untuk mengelola data wedding organizer Anda, silakan hubungi admin</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-chevron-right text-amber-600 text-xs mt-0.5 mr-2"></i>
                                <span>Jika ingin mendaftar wedding organizer baru, gunakan akun yang berbeda</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('home') }}" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                    <i class="fas fa-home mr-2 text-xs"></i>
                    Home
                </a>
                <button onclick="closeModal()" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-white text-blue-600 text-sm font-semibold rounded-lg border-2 border-blue-600 hover:bg-blue-50 transition-all duration-300">
                    <i class="fas fa-edit mr-2 text-xs"></i>
                    Edit
                </button>
            </div>
        </div>
    </div>
</div>
@endif

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
    // Already Registered Modal
    @if($alreadyRegistered)
    // Data wedding organizer yang sudah terdaftar
    const existingData = @json($existingOrganizer);
    console.log('Existing Data:', existingData);
    console.log('City:', existingData?.city);
    console.log('Legal Documents:', existingData?.legal_documents);
    console.log('Date Fields:', {
        deed_date: existingData?.deed_date,
        nib_issued_date: existingData?.nib_issued_date,
        nib_valid_until: existingData?.nib_valid_until,
        npwp_issued_date: existingData?.npwp_issued_date
    });
    
    // Disable form when user already registered
    document.addEventListener('DOMContentLoaded', function() {
        const formSection = document.querySelector('form').closest('section');
        const formContainer = formSection.querySelector('.bg-white.rounded-2xl');
        
        // Add disabled class to form
        formContainer.classList.add('form-disabled');
        
        // Prevent form submission initially
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            if (formContainer.classList.contains('form-disabled')) {
                e.preventDefault();
                alert('Anda sudah terdaftar sebagai Wedding Organizer. Klik tombol "Edit" untuk mengubah data.');
                return false;
            }
        });
    });

    // Function to populate form with existing data
    function populateForm() {
        if (!existingData) return;

        // Populate text inputs and select
        const fields = [
            'organizer_name', 'brand_name', 'email', 'phone', 
            'established_year', 'business_type', 'address', 
            'postal_code', 'website', 'instagram', 'business_license',
            'price_range_min', 'price_range_max', 'completed_events',
            'certification_level', 'region_id',
            // Legal fields
            'legal_entity_type', 'deed_of_establishment', 'deed_date',
            'notary_name', 'notary_license_number', 'nib_number',
            'nib_issued_date', 'nib_valid_until', 'npwp_number',
            'npwp_issued_date', 'tax_office'
        ];

        fields.forEach(field => {
            const input = document.querySelector(`[name="${field}"]`);
            if (input && existingData[field]) {
                // Handle date inputs - need to format properly
                if (input.type === 'date') {
                    // Convert date to YYYY-MM-DD format
                    let dateValue = existingData[field];
                    if (typeof dateValue === 'string' && dateValue.includes('T')) {
                        // ISO format: 2025-10-30T00:00:00.000000Z
                        dateValue = dateValue.split('T')[0];
                    } else if (typeof dateValue === 'object' && dateValue.date) {
                        // Laravel date object format
                        dateValue = dateValue.date.split(' ')[0];
                    }
                    input.value = dateValue;
                } else {
                    input.value = existingData[field];
                }
            }
        });

        // Populate description textarea (single field)
        const descriptionTextarea = document.querySelector('textarea[name="description"]');
        if (descriptionTextarea && existingData.description) {
            descriptionTextarea.value = existingData.description;
        }

        // Populate array textareas (specializations, services, awards)
        const arrayTextareaFields = ['specializations', 'services', 'awards'];
        arrayTextareaFields.forEach(field => {
            const textarea = document.querySelector(`textarea[name="${field}"]`);
            if (textarea && existingData[field]) {
                // Convert JSON array to comma-separated string if needed
                if (typeof existingData[field] === 'object' && Array.isArray(existingData[field])) {
                    textarea.value = existingData[field].join(', ');
                } else if (typeof existingData[field] === 'string') {
                    try {
                        const parsed = JSON.parse(existingData[field]);
                        textarea.value = Array.isArray(parsed) ? parsed.join(', ') : existingData[field];
                    } catch (e) {
                        textarea.value = existingData[field];
                    }
                } else {
                    textarea.value = existingData[field];
                }
            }
        });

        // Update province dropdown first
        const provinceSelect = document.getElementById('province-select');
        const citySelect = document.getElementById('city-select');
        
        if (provinceSelect && existingData.province) {
            console.log('Setting province to:', existingData.province);
            provinceSelect.value = existingData.province;
            
            // Manually populate cities for this province
            if (existingData.province && window.provinceCityData && window.provinceCityData[existingData.province]) {
                citySelect.innerHTML = '<option value="">Pilih Kota</option>';
                
                window.provinceCityData[existingData.province].forEach(city => {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;
                    citySelect.appendChild(option);
                });
                
                citySelect.disabled = false;
                
                // Set city value after options are populated
                if (existingData.city) {
                    setTimeout(() => {
                        citySelect.value = existingData.city;
                        console.log('City value set to:', citySelect.value);
                        console.log('Expected city:', existingData.city);
                    }, 50);
                }
            }
        }

        // Show existing legal documents info (file uploads can't be pre-filled for security reasons)
        console.log('Checking legal documents...', existingData.legal_documents);
        
        if (existingData.legal_documents) {
            // Parse legal_documents if it's a JSON string
            let legalDocs = existingData.legal_documents;
            console.log('Legal docs type:', typeof legalDocs);
            console.log('Legal docs value:', legalDocs);
            
            if (typeof legalDocs === 'string') {
                try {
                    legalDocs = JSON.parse(legalDocs);
                    console.log('Parsed legal docs:', legalDocs);
                } catch (e) {
                    console.log('Failed to parse legal docs:', e);
                    legalDocs = [];
                }
            }
            
            console.log('Is array?', Array.isArray(legalDocs));
            console.log('Length:', legalDocs?.length);
            
            if (Array.isArray(legalDocs) && legalDocs.length > 0) {
                const fileInput = document.querySelector('input[name="legal_documents[]"]');
                console.log('File input found:', fileInput);
                
                if (fileInput) {
                    // Find parent form-group instead of .mb-6
                    const fileContainer = fileInput.closest('.form-group');
                    console.log('File container found:', fileContainer);
                    
                    if (fileContainer) {
                        // Remove old info if exists
                        const oldInfo = fileContainer.querySelector('.existing-files-info');
                        if (oldInfo) {
                            console.log('Removing old info');
                            oldInfo.remove();
                        }
                        
                        // Create info message about existing files
                        const existingFilesInfo = document.createElement('div');
                        existingFilesInfo.className = 'mt-3 p-4 bg-blue-50 border border-blue-200 rounded-lg existing-files-info';
                        existingFilesInfo.innerHTML = `
                            <p class="text-sm text-blue-800 font-semibold mb-2">
                                <i class="fas fa-file-check mr-2"></i>Dokumen yang sudah diupload:
                            </p>
                            <ul class="text-sm text-blue-700 space-y-1 mb-2">
                                ${legalDocs.map(doc => {
                                    const fileName = doc.split('/').pop();
                                    return `<li class="flex items-center">
                                        <i class="fas fa-paperclip mr-2 text-blue-500"></i>
                                        <span>${fileName}</span>
                                    </li>`;
                                }).join('')}
                            </ul>
                            <p class="text-xs text-blue-600 italic">
                                <i class="fas fa-info-circle mr-1"></i>
                                Upload file baru jika ingin mengganti dokumen yang sudah ada.
                            </p>
                        `;
                        
                        fileContainer.appendChild(existingFilesInfo);
                        console.log('Legal documents info added successfully');
                    }
                }
            } else {
                console.log('No legal documents to display (empty or null)');
            }
        } else {
            console.log('No legal_documents field in existingData');
        }
    }

    // Function to close modal and enable edit
    function closeModal() {
        const modal = document.getElementById('alreadyRegisteredModal');
        modal.classList.remove('active');
        
        // Remove disabled class from form
        const formContainer = document.querySelector('.bg-white.rounded-2xl');
        formContainer.classList.remove('form-disabled');
        
        // Populate form with existing data
        populateForm();
        
        // Scroll to form
        document.querySelector('form').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Close modal when clicking outside
    document.getElementById('alreadyRegisteredModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
    @endif

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

        // Province-City Dependent Dropdown
        window.provinceCityData = @json(config('indonesia.cities'));
        const provinceSelect = document.getElementById('province-select');
        const citySelect = document.getElementById('city-select');
        const oldCity = '{{ old("city") }}';
        const oldProvince = '{{ old("province") }}';

        // Function to update cities based on selected province
        function updateCities(province) {
            // Clear current options
            citySelect.innerHTML = '<option value="">Pilih Kota</option>';
            
            if (province && window.provinceCityData[province]) {
                // Add cities for selected province
                window.provinceCityData[province].forEach(city => {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;
                    // Restore old value if exists
                    if (city === oldCity) {
                        option.selected = true;
                    }
                    citySelect.appendChild(option);
                });
                citySelect.disabled = false;
            } else {
                citySelect.innerHTML = '<option value="">Pilih provinsi terlebih dahulu</option>';
                citySelect.disabled = true;
            }
        }

        // Event listener for province change
        provinceSelect.addEventListener('change', function() {
            updateCities(this.value);
        });

        // Initialize cities on page load if province is already selected
        if (oldProvince) {
            updateCities(oldProvince);
        }
    });
</script>
@endpush
