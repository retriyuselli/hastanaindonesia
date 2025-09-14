@extends('layouts.app')

@section('title', 'Detail Artikel - HASTANA Indonesia')
@section('description', 'Baca artikel lengkap dari HASTANA Indonesia tentang tips, tren, dan panduan untuk wedding organizer profesional.')

@push('styles')
<style>
    .article-content {
        line-height: 1.8;
    }
    
    .article-content h2 {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 2rem 0 1rem 0;
        color: #1f2937;
    }
    
    .article-content h3 {
        font-size: 1.25rem;
        font-weight: bold;
        margin: 1.5rem 0 1rem 0;
        color: #374151;
    }
    
    .article-content p {
        margin-bottom: 1.5rem;
        color: #4b5563;
    }
    
    .article-content ul, .article-content ol {
        margin: 1.5rem 0;
        padding-left: 2rem;
    }
    
    .article-content li {
        margin-bottom: 0.5rem;
        color: #4b5563;
    }
    
    .article-content blockquote {
        border-left: 4px solid #3b82f6;
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: #6b7280;
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 0.5rem;
    }
    
    .share-buttons a {
        transition: all 0.3s ease;
    }
    
    .share-buttons a:hover {
        transform: translateY(-2px);
    }
    
    .related-article {
        transition: all 0.3s ease;
    }
    
    .related-article:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-red-900 via-red-800 to-blue-800 py-16 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <a href="{{ route('blog') }}" class="inline-flex items-center text-white/80 hover:text-white mb-4 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Blog
            </a>
        </div>
        
        @if($slug == 'digital-transformation-wedding-organizer-2025')
        <h1 class="font-poppins text-3xl md:text-5xl font-bold mb-6 leading-tight text-center">
            Digital Transformation dalam Industri Wedding Organizer 2025
        </h1>
        <div class="flex items-center justify-center gap-6 text-white/80">
            <div class="flex items-center">
                <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=40&h=40&fit=crop&crop=face&auto=format" alt="Sarah Putri" class="w-10 h-10 rounded-full mr-3">
                <span>Sarah Putri</span>
            </div>
            <span>•</span>
            <span>15 min read</span>
            <span>•</span>
            <span>14 Sep 2025</span>
        </div>
        @elseif($slug == 'tips-mengelola-budget-wedding-klien')
        <h1 class="font-poppins text-3xl md:text-5xl font-bold mb-6 leading-tight text-center">
            10 Tips Mengelola Budget Wedding untuk Klien
        </h1>
        <div class="flex items-center justify-center gap-6 text-white/80">
            <div class="flex items-center">
                <img src="https://images.unsplash.com/photo-1566492031773-4f4e44671d66?w=40&h=40&fit=crop&crop=face&auto=format" alt="Budi Santoso" class="w-10 h-10 rounded-full mr-3">
                <span>Budi Santoso</span>
            </div>
            <span>•</span>
            <span>8 min read</span>
            <span>•</span>
            <span>5 Jan 2025</span>
        </div>
        @elseif($slug == 'tren-pernikahan-2025-sustainable-wedding')
        <h1 class="font-poppins text-3xl md:text-5xl font-bold mb-6 leading-tight text-center">
            Tren Pernikahan 2025: Sustainable Wedding
        </h1>
        <div class="flex items-center justify-center gap-6 text-white/80">
            <div class="flex items-center">
                <img src="https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=40&h=40&fit=crop&crop=face&auto=format" alt="Maya Sari" class="w-10 h-10 rounded-full mr-3">
                <span>Maya Sari</span>
            </div>
            <span>•</span>
            <span>12 min read</span>
            <span>•</span>
            <span>3 Jan 2025</span>
        </div>
        @else
        <h1 class="font-poppins text-3xl md:text-5xl font-bold mb-6 leading-tight text-center">
            Artikel HASTANA Indonesia
        </h1>
        <div class="flex items-center justify-center gap-6 text-white/80">
            <span>Artikel & Tips Wedding Organizer</span>
        </div>
        @endif
    </div>
</section>

<!-- Article Content -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($slug == 'digital-transformation-wedding-organizer-2025')
        <!-- Featured Image -->
        <div class="mb-12">
            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=450&fit=crop&auto=format" alt="Digital Wedding Transformation" class="w-full h-64 md:h-96 object-cover rounded-2xl shadow-lg">
        </div>
        
        <!-- Article Content -->
        <div class="article-content">
            <p class="text-xl text-gray-600 mb-8 font-medium">
                Industri wedding organizer mengalami transformasi digital yang signifikan. Teknologi AI, Virtual Reality, dan platform digital kini mengubah cara wedding organizer bekerja dan berinteraksi dengan klien mereka.
            </p>
            
            <h2>Perkembangan Teknologi dalam Wedding Industry</h2>
            <p>
                Tahun 2025 menandai era baru dalam industri pernikahan di Indonesia. Wedding organizer kini tidak hanya mengandalkan cara tradisional dalam merencanakan pernikahan, tetapi juga memanfaatkan teknologi canggih untuk memberikan pengalaman yang lebih personal dan efisien.
            </p>
            
            <p>
                Beberapa teknologi yang mulai diadopsi antara lain Virtual Reality untuk venue preview, AI untuk rekomendasi vendor, dan aplikasi mobile untuk koordinasi real-time dengan klien.
            </p>
            
            <h3>Virtual Reality (VR) untuk Preview Venue</h3>
            <p>
                VR memungkinkan calon pengantin untuk "mengunjungi" venue pernikahan tanpa harus datang secara fisik. Teknologi ini sangat membantu klien yang berada di luar kota atau memiliki keterbatasan waktu.
            </p>
            
            <ul>
                <li>Preview 360° dari berbagai sudut venue</li>
                <li>Simulasi dekorasi sesuai tema pernikahan</li>
                <li>Penghematan waktu dan biaya survey lokasi</li>
                <li>Dokumentasi digital yang dapat diakses kapan saja</li>
            </ul>
            
            <h3>Artificial Intelligence untuk Rekomendasi</h3>
            <p>
                AI dapat menganalisis preferensi klien berdasarkan data yang dikumpulkan dan memberikan rekomendasi vendor, menu, hingga dekorasi yang sesuai dengan budget dan selera mereka.
            </p>
            
            <blockquote>
                "Dengan AI, kami dapat memberikan rekomendasi yang lebih akurat dan personal kepada setiap klien. Ini meningkatkan kepuasan klien hingga 40%." - Sarah Putri, Digital Strategy Expert
            </blockquote>
            
            <h2>Platform Digital untuk Koordinasi</h2>
            <p>
                Platform digital terintegrasi memungkinkan wedding organizer untuk mengelola seluruh aspek pernikahan dalam satu tempat. Mulai dari timeline, vendor management, hingga komunikasi dengan klien.
            </p>
            
            <h3>Keuntungan Platform Digital:</h3>
            <ol>
                <li><strong>Efisiensi Waktu:</strong> Semua informasi tersentralisasi dalam satu platform</li>
                <li><strong>Transparansi:</strong> Klien dapat melihat progress persiapan secara real-time</li>
                <li><strong>Collaboration:</strong> Tim dapat bekerja sama dengan lebih koordinatif</li>
                <li><strong>Documentation:</strong> Semua komunikasi dan keputusan terdokumentasi dengan baik</li>
            </ol>
            
            <h2>Strategi Adaptasi untuk Wedding Organizer</h2>
            <p>
                Untuk dapat bersaing di era digital ini, wedding organizer perlu melakukan adaptasi dengan strategi yang tepat:
            </p>
            
            <h3>1. Investasi dalam Teknologi</h3>
            <p>
                Mulai dengan tools dasar seperti project management software, kemudian berkembang ke teknologi yang lebih canggih seperti VR dan AI sesuai dengan kapasitas bisnis.
            </p>
            
            <h3>2. Pelatihan Tim</h3>
            <p>
                Pastikan seluruh tim memahami dan dapat mengoperasikan teknologi baru. Investasi dalam training akan memberikan ROI yang signifikan dalam jangka panjang.
            </p>
            
            <h3>3. Gradual Implementation</h3>
            <p>
                Implementasi teknologi tidak harus sekaligus. Lakukan secara bertahap, mulai dari yang paling urgent dan memberikan impact terbesar.
            </p>
            
            <h2>Masa Depan Wedding Organizer</h2>
            <p>
                Transformasi digital bukan lagi pilihan, tetapi kebutuhan. Wedding organizer yang dapat beradaptasi dengan teknologi akan memiliki competitive advantage yang signifikan di masa depan.
            </p>
            
            <p>
                Dengan memanfaatkan teknologi, wedding organizer dapat fokus pada aspek kreatif dan personal touch yang tidak dapat digantikan oleh teknologi, sambil meningkatkan efisiensi operasional.
            </p>
        </div>
        
        @elseif($slug == 'tips-mengelola-budget-wedding-klien')
        <!-- Featured Image -->
        <div class="mb-12">
            <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=800&h=450&fit=crop&auto=format" alt="Wedding Budget Management" class="w-full h-64 md:h-96 object-cover rounded-2xl shadow-lg">
        </div>
        
        <!-- Article Content -->
        <div class="article-content">
            <p class="text-xl text-gray-600 mb-8 font-medium">
                Mengelola budget pernikahan adalah salah satu tantangan terbesar yang dihadapi wedding organizer. Berikut 10 tips efektif untuk membantu klien mengoptimalkan budget tanpa mengurangi kualitas pernikahan impian mereka.
            </p>
            
            <h2>1. Buat Budget Breakdown yang Detail</h2>
            <p>
                Mulai dengan membuat breakdown budget yang sangat detail untuk setiap kategori pengeluaran. Ini membantu klien memahami kemana saja uang mereka akan dialokasikan.
            </p>
            
            <h3>Kategori Utama Budget Wedding:</h3>
            <ul>
                <li>Venue (30-40% dari total budget)</li>
                <li>Catering (20-30%)</li>
                <li>Photography & Videography (10-15%)</li>
                <li>Dekorasi & Flowers (8-12%)</li>
                <li>Entertainment & Music (5-10%)</li>
                <li>Wedding Dress & Attire (5-8%)</li>
                <li>Transportation (3-5%)</li>
                <li>Emergency Fund (5-10%)</li>
            </ul>
            
            <h2>2. Tentukan Prioritas Bersama Klien</h2>
            <p>
                Setiap pasangan memiliki prioritas yang berbeda. Ada yang mementingkan foto pernikahan, ada yang fokus pada venue mewah, atau entertainment yang spektakuler.
            </p>
            
            <blockquote>
                "Pahami apa yang paling penting bagi klien, lalu alokasikan budget lebih besar untuk hal tersebut sambil mencari cara berhemat di area lain."
            </blockquote>
            
            <h2>3. Manfaatkan Off-Peak Season</h2>
            <p>
                Jadwalkan pernikahan di waktu yang tidak peak (misalnya hari kerja, bulan puasa, atau musim hujan) untuk mendapatkan harga yang lebih kompetitif dari vendor.
            </p>
            
            <h2>4. Negosiasi Package Deal</h2>
            <p>
                Nego package deal dengan vendor untuk mendapatkan harga yang lebih baik. Banyak vendor bersedia memberikan diskon jika mengambil beberapa service sekaligus.
            </p>
            
            <h2>5. DIY untuk Detail Kecil</h2>
            <p>
                Ajak klien untuk DIY beberapa item seperti wedding favors, place cards, atau dekorasi minor yang bisa menghemat budget signifikan.
            </p>
            
            <h2>6. Vendor Alternatif</h2>
            <p>
                Selalu siapkan 2-3 opsi vendor untuk setiap kategori dengan range harga yang berbeda. Ini memberikan fleksibilitas dalam penyesuaian budget.
            </p>
            
            <h2>7. Digital Invitation</h2>
            <p>
                Pertimbangkan digital invitation untuk menghemat biaya cetak dan pos, terutama untuk undangan save the date atau info tambahan.
            </p>
            
            <h2>8. Sewa vs Beli</h2>
            <p>
                Evaluasi mana yang lebih cost-effective antara sewa atau beli untuk item seperti dekorasi, accessories, atau bahkan gaun pengantin.
            </p>
            
            <h2>9. Track Pengeluaran Real-time</h2>
            <p>
                Gunakan spreadsheet atau aplikasi khusus untuk tracking pengeluaran secara real-time agar tidak over budget.
            </p>
            
            <h2>10. Buffer untuk Pengeluaran Tak Terduga</h2>
            <p>
                Selalu sisakan 10-15% dari total budget untuk pengeluaran tak terduga atau last-minute changes yang sering terjadi.
            </p>
            
            <h2>Template Budget Planner Gratis</h2>
            <p>
                Kami menyediakan template Excel budget planner yang dapat didownload gratis. Template ini mencakup semua kategori pengeluaran dan formula otomatis untuk tracking.
            </p>
            
            <p>
                Dengan mengikuti tips di atas, wedding organizer dapat membantu klien menciptakan pernikahan impian mereka tanpa stress finansial yang berlebihan.
            </p>
        </div>
        
        @else
        <!-- Default Content -->
        <div class="text-center py-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Artikel Sedang Dalam Pengembangan</h2>
            <p class="text-gray-600 mb-8">Artikel ini sedang dalam proses penulisan. Silakan kembali lagi nanti untuk membaca konten lengkapnya.</p>
            <a href="{{ route('blog') }}" class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition-colors">
                Kembali ke Blog
            </a>
        </div>
        @endif
        
        <!-- Share Buttons -->
        <div class="border-t border-gray-200 pt-8 mt-12">
            <h3 class="text-lg font-semibold mb-4">Share Artikel Ini:</h3>
            <div class="share-buttons flex gap-4">
                <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fab fa-facebook-f mr-2"></i>Facebook
                </a>
                <a href="#" class="bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition-colors">
                    <i class="fab fa-twitter mr-2"></i>Twitter
                </a>
                <a href="#" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors">
                    <i class="fab fa-linkedin-in mr-2"></i>LinkedIn
                </a>
                <a href="#" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Related Articles -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Artikel Terkait</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Related Article 1 -->
            <div class="related-article bg-white rounded-2xl shadow-lg overflow-hidden">
                <img src="https://images.unsplash.com/photo-1469371670807-013ccf25f16a?w=300&h=200&fit=crop&auto=format" alt="Sustainable Wedding" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-2">Tren Pernikahan 2025: Sustainable Wedding</h3>
                    <p class="text-gray-600 text-sm mb-4">Eco-friendly wedding menjadi tren utama 2025. Panduan lengkap mengorganisir pernikahan ramah lingkungan...</p>
                    <a href="{{ route('blog.detail', ['slug' => 'tren-pernikahan-2025-sustainable-wedding']) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                        Baca Selengkapnya →
                    </a>
                </div>
            </div>
            
            <!-- Related Article 2 -->
            <div class="related-article bg-white rounded-2xl shadow-lg overflow-hidden">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=300&h=200&fit=crop&auto=format" alt="Marketing Strategy" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-2">Strategi Marketing Digital untuk WO Pemula</h3>
                    <p class="text-gray-600 text-sm mb-4">Panduan step-by-step membangun presence digital yang kuat untuk wedding organizer...</p>
                    <a href="{{ route('blog.detail', ['slug' => 'strategi-marketing-digital-wo-pemula']) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                        Baca Selengkapnya →
                    </a>
                </div>
            </div>
            
            <!-- Related Article 3 -->
            <div class="related-article bg-white rounded-2xl shadow-lg overflow-hidden">
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=300&h=200&fit=crop&auto=format" alt="Wedding Technology" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-2">5 Aplikasi Wajib untuk Wedding Organizer</h3>
                    <p class="text-gray-600 text-sm mb-4">Tools digital yang dapat meningkatkan efisiensi kerja dan memberikan pengalaman terbaik...</p>
                    <a href="{{ route('blog.detail', ['slug' => '5-aplikasi-wajib-wedding-organizer']) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                        Baca Selengkapnya →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-red-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-6">Ingin Membaca Artikel Lainnya?</h2>
        <p class="text-xl mb-8 opacity-90">
            Jelajahi koleksi lengkap artikel dan tips dari HASTANA Indonesia
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('blog') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-arrow-left mr-3"></i>
                Kembali ke Blog
            </a>
            <a href="{{ route('join') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-bold rounded-full hover:bg-white hover:text-blue-600 transition-all duration-300">
                <i class="fas fa-user-plus mr-3"></i>
                Bergabung HASTANA
            </a>
        </div>
    </div>
</section>

@endsection
