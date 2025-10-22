@extends('layouts.app')

@section('title', 'Kontak - HASTANA Indonesia')
@section('description', 'Hubungi HASTANA Indonesia untuk informasi keanggotaan, kerjasama, atau pertanyaan seputar wedding organizer.')

@push('styles')
<style>
    .contact-card {
        transition: all 0.3s ease;
    }
    
    .contact-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .contact-form {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-red-900 via-red-800 to-blue-800 py-20 text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                    <i class="fas fa-envelope text-white text-3xl"></i>
                </div>
            </div>
            
            <h1 class="font-poppins text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Hubungi <span class="text-yellow-300">Kami</span>
            </h1>
            
            <p class="text-xl md:text-2xl mb-8 leading-relaxed opacity-90">
                Kami Siap Membantu Pengembangan Bisnis Wedding Organizer Anda
            </p>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Informasi Kontak</h2>
            <p class="text-lg text-gray-600">Berbagai cara untuk menghubungi tim HASTANA Indonesia</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- Phone -->
            <div class="contact-card bg-white p-8 rounded-2xl shadow-lg text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-phone text-blue-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-3">Telepon</h3>
                <p class="text-gray-600 mb-4">Hubungi kami langsung</p>
                <a href="tel:+622112345678" class="text-blue-600 font-semibold hover:underline">
                    +62 21 1234 5678
                </a>
                <p class="text-sm text-gray-500 mt-2">Senin-Jumat, 09:00-17:00 WIB</p>
            </div>
            
            <!-- Email -->
            <div class="contact-card bg-white p-8 rounded-2xl shadow-lg text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-envelope text-green-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-3">Email</h3>
                <p class="text-gray-600 mb-4">Kirim email ke kami</p>
                <a href="mailto:info@hastana.id" class="text-green-600 font-semibold hover:underline">
                    info@hastana.id
                </a>
                <p class="text-sm text-gray-500 mt-2">Respon dalam 24 jam</p>
            </div>
            
            <!-- WhatsApp -->
            <div class="contact-card bg-white p-8 rounded-2xl shadow-lg text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fab fa-whatsapp text-green-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-3">WhatsApp</h3>
                <p class="text-gray-600 mb-4">Chat langsung dengan kami</p>
                <a href="https://wa.me/6281234567890" class="text-green-600 font-semibold hover:underline">
                    +62 812 3456 7890
                </a>
                <p class="text-sm text-gray-500 mt-2">Online 24/7</p>
            </div>
            
            <!-- Office -->
            <div class="contact-card bg-white p-8 rounded-2xl shadow-lg text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-map-marker-alt text-red-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-3">Kantor</h3>
                <p class="text-gray-600 mb-4">Kunjungi kantor kami</p>
                <p class="text-red-600 font-semibold text-sm">
                    Jl. Wedding Organizer No. 123<br>
                    Jakarta Selatan 12345
                </p>
                <p class="text-sm text-gray-500 mt-2">Senin-Jumat, 09:00-17:00</p>
            </div>
            
        </div>
    </div>
</section>

<!-- Contact Form -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Kirim Pesan</h2>
            <p class="text-lg text-gray-600">Atau isi form di bawah ini untuk menghubungi kami</p>
        </div>
        
        <div class="contact-form rounded-2xl p-8">
            <form class="space-y-6">
                
                <!-- Name & Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                
                <!-- Phone & Company -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Perusahaan
                        </label>
                        <input type="text" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                
                <!-- Subject -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Subjek <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select required class="search-box w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
                            <option value="">Pilih subjek...</option>
                            <option value="membership">Informasi Keanggotaan</option>
                            <option value="partnership">Kerjasama & Partnership</option>
                            <option value="event">Event & Training</option>
                            <option value="complaint">Keluhan & Saran</option>
                            <option value="general">Pertanyaan Umum</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                </div>
                
                <!-- Message -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Pesan <span class="text-red-500">*</span>
                    </label>
                    <textarea rows="6" required placeholder="Tuliskan pesan atau pertanyaan Anda..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                </div>
                
                <!-- Submit Button -->
                <div class="text-center pt-4">
                    <button type="submit" 
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-red-600 text-white font-bold rounded-full hover:from-blue-700 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-paper-plane mr-3"></i>
                        Kirim Pesan
                    </button>
                </div>
                
            </form>
        </div>
    </div>
</section>

<!-- Map Section (Placeholder) -->
<section class="py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Lokasi Kantor</h2>
            <p class="text-lg text-gray-600">Temukan kantor pusat HASTANA Indonesia</p>
        </div>
        
        <div class="bg-gray-300 rounded-2xl h-96 flex items-center justify-center">
            <div class="text-center text-gray-600">
                <i class="fas fa-map-marked-alt text-4xl mb-4"></i>
                <p class="font-semibold">Google Maps akan ditampilkan di sini</p>
                <p class="text-sm">Jl. Wedding Organizer No. 123, Jakarta Selatan 12345</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-lg text-gray-600">Beberapa pertanyaan umum seputar HASTANA Indonesia</p>
        </div>
        
        <div class="space-y-6">
            
            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="font-bold text-lg mb-3">Bagaimana cara bergabung dengan HASTANA Indonesia?</h3>
                <p class="text-gray-600">
                    Anda dapat mendaftar melalui halaman "Bergabung" di website kami. Lengkapi formulir pendaftaran 
                    dan upload dokumen yang diperlukan. Tim kami akan menghubungi Anda dalam 3-5 hari kerja.
                </p>
            </div>
            
            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="font-bold text-lg mb-3">Berapa biaya keanggotaan HASTANA?</h3>
                <p class="text-gray-600">
                    Kami memiliki 3 tingkat keanggotaan: Silver (Rp 2.500.000/tahun), Gold (Rp 5.000.000/tahun), 
                    dan Platinum (Rp 10.000.000/tahun). Setiap tingkat memiliki benefit yang berbeda.
                </p>
            </div>
            
            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="font-bold text-lg mb-3">Apa saja benefit menjadi anggota HASTANA?</h3>
                <p class="text-gray-600">
                    Benefit meliputi sertifikasi profesional, akses training eksklusif, networking dengan sesama WO, 
                    promosi di platform kami, dukungan legal, dan masih banyak lagi.
                </p>
            </div>
            
            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="font-bold text-lg mb-3">Apakah ada training untuk anggota baru?</h3>
                <p class="text-gray-600">
                    Ya, kami menyediakan orientation program untuk anggota baru, termasuk workshop dasar 
                    wedding organizer dan pelatihan business development.
                </p>
            </div>
            
        </div>
        
        <div class="text-center mt-12">
            <p class="text-gray-600 mb-4">Masih ada pertanyaan lain?</p>
            <a href="#contact-form" class="text-blue-600 font-semibold hover:underline">
                Hubungi kami langsung
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission handling
        const contactForm = document.querySelector('form');
        
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simple form validation
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#ef4444';
                } else {
                    field.style.borderColor = '#d1d5db';
                }
            });
            
            if (isValid) {
                alert('Terima kasih! Pesan Anda telah dikirim. Tim kami akan menghubungi Anda segera.');
                this.reset();
            } else {
                alert('Mohon lengkapi semua field yang wajib diisi.');
            }
        });
    });
</script>
@endpush
