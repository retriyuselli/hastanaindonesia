@extends('layouts.app')

@section('title', 'Pelatihan Profesional - HASTANA Indonesia')
@section('description', 'Program pelatihan dan pengembangan kompetensi Wedding Organizer profesional oleh HASTANA Indonesia.')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-gray-900 via-gray-800 to-red-900 py-20 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                <i class="fas fa-chalkboard-teacher text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-4 leading-tight">
                Pelatihan <span class="text-red-400">Profesional</span>
            </h1>
            <p class="text-lg opacity-90 leading-relaxed">
                Tingkatkan kompetensi dan keahlian Anda melalui program pelatihan terstruktur bersama para ahli industri pernikahan
            </p>
        </div>
    </div>
</section>

<!-- Program Pelatihan -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Program Pelatihan Kami</h2>
            <p class="text-gray-600">Dirancang khusus untuk kebutuhan Wedding Organizer di Indonesia</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['icon' => 'fa-rings-wedding', 'title' => 'Wedding Planning', 'desc' => 'Kuasai teknik perencanaan pernikahan dari awal hingga pelaksanaan, termasuk manajemen vendor dan koordinasi tim.', 'color' => 'red'],
                ['icon' => 'fa-chart-line', 'title' => 'Manajemen Bisnis', 'desc' => 'Strategi pengembangan bisnis WO, manajemen keuangan, branding, dan pemasaran digital untuk era modern.', 'color' => 'gray'],
                ['icon' => 'fa-handshake', 'title' => 'Etika & Profesionalisme', 'desc' => 'Standar pelayanan klien, penanganan konflik, kontrak kerja, dan kode etik profesi WO.', 'color' => 'red'],
                ['icon' => 'fa-camera', 'title' => 'Dekorasi & Estetika', 'desc' => 'Tren dekorasi pernikahan terkini, pemilihan tema, koordinasi vendor kreatif, dan presentasi visual.', 'color' => 'gray'],
                ['icon' => 'fa-users-cog', 'title' => 'Kepemimpinan Tim', 'desc' => 'Membangun dan mengelola tim event yang solid, pembagian peran, dan koordinasi lapangan yang efektif.', 'color' => 'gray'],
                ['icon' => 'fa-laptop', 'title' => 'Teknologi Event', 'desc' => 'Penggunaan software perencanaan event, media sosial, dan tools digital untuk mendukung operasional WO.', 'color' => 'red'],
            ] as $item)
            <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition">
                <div class="w-14 h-14 bg-{{ $item['color'] === 'red' ? 'red-100' : 'gray-200' }} rounded-xl flex items-center justify-center mb-4">
                    <i class="fas {{ $item['icon'] }} text-{{ $item['color'] === 'red' ? 'hastana-red' : 'gray-700' }} text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">{{ $item['title'] }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Keunggulan -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Mengapa Pelatihan HASTANA?</h2>
                <div class="space-y-4">
                    @foreach([
                        ['icon' => 'fa-user-tie', 'title' => 'Instruktur Berpengalaman', 'desc' => 'Dipandu langsung oleh praktisi WO dengan pengalaman lebih dari 10 tahun'],
                        ['icon' => 'fa-book-open', 'title' => 'Kurikulum Terstruktur', 'desc' => 'Materi pelatihan yang selalu diperbarui mengikuti tren industri pernikahan'],
                        ['icon' => 'fa-certificate', 'title' => 'Sertifikat Resmi', 'desc' => 'Peserta mendapatkan sertifikat kelulusan yang diakui oleh HASTANA Indonesia'],
                        ['icon' => 'fa-network-wired', 'title' => 'Networking', 'desc' => 'Bangun koneksi dengan sesama WO profesional dari seluruh Indonesia'],
                    ] as $item)
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-hastana-red rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas {{ $item['icon'] }} text-white text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $item['title'] }}</h4>
                            <p class="text-sm text-gray-600 mt-0.5">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Jadwal Pendaftaran</h3>
                <div class="space-y-4 text-center">
                    <div class="bg-red-50 rounded-xl p-4">
                        <div class="text-hastana-red font-bold text-lg">Batch Reguler</div>
                        <div class="text-gray-600 text-sm mt-1">Dibuka setiap kuartal</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-gray-900 font-bold text-lg">Pelatihan Khusus</div>
                        <div class="text-gray-600 text-sm mt-1">Berdasarkan permintaan grup</div>
                    </div>
                    <a href="{{ route('contact') }}" class="block w-full bg-hastana-red text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition text-center">
                        Daftar Pelatihan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-gray-900 text-white text-center">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">Mulai Perjalanan Profesional Anda</h2>
        <p class="text-gray-300 mb-8">Daftarkan diri Anda sekarang dan tingkatkan kompetensi sebagai Wedding Organizer profesional.</p>
        <a href="{{ route('contact') }}" class="inline-flex items-center bg-hastana-red text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
            <i class="fas fa-envelope mr-2"></i> Hubungi Kami
        </a>
    </div>
</section>

@endsection
