@extends('layouts.app')

@section('title', 'Syarat dan Ketentuan - HASTANA Indonesia')
@section('description', 'Syarat dan ketentuan keanggotaan Himpunan Perusahaan Penata Acara Seluruh Indonesia (HASTANA). Pahami hak dan kewajiban sebagai anggota.')

@push('styles')
<style>
    .terms-section {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 1rem;
        border-left: 4px solid #1e40af;
    }
    
    .terms-section h3 {
        color: #1e40af;
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 1.25rem;
    }
    
    .terms-section ol, .terms-section ul {
        margin-left: 1.5rem;
    }
    
    .terms-section li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }
    
    .highlight-box {
        background: linear-gradient(135deg, #dbeafe 0%, #fef3c7 100%);
        border: 2px solid #3b82f6;
        border-radius: 1rem;
        padding: 1.5rem;
        margin: 2rem 0;
    }
    
    .warning-box {
        background: linear-gradient(135deg, #fef2f2 0%, #fef3c7 100%);
        border: 2px solid #dc2626;
        border-radius: 1rem;
        padding: 1.5rem;
        margin: 2rem 0;
    }
    
    .table-of-contents {
        background: #ffffff;
        border: 2px solid #e5e7eb;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .table-of-contents a {
        display: block;
        padding: 0.5rem 0;
        color: #1e40af;
        text-decoration: none;
        border-bottom: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .table-of-contents a:hover {
        color: #dc2626;
        padding-left: 1rem;
    }
    
    .table-of-contents a:last-child {
        border-bottom: none;
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-900 via-blue-800 to-red-800 py-20 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                    <i class="fas fa-file-contract text-white text-3xl"></i>
                </div>
            </div>
            
            <h1 class="font-poppins text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Syarat dan <span class="text-yellow-300">Ketentuan</span>
            </h1>
            
            <p class="text-xl md:text-2xl mb-8 leading-relaxed opacity-90">
                Himpunan Perusahaan Penata Acara Seluruh Indonesia (HASTANA)
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
        
        <!-- Table of Contents -->
        <div class="table-of-contents">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                <i class="fas fa-list text-blue-600 mr-3"></i>
                Daftar Isi
            </h2>
            <a href="#ketentuan-umum">1. Ketentuan Umum</a>
            <a href="#definisi">2. Definisi</a>
            <a href="#syarat-keanggotaan">3. Syarat Keanggotaan</a>
            <a href="#hak-anggota">4. Hak Anggota</a>
            <a href="#kewajiban-anggota">5. Kewajiban Anggota</a>
            <a href="#biaya-keanggotaan">6. Biaya Keanggotaan</a>
            <a href="#kode-etik">7. Kode Etik</a>
            <a href="#sanksi">8. Sanksi dan Pelanggaran</a>
            <a href="#pembatalan">9. Pembatalan Keanggotaan</a>
            <a href="#privasi">10. Kebijakan Privasi</a>
            <a href="#perubahan">11. Perubahan Ketentuan</a>
            <a href="#kontak">12. Kontak</a>
        </div>

        <!-- Ketentuan Umum -->
        <div id="ketentuan-umum" class="terms-section">
            <h3><i class="fas fa-info-circle mr-2"></i>1. Ketentuan Umum</h3>
            <p class="mb-4">
                Dengan mendaftar sebagai anggota Himpunan Perusahaan Penata Acara Seluruh Indonesia (HASTANA), 
                Anda menyatakan telah membaca, memahami, dan menyetujui untuk terikat dengan syarat dan ketentuan 
                yang tercantum dalam dokumen ini.
            </p>
            <ul>
                <li>Syarat dan ketentuan ini berlaku untuk semua jenis keanggotaan HASTANA</li>
                <li>Perjanjian ini mulai berlaku sejak tanggal persetujuan pendaftaran</li>
                <li>HASTANA berhak mengubah syarat dan ketentuan dengan pemberitahuan 30 hari sebelumnya</li>
                <li>Anggota yang tidak menyetujui perubahan dapat mengajukan pembatalan keanggotaan</li>
            </ul>
        </div>

        <!-- Definisi -->
        <div id="definisi" class="terms-section">
            <h3><i class="fas fa-book mr-2"></i>2. Definisi</h3>
            <ul>
                <li><strong>HASTANA:</strong> Himpunan Perusahaan Penata Acara Seluruh Indonesia</li>
                <li><strong>Anggota:</strong> Perusahaan atau individu yang telah terdaftar resmi sebagai anggota HASTANA</li>
                <li><strong>Wedding Organizer (WO):</strong> Perusahaan yang bergerak di bidang penyelenggaraan acara pernikahan</li>
                <li><strong>Sertifikasi:</strong> Pengakuan resmi dari HASTANA atas kompetensi dan kredibilitas anggota</li>
                <li><strong>Platform:</strong> Sistem digital HASTANA termasuk website, aplikasi, dan layanan online</li>
                <li><strong>Event HASTANA:</strong> Kegiatan resmi yang diselenggarakan oleh organisasi</li>
            </ul>
        </div>

        <!-- Syarat Keanggotaan -->
        <div id="syarat-keanggotaan" class="terms-section">
            <h3><i class="fas fa-user-check mr-2"></i>3. Syarat Keanggotaan</h3>
            <p class="mb-4">Untuk menjadi anggota HASTANA, calon anggota harus memenuhi persyaratan berikut:</p>
            
            <h4 class="font-semibold mb-2">Persyaratan Umum:</h4>
            <ol>
                <li>Memiliki perusahaan yang bergerak di bidang wedding organizer atau event organizer</li>
                <li>Memiliki izin usaha yang sah (SIUP, NIB, atau dokumen serupa)</li>
                <li>Telah beroperasi minimal 6 bulan</li>
                <li>Memiliki minimal 1 portfolio acara yang telah selesai dilaksanakan</li>
                <li>Berdomisili di wilayah Indonesia</li>
                <li>Bersedia mematuhi kode etik HASTANA</li>
            </ol>
            
            <h4 class="font-semibold mb-2 mt-4">Dokumen yang Diperlukan:</h4>
            <ul>
                <li>Fotokopi izin usaha yang masih berlaku</li>
                <li>NPWP perusahaan (jika ada)</li>
                <li>Portfolio minimal 3 acara</li>
                <li>Surat rekomendasi dari klien (minimal 2)</li>
                <li>Pas foto direktur/pemilik perusahaan</li>
                <li>Logo perusahaan dalam format digital</li>
            </ul>
        </div>

        <!-- Hak Anggota -->
        <div id="hak-anggota" class="terms-section">
            <h3><i class="fas fa-crown mr-2"></i>4. Hak Anggota</h3>
            <p class="mb-4">Setiap anggota HASTANA berhak mendapatkan:</p>
            
            <h4 class="font-semibold mb-2">Hak Umum (Semua Jenis Keanggotaan):</h4>
            <ul>
                <li>Sertifikat keanggotaan resmi HASTANA</li>
                <li>Akses ke direktori anggota untuk networking</li>
                <li>Informasi dan update industri wedding organizer</li>
                <li>Konsultasi dasar mengenai pengembangan bisnis</li>
                <li>Partisipasi dalam event dan kegiatan HASTANA</li>
                <li>Promosi melalui platform digital HASTANA</li>
            </ul>
            
            <h4 class="font-semibold mb-2 mt-4">Hak Khusus Berdasarkan Tipe Keanggotaan:</h4>
            <ul>
                <li><strong>Gold Member:</strong> Akses workshop eksklusif, listing prioritas, diskon vendor 10%</li>
                <li><strong>Platinum Member:</strong> Dedicated account manager, marketing premium, diskon vendor 20%</li>
            </ul>
        </div>

        <!-- Kewajiban Anggota -->
        <div id="kewajiban-anggota" class="terms-section">
            <h3><i class="fas fa-tasks mr-2"></i>5. Kewajiban Anggota</h3>
            <p class="mb-4">Setiap anggota HASTANA berkewajiban:</p>
            
            <ol>
                <li>Membayar iuran keanggotaan tepat waktu sesuai dengan jenis keanggotaan</li>
                <li>Mematuhi kode etik dan standar profesional HASTANA</li>
                <li>Memberikan informasi yang akurat dan terkini tentang perusahaan</li>
                <li>Melaporkan perubahan data perusahaan dalam waktu 30 hari</li>
                <li>Tidak melakukan tindakan yang merugikan reputasi HASTANA</li>
                <li>Berpartisipasi aktif dalam kegiatan organisasi</li>
                <li>Memberikan testimoni atau review yang jujur untuk sesama anggota</li>
                <li>Menjaga kerahasiaan informasi internal HASTANA</li>
                <li>Mendukung visi dan misi HASTANA dalam memajukan industri wedding organizer</li>
            </ol>
        </div>

        <div class="highlight-box">
            <h4 class="font-bold text-blue-800 mb-3">
                <i class="fas fa-lightbulb mr-2"></i>
                Penting untuk Diperhatikan
            </h4>
            <p class="text-blue-700">
                Keanggotaan HASTANA memberikan kredibilitas dan akses ke jaringan profesional, namun tidak menjamin 
                kesuksesan bisnis. Setiap anggota tetap bertanggung jawab penuh atas operasional dan kualitas layanan 
                perusahaannya masing-masing.
            </p>
        </div>

        <!-- Biaya Keanggotaan -->
        <div id="biaya-keanggotaan" class="terms-section">
            <h3><i class="fas fa-money-bill-wave mr-2"></i>6. Biaya Keanggotaan</h3>
            
            <h4 class="font-semibold mb-2">Struktur Biaya:</h4>
            <ul>
                <li><strong>Silver Member:</strong> Rp 500.000 per tahun</li>
                <li><strong>Gold Member:</strong> Rp 1.000.000 per tahun</li>
                <li><strong>Platinum Member:</strong> Rp 2.000.000 per tahun</li>
            </ul>
            
            <h4 class="font-semibold mb-2 mt-4">Ketentuan Pembayaran:</h4>
            <ol>
                <li>Pembayaran dilakukan di muka untuk periode 1 tahun</li>
                <li>Tidak ada pengembalian biaya keanggotaan kecuali dalam kondisi tertentu</li>
                <li>Telat pembayaran lebih dari 60 hari akan mengakibatkan suspend keanggotaan</li>
                <li>Perpanjangan keanggotaan harus dilakukan maksimal 30 hari sebelum expired</li>
                <li>Upgrade keanggotaan dapat dilakukan kapan saja dengan membayar selisih biaya</li>
            </ol>
        </div>

        <!-- Kode Etik -->
        <div id="kode-etik" class="terms-section">
            <h3><i class="fas fa-heart mr-2"></i>7. Kode Etik</h3>
            <p class="mb-4">Setiap anggota HASTANA wajib mematuhi kode etik berikut:</p>
            
            <h4 class="font-semibold mb-2">Profesionalisme:</h4>
            <ul>
                <li>Memberikan layanan terbaik dengan standar kualitas tinggi</li>
                <li>Menepati janji dan komitmen kepada klien</li>
                <li>Bersikap jujur dalam promosi dan marketing</li>
                <li>Menggunakan kontrak yang jelas dan adil</li>
            </ul>
            
            <h4 class="font-semibold mb-2 mt-4">Kolaborasi:</h4>
            <ul>
                <li>Tidak melakukan praktik persaingan tidak sehat</li>
                <li>Saling mendukung sesama anggota HASTANA</li>
                <li>Berbagi informasi dan pengetahuan untuk kemajuan bersama</li>
                <li>Tidak mengambil klien sesama anggota dengan cara tidak etis</li>
            </ul>
            
            <h4 class="font-semibold mb-2 mt-4">Integritas:</h4>
            <ul>
                <li>Tidak terlibat dalam praktik korupsi atau suap</li>
                <li>Menghormati hak cipta dan kekayaan intelektual</li>
                <li>Menjaga kerahasiaan informasi klien</li>
                <li>Bertanggung jawab atas keputusan dan tindakan bisnis</li>
            </ul>
        </div>

        <!-- Sanksi -->
        <div id="sanksi" class="terms-section">
            <h3><i class="fas fa-exclamation-triangle mr-2"></i>8. Sanksi dan Pelanggaran</h3>
            
            <h4 class="font-semibold mb-2">Jenis Pelanggaran:</h4>
            <ul>
                <li><strong>Ringan:</strong> Telat pembayaran iuran, ketidakhadiran dalam event wajib</li>
                <li><strong>Sedang:</strong> Pelanggaran kode etik, memberikan informasi palsu</li>
                <li><strong>Berat:</strong> Tindakan kriminal, merugikan reputasi HASTANA secara signifikan</li>
            </ul>
            
            <h4 class="font-semibold mb-2 mt-4">Jenis Sanksi:</h4>
            <ol>
                <li><strong>Teguran Lisan:</strong> Untuk pelanggaran ringan pertama kali</li>
                <li><strong>Teguran Tertulis:</strong> Untuk pelanggaran ringan berulang</li>
                <li><strong>Skorsing Sementara:</strong> 1-6 bulan untuk pelanggaran sedang</li>
                <li><strong>Pemberhentian Keanggotaan:</strong> Untuk pelanggaran berat</li>
            </ol>
        </div>

        <div class="warning-box">
            <h4 class="font-bold text-red-800 mb-3">
                <i class="fas fa-shield-alt mr-2"></i>
                Mekanisme Pengaduan
            </h4>
            <p class="text-red-700 mb-3">
                Jika Anda mengalami masalah dengan sesama anggota atau ingin melaporkan pelanggaran kode etik, 
                silakan hubungi komite etik HASTANA melalui:
            </p>
            <ul class="text-red-700">
                <li>Email: etik@hastana.id</li>
                <li>Telepon: +62 21 1234 5678 ext. 3</li>
                <li>Form pengaduan online di website resmi</li>
            </ul>
        </div>

        <!-- Pembatalan Keanggotaan -->
        <div id="pembatalan" class="terms-section">
            <h3><i class="fas fa-user-times mr-2"></i>9. Pembatalan Keanggotaan</h3>
            
            <h4 class="font-semibold mb-2">Pembatalan oleh Anggota:</h4>
            <ul>
                <li>Dapat dilakukan kapan saja dengan pemberitahuan tertulis 30 hari sebelumnya</li>
                <li>Tidak ada pengembalian biaya keanggotaan yang telah dibayar</li>
                <li>Semua hak dan fasilitas anggota akan dihentikan setelah tanggal efektif pembatalan</li>
                <li>Sertifikat keanggotaan harus dikembalikan atau dinyatakan tidak berlaku</li>
            </ul>
            
            <h4 class="font-semibold mb-2 mt-4">Pembatalan oleh HASTANA:</h4>
            <ul>
                <li>Karena pelanggaran berat atau berulang</li>
                <li>Ketidakmampuan membayar iuran selama lebih dari 3 bulan</li>
                <li>Penutupan atau likuidasi perusahaan anggota</li>
                <li>Perubahan bidang usaha yang tidak sesuai dengan tujuan HASTANA</li>
            </ul>
        </div>

        <!-- Kebijakan Privasi -->
        <div id="privasi" class="terms-section">
            <h3><i class="fas fa-user-shield mr-2"></i>10. Kebijakan Privasi</h3>
            <p class="mb-4">HASTANA berkomitmen melindungi privasi dan data pribadi anggota:</p>
            
            <ul>
                <li>Data pribadi anggota akan dijaga kerahasiaannya</li>
                <li>Informasi tidak akan dibagikan kepada pihak ketiga tanpa persetujuan</li>
                <li>Data hanya digunakan untuk kepentingan operasional HASTANA</li>
                <li>Anggota berhak meminta akses, koreksi, atau penghapusan data pribadi</li>
                <li>HASTANA menggunakan teknologi keamanan untuk melindungi database</li>
                <li>Dalam direktori publik, hanya informasi bisnis yang ditampilkan</li>
            </ul>
        </div>

        <!-- Perubahan Ketentuan -->
        <div id="perubahan" class="terms-section">
            <h3><i class="fas fa-edit mr-2"></i>11. Perubahan Ketentuan</h3>
            <p class="mb-4">HASTANA berhak mengubah syarat dan ketentuan dengan prosedur sebagai berikut:</p>
            
            <ol>
                <li>Pemberitahuan perubahan akan dikirim kepada semua anggota</li>
                <li>Masa konsultasi publik selama 30 hari untuk masukan anggota</li>
                <li>Perubahan akan efektif 30 hari setelah pemberitahuan resmi</li>
                <li>Anggota yang tidak setuju dapat mengajukan pembatalan keanggotaan</li>
                <li>Versi terbaru akan selalu tersedia di website resmi HASTANA</li>
            </ol>
        </div>

        <!-- Kontak -->
        <div id="kontak" class="terms-section">
            <h3><i class="fas fa-phone mr-2"></i>12. Kontak</h3>
            <p class="mb-4">Untuk pertanyaan terkait syarat dan ketentuan, silakan hubungi:</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold mb-2">Kantor Pusat:</h4>
                    <p>Jl. Wedding Organizer No. 123<br>
                    Jakarta Selatan 12345<br>
                    Indonesia</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">Kontak:</h4>
                    <p>Telepon: +62 21 1234 5678<br>
                    Email: legal@hastana.id<br>
                    Website: www.hastana.id</p>
                </div>
            </div>
        </div>

        <!-- Footer Terms -->
        <div class="bg-gray-100 rounded-xl p-6 mt-8 text-center">
            <p class="text-gray-600 mb-4">
                <strong>Dokumen ini merupakan bagian integral dari perjanjian keanggotaan HASTANA Indonesia.</strong>
            </p>
            <p class="text-sm text-gray-500">
                Dengan mendaftar sebagai anggota, Anda dianggap telah membaca, memahami, dan menyetujui 
                seluruh isi syarat dan ketentuan ini.
            </p>
            <div class="mt-4 text-sm text-gray-500">
                <i class="fas fa-calendar mr-2"></i>
                Efektif berlaku: 13 September 2025
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-12">
            <a href="{{ route('privacy') }}" class="inline-flex items-center px-6 py-3 border-2 border-green-600 text-green-600 font-semibold rounded-full hover:bg-green-600 hover:text-white transition-all duration-300">
                <i class="fas fa-user-shield mr-2"></i>
                Kebijakan Privasi
            </a>
            <a href="{{ route('join') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-red-600 text-white font-bold rounded-full hover:from-blue-700 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-arrow-left mr-3"></i>
                Kembali ke Halaman Pendaftaran
            </a>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    // Smooth scrolling for table of contents
    document.addEventListener('DOMContentLoaded', function() {
        const tocLinks = document.querySelectorAll('.table-of-contents a');
        
        tocLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Highlight the target section temporarily
                    targetElement.style.backgroundColor = '#dbeafe';
                    setTimeout(() => {
                        targetElement.style.backgroundColor = '';
                    }, 2000);
                }
            });
        });

        // Add scroll spy functionality
        const sections = document.querySelectorAll('.terms-section');
        const navLinks = document.querySelectorAll('.table-of-contents a');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (scrollY >= sectionTop - 60) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('font-bold');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('font-bold');
                }
            });
        });
    });
</script>
@endpush
