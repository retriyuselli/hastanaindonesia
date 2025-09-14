@extends('layouts.app')

@section('title', 'Kebijakan Privasi - HASTANA Indonesia')
@section('description', 'Kebijakan privasi dan perlindungan data pribadi anggota Himpunan Perusahaan Penata Acara Seluruh Indonesia (HASTANA).')

@push('styles')
<style>
    .privacy-section {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 1rem;
        border-left: 4px solid #dc2626;
    }
    
    .privacy-section h3 {
        color: #dc2626;
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 1.25rem;
    }
    
    .privacy-section ol, .privacy-section ul {
        margin-left: 1.5rem;
    }
    
    .privacy-section li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }
    
    .security-box {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border: 2px solid #10b981;
        border-radius: 1rem;
        padding: 1.5rem;
        margin: 2rem 0;
    }
    
    .rights-box {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 2px solid #3b82f6;
        border-radius: 1rem;
        padding: 1.5rem;
        margin: 2rem 0;
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-red-900 via-red-800 to-blue-800 py-20 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                    <i class="fas fa-user-shield text-white text-3xl"></i>
                </div>
            </div>
            
            <h1 class="font-poppins text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Kebijakan <span class="text-yellow-300">Privasi</span>
            </h1>
            
            <p class="text-xl md:text-2xl mb-8 leading-relaxed opacity-90">
                Perlindungan Data Pribadi Anggota HASTANA Indonesia
            </p>
            
            <div class="text-sm opacity-75">
                Terakhir diperbarui: 13 September 2025
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Introduction -->
        <div class="mb-12 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Komitmen Kami terhadap Privasi Anda</h2>
            <p class="text-lg text-gray-600 leading-relaxed">
                HASTANA Indonesia sangat menghargai kepercayaan yang Anda berikan kepada kami dengan membagikan 
                informasi pribadi Anda. Kebijakan privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, 
                melindungi, dan membagikan informasi Anda.
            </p>
        </div>

        <!-- Informasi yang Dikumpulkan -->
        <div class="privacy-section">
            <h3><i class="fas fa-database mr-2"></i>1. Informasi yang Kami Kumpulkan</h3>
            
            <h4 class="font-semibold mb-2">Informasi yang Anda Berikan:</h4>
            <ul>
                <li>Data identitas perusahaan (nama, alamat, nomor telepon, email)</li>
                <li>Informasi pemilik/direktur (nama, foto, kontak)</li>
                <li>Dokumen legal (SIUP, NIB, NPWP)</li>
                <li>Portfolio dan karya perusahaan</li>
                <li>Informasi keanggotaan dan preferensi</li>
                <li>Komunikasi dengan customer service kami</li>
            </ul>
            
            <h4 class="font-semibold mb-2 mt-4">Informasi yang Dikumpulkan Otomatis:</h4>
            <ul>
                <li>Alamat IP dan lokasi geografis</li>
                <li>Informasi perangkat dan browser</li>
                <li>Aktivitas penggunaan website dan platform</li>
                <li>Cookies dan teknologi pelacakan serupa</li>
                <li>Log aktivitas sistem</li>
            </ul>
        </div>

        <!-- Cara Penggunaan Data -->
        <div class="privacy-section">
            <h3><i class="fas fa-cogs mr-2"></i>2. Cara Kami Menggunakan Informasi Anda</h3>
            
            <h4 class="font-semibold mb-2">Tujuan Utama:</h4>
            <ol>
                <li>Memproses aplikasi keanggotaan dan verifikasi identitas</li>
                <li>Menyediakan layanan dan fasilitas anggota</li>
                <li>Komunikasi terkait keanggotaan dan event</li>
                <li>Menyusun direktori anggota dan platform networking</li>
                <li>Mengirimkan newsletter dan update industri</li>
                <li>Memproses pembayaran dan administrasi keuangan</li>
            </ol>
            
            <h4 class="font-semibold mb-2 mt-4">Tujuan Sekunder:</h4>
            <ul>
                <li>Analisis dan peningkatan layanan</li>
                <li>Riset pasar dan tren industri</li>
                <li>Marketing dan promosi (dengan persetujuan)</li>
                <li>Keamanan dan pencegahan fraud</li>
                <li>Pemenuhan kewajiban hukum</li>
            </ul>
        </div>

        <!-- Pembagian Informasi -->
        <div class="privacy-section">
            <h3><i class="fas fa-share-alt mr-2"></i>3. Pembagian Informasi dengan Pihak Ketiga</h3>
            
            <h4 class="font-semibold mb-2">Kami TIDAK akan membagikan informasi pribadi Anda, kecuali:</h4>
            <ul>
                <li><strong>Dengan persetujuan eksplisit:</strong> Untuk keperluan tertentu yang Anda setujui</li>
                <li><strong>Informasi publik:</strong> Data bisnis yang dipublikasikan di direktori anggota</li>
                <li><strong>Service providers:</strong> Vendor yang membantu operasional kami (dengan perjanjian kerahasiaan)</li>
                <li><strong>Kewajiban hukum:</strong> Jika diwajibkan oleh pengadilan atau otoritas berwenang</li>
                <li><strong>Keamanan:</strong> Untuk melindungi hak dan keselamatan anggota lain</li>
            </ul>
            
            <h4 class="font-semibold mb-2 mt-4">Partner Resmi:</h4>
            <p>Kami dapat berbagi informasi statistik anonim dengan partner bisnis untuk:</p>
            <ul>
                <li>Riset industri wedding organizer</li>
                <li>Pengembangan produk dan layanan baru</li>
                <li>Program kolaborasi yang menguntungkan anggota</li>
            </ul>
        </div>

        <div class="security-box">
            <h4 class="font-bold text-green-800 mb-3">
                <i class="fas fa-lock mr-2"></i>
                Keamanan Data Tingkat Tinggi
            </h4>
            <p class="text-green-700 mb-3">
                Kami menggunakan teknologi keamanan terdepan untuk melindungi data Anda:
            </p>
            <ul class="text-green-700">
                <li>Enkripsi SSL/TLS untuk transmisi data</li>
                <li>Enkripsi database dengan standar AES-256</li>
                <li>Autentikasi multi-faktor untuk akses admin</li>
                <li>Audit keamanan berkala oleh pihak ketiga</li>
                <li>Backup data otomatis dengan enkripsi</li>
            </ul>
        </div>

        <!-- Hak Anda -->
        <div class="privacy-section">
            <h3><i class="fas fa-user-check mr-2"></i>4. Hak Anda atas Data Pribadi</h3>
            
            <p class="mb-4">Sebagai pemilik data, Anda memiliki hak untuk:</p>
            
            <ol>
                <li><strong>Akses:</strong> Meminta salinan data pribadi yang kami simpan</li>
                <li><strong>Koreksi:</strong> Memperbarui atau memperbaiki data yang tidak akurat</li>
                <li><strong>Penghapusan:</strong> Meminta penghapusan data (dengan beberapa pengecualian)</li>
                <li><strong>Portabilitas:</strong> Meminta transfer data ke penyedia layanan lain</li>
                <li><strong>Pembatasan:</strong> Membatasi pemrosesan data untuk tujuan tertentu</li>
                <li><strong>Keberatan:</strong> Menolak pemrosesan data untuk marketing langsung</li>
                <li><strong>Penarikan persetujuan:</strong> Menarik persetujuan yang telah diberikan</li>
            </ol>
            
            <h4 class="font-semibold mb-2 mt-4">Cara Menggunakan Hak Anda:</h4>
            <p>Hubungi kami melalui email: privacy@hastana.id atau telepon: +62 21 1234 5678 ext. 2</p>
        </div>

        <!-- Retensi Data -->
        <div class="privacy-section">
            <h3><i class="fas fa-clock mr-2"></i>5. Penyimpanan dan Retensi Data</h3>
            
            <h4 class="font-semibold mb-2">Periode Penyimpanan:</h4>
            <ul>
                <li><strong>Data anggota aktif:</strong> Selama masa keanggotaan + 2 tahun</li>
                <li><strong>Data keuangan:</strong> 10 tahun sesuai peraturan perpajakan</li>
                <li><strong>Log sistem:</strong> 1 tahun untuk keperluan keamanan</li>
                <li><strong>Komunikasi:</strong> 3 tahun untuk referensi layanan pelanggan</li>
                <li><strong>Portfolio:</strong> Permanen (dapat dihapus atas permintaan)</li>
            </ul>
            
            <h4 class="font-semibold mb-2 mt-4">Penghapusan Data:</h4>
            <p>Data akan dihapus secara aman setelah periode retensi berakhir atau atas permintaan Anda, 
            kecuali jika ada kewajiban hukum untuk menyimpannya lebih lama.</p>
        </div>

        <!-- Cookies -->
        <div class="privacy-section">
            <h3><i class="fas fa-cookie-bite mr-2"></i>6. Penggunaan Cookies</h3>
            
            <h4 class="font-semibold mb-2">Jenis Cookies yang Kami Gunakan:</h4>
            <ul>
                <li><strong>Cookies esensial:</strong> Diperlukan untuk fungsi dasar website</li>
                <li><strong>Cookies performa:</strong> Menganalisis penggunaan website</li>
                <li><strong>Cookies fungsional:</strong> Mengingat preferensi Anda</li>
                <li><strong>Cookies marketing:</strong> Menampilkan konten yang relevan (opsional)</li>
            </ul>
            
            <h4 class="font-semibold mb-2 mt-4">Kontrol Cookies:</h4>
            <p>Anda dapat mengatur preferensi cookies melalui pengaturan browser atau panel preferensi 
            privasi di website kami. Menonaktifkan cookies tertentu dapat mempengaruhi fungsionalitas website.</p>
        </div>

        <!-- Transfer Internasional -->
        <div class="privacy-section">
            <h3><i class="fas fa-globe mr-2"></i>7. Transfer Data Internasional</h3>
            
            <p class="mb-4">
                Data Anda disimpan di server yang berlokasi di Indonesia. Dalam beberapa kasus, 
                kami mungkin menggunakan layanan cloud internasional yang telah memenuhi standar perlindungan data:
            </p>
            
            <ul>
                <li>Provider cloud bersertifikat SOC 2 Type II</li>
                <li>Perjanjian pemrosesan data (DPA) yang ketat</li>
                <li>Klausul kontrak standar untuk transfer internasional</li>
                <li>Enkripsi data saat transit dan saat disimpan</li>
            </ul>
        </div>

        <div class="rights-box">
            <h4 class="font-bold text-blue-800 mb-3">
                <i class="fas fa-info-circle mr-2"></i>
                Hak Anda sebagai Warga Negara Indonesia
            </h4>
            <p class="text-blue-700 mb-3">
                Sesuai dengan UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi, Anda memiliki hak-hak 
                khusus yang dilindungi oleh hukum Indonesia:
            </p>
            <ul class="text-blue-700">
                <li>Hak untuk mendapatkan informasi yang jelas tentang pemrosesan data</li>
                <li>Hak untuk memberikan atau menarik persetujuan</li>
                <li>Hak untuk mengakses dan memperoleh salinan data pribadi</li>
                <li>Hak untuk membenarkan atau memperbarui data pribadi</li>
                <li>Hak untuk meminta penghapusan data pribadi</li>
                <li>Hak untuk mengajukan keberatan atas pemrosesan data</li>
            </ul>
        </div>

        <!-- Perlindungan Anak -->
        <div class="privacy-section">
            <h3><i class="fas fa-child mr-2"></i>8. Perlindungan Data Anak</h3>
            
            <p class="mb-4">
                Layanan HASTANA ditujukan untuk pelaku bisnis dewasa. Kami tidak dengan sengaja mengumpulkan 
                data pribadi dari anak di bawah 18 tahun. Jika Anda mengetahui bahwa seorang anak telah 
                memberikan data pribadi kepada kami, silakan hubungi kami untuk penghapusan.
            </p>
        </div>

        <!-- Perubahan Kebijakan -->
        <div class="privacy-section">
            <h3><i class="fas fa-edit mr-2"></i>9. Perubahan Kebijakan Privasi</h3>
            
            <p class="mb-4">
                Kami dapat memperbarui kebijakan privasi ini dari waktu ke waktu. Perubahan material akan 
                dikomunikasikan melalui:
            </p>
            
            <ul>
                <li>Pemberitahuan email kepada anggota terdaftar</li>
                <li>Pengumuman di website resmi HASTANA</li>
                <li>Notifikasi saat login ke akun anggota</li>
            </ul>
            
            <p class="mt-4">
                Penggunaan layanan yang berkelanjutan setelah perubahan dianggap sebagai penerimaan 
                terhadap kebijakan privasi yang baru.
            </p>
        </div>

        <!-- Kontak -->
        <div class="privacy-section">
            <h3><i class="fas fa-envelope mr-2"></i>10. Hubungi Kami</h3>
            
            <p class="mb-4">
                Jika Anda memiliki pertanyaan, kekhawatiran, atau ingin menggunakan hak privasi Anda, 
                silakan hubungi Data Protection Officer kami:
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold mb-2">Email:</h4>
                    <p>privacy@hastana.id<br>
                    dpo@hastana.id</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">Telepon:</h4>
                    <p>+62 21 1234 5678 ext. 2<br>
                    (Senin-Jumat, 09:00-17:00 WIB)</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">Pos:</h4>
                    <p>Data Protection Officer<br>
                    HASTANA Indonesia<br>
                    Jl. Wedding Organizer No. 123<br>
                    Jakarta Selatan 12345</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">Response Time:</h4>
                    <p>Kami berkomitmen merespon<br>
                    dalam waktu maksimal<br>
                    30 hari kerja</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-100 rounded-xl p-6 mt-8 text-center">
            <p class="text-gray-600 mb-4">
                <strong>Privasi Anda adalah prioritas utama kami.</strong>
            </p>
            <p class="text-sm text-gray-500">
                Kebijakan privasi ini merupakan bagian integral dari syarat dan ketentuan layanan HASTANA Indonesia.
            </p>
            <div class="mt-4 text-sm text-gray-500">
                <i class="fas fa-calendar mr-2"></i>
                Efektif berlaku: 13 September 2025
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-12">
            <a href="{{ route('terms') }}" class="inline-flex items-center px-6 py-3 border-2 border-blue-600 text-blue-600 font-semibold rounded-full hover:bg-blue-600 hover:text-white transition-all duration-300">
                <i class="fas fa-file-contract mr-2"></i>
                Syarat dan Ketentuan
            </a>
            <a href="{{ route('join') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-red-600 text-white font-semibold rounded-full hover:from-blue-700 hover:to-red-700 transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Pendaftaran
            </a>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    // Smooth scrolling and highlight functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth scrolling for any anchor links
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

        // Highlight sections when scrolling
        const sections = document.querySelectorAll('.privacy-section');
        
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '-20% 0px -20% 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.transform = 'scale(1.02)';
                    entry.target.style.transition = 'transform 0.3s ease';
                    setTimeout(() => {
                        entry.target.style.transform = 'scale(1)';
                    }, 1000);
                }
            });
        }, observerOptions);

        sections.forEach(section => {
            observer.observe(section);
        });
    });
</script>
@endpush
