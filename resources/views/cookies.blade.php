@extends('layouts.app')

@section('title', 'Kebijakan Cookie - HASTANA Indonesia')
@section('description', 'Kebijakan penggunaan cookie pada website HASTANA Indonesia.')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-red-900 via-red-800 to-blue-800 py-20 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                <i class="fas fa-cookie-bite text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                Kebijakan <span class="text-yellow-300">Cookie</span>
            </h1>
            <p class="text-xl mb-6 leading-relaxed opacity-90">
                Transparansi penggunaan cookie di website HASTANA Indonesia
            </p>
            <div class="text-sm opacity-75">Terakhir diperbarui: {{ date('d F Y') }}</div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Intro -->
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-xl p-6 mb-8">
            <p class="text-gray-700 leading-relaxed">
                Website HASTANA Indonesia (<strong>hastanaindonesia.id</strong>) menggunakan cookie untuk meningkatkan pengalaman
                pengguna, menganalisis lalu lintas situs, dan menyajikan konten yang relevan. Halaman ini menjelaskan
                apa itu cookie, bagaimana kami menggunakannya, dan bagaimana Anda dapat mengelolanya.
            </p>
        </div>

        <!-- Section 1 -->
        <div class="mb-8 p-6 bg-gray-50 rounded-xl border-l-4 border-hastana-red">
            <h2 class="text-xl font-bold text-hastana-red mb-4">1. Apa itu Cookie?</h2>
            <p class="text-gray-700 leading-relaxed mb-3">
                Cookie adalah file teks kecil yang disimpan di perangkat Anda (komputer, tablet, atau ponsel) ketika Anda
                mengunjungi sebuah website. Cookie membantu website mengingat preferensi dan aktivitas Anda sehingga
                Anda tidak perlu memasukkan informasi yang sama berulang kali.
            </p>
            <p class="text-gray-700 leading-relaxed">
                Cookie tidak dapat mengakses atau membaca file lain di perangkat Anda, dan tidak membawa virus atau malware.
            </p>
        </div>

        <!-- Section 2 -->
        <div class="mb-8 p-6 bg-gray-50 rounded-xl border-l-4 border-hastana-red">
            <h2 class="text-xl font-bold text-hastana-red mb-4">2. Jenis Cookie yang Kami Gunakan</h2>
            <div class="space-y-4">
                @foreach([
                    [
                        'icon' => 'fa-cog',
                        'title' => 'Cookie Esensial',
                        'color' => 'red',
                        'desc' => 'Cookie ini diperlukan agar website dapat berfungsi dengan baik. Termasuk cookie sesi login, keamanan CSRF, dan preferensi dasar. Cookie ini tidak dapat dinonaktifkan.',
                        'examples' => ['Session login pengguna', 'Token keamanan CSRF', 'Preferensi bahasa'],
                    ],
                    [
                        'icon' => 'fa-chart-bar',
                        'title' => 'Cookie Analitik',
                        'color' => 'blue',
                        'desc' => 'Membantu kami memahami bagaimana pengunjung berinteraksi dengan website melalui pengumpulan data anonim. Informasi ini digunakan untuk meningkatkan performa dan konten website.',
                        'examples' => ['Jumlah pengunjung', 'Halaman yang sering dikunjungi', 'Durasi kunjungan'],
                    ],
                    [
                        'icon' => 'fa-sliders-h',
                        'title' => 'Cookie Fungsional',
                        'color' => 'green',
                        'desc' => 'Memungkinkan website mengingat pilihan yang Anda buat untuk memberikan pengalaman yang lebih personal dan nyaman.',
                        'examples' => ['Preferensi tampilan', 'Filter pencarian tersimpan', 'Informasi formulir'],
                    ],
                ] as $item)
                <div class="bg-white rounded-lg p-5 border border-gray-200">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-{{ $item['color'] === 'red' ? 'red-100' : ($item['color'] === 'blue' ? 'blue-100' : 'green-100') }} rounded-lg flex items-center justify-center">
                            <i class="fas {{ $item['icon'] }} text-{{ $item['color'] === 'red' ? 'hastana-red' : ($item['color'] === 'blue' ? 'blue-600' : 'green-600') }} text-sm"></i>
                        </div>
                        <h3 class="font-bold text-gray-900">{{ $item['title'] }}</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">{{ $item['desc'] }}</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($item['examples'] as $ex)
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ $ex }}</span>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Section 3 -->
        <div class="mb-8 p-6 bg-gray-50 rounded-xl border-l-4 border-hastana-red">
            <h2 class="text-xl font-bold text-hastana-red mb-4">3. Cookie Pihak Ketiga</h2>
            <p class="text-gray-700 leading-relaxed mb-4">
                Beberapa layanan pihak ketiga yang kami gunakan juga dapat menempatkan cookie di perangkat Anda:
            </p>
            <ul class="space-y-2 text-gray-700">
                <li class="flex items-start gap-2"><i class="fas fa-check text-hastana-red mt-1 text-xs"></i> <span><strong>Google Analytics</strong> — untuk analisis statistik pengunjung website</span></li>
                <li class="flex items-start gap-2"><i class="fas fa-check text-hastana-red mt-1 text-xs"></i> <span><strong>Google Fonts</strong> — untuk menampilkan tipografi yang konsisten</span></li>
                <li class="flex items-start gap-2"><i class="fas fa-check text-hastana-red mt-1 text-xs"></i> <span><strong>WhatsApp Widget</strong> — untuk fitur chat langsung dengan tim kami</span></li>
            </ul>
        </div>

        <!-- Section 4 -->
        <div class="mb-8 p-6 bg-gray-50 rounded-xl border-l-4 border-hastana-red">
            <h2 class="text-xl font-bold text-hastana-red mb-4">4. Mengelola Cookie</h2>
            <p class="text-gray-700 leading-relaxed mb-4">
                Anda dapat mengontrol dan mengelola cookie melalui pengaturan browser Anda. Berikut panduan untuk
                browser populer:
            </p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach(['Chrome', 'Firefox', 'Safari', 'Edge'] as $browser)
                <div class="bg-white border border-gray-200 rounded-lg p-3 text-center">
                    <i class="fab fa-{{ strtolower($browser) }} text-2xl text-gray-600 mb-2"></i>
                    <div class="text-sm font-medium text-gray-700">{{ $browser }}</div>
                    <div class="text-xs text-gray-400 mt-1">Settings → Privacy</div>
                </div>
                @endforeach
            </div>
            <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-sm text-yellow-800">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Perhatian:</strong> Menonaktifkan cookie tertentu dapat mempengaruhi fungsi website dan
                    pengalaman penggunaan Anda.
                </p>
            </div>
        </div>

        <!-- Section 5 -->
        <div class="mb-8 p-6 bg-gray-50 rounded-xl border-l-4 border-hastana-red">
            <h2 class="text-xl font-bold text-hastana-red mb-4">5. Perubahan Kebijakan Cookie</h2>
            <p class="text-gray-700 leading-relaxed">
                HASTANA Indonesia dapat memperbarui kebijakan cookie ini sewaktu-waktu. Setiap perubahan akan
                dipublikasikan di halaman ini beserta tanggal pembaruan. Kami menyarankan Anda untuk meninjau
                halaman ini secara berkala.
            </p>
        </div>

        <!-- Section 6 -->
        <div class="mb-8 p-6 bg-gray-50 rounded-xl border-l-4 border-hastana-red">
            <h2 class="text-xl font-bold text-hastana-red mb-4">6. Hubungi Kami</h2>
            <p class="text-gray-700 leading-relaxed mb-4">
                Jika Anda memiliki pertanyaan mengenai kebijakan cookie ini, silakan hubungi kami:
            </p>
            <div class="space-y-2 text-gray-700 text-sm">
                <div class="flex items-center gap-2"><i class="fas fa-envelope text-hastana-red w-4"></i> info@hastanaindonesia.id</div>
                <div class="flex items-center gap-2"><i class="fas fa-phone text-hastana-red w-4"></i> +62 811-3130-612</div>
                <div class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-hastana-red w-4"></i> Ruko Kelapa Hijau, Jl. Brojomulyo No.13-14, Sleman, D.I. Yogyakarta</div>
            </div>
        </div>

        <!-- Links -->
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('privacy') }}" class="text-hastana-red hover:underline text-sm font-medium">
                <i class="fas fa-user-shield mr-1"></i> Kebijakan Privasi
            </a>
            <a href="{{ route('terms') }}" class="text-hastana-red hover:underline text-sm font-medium">
                <i class="fas fa-file-contract mr-1"></i> Syarat & Ketentuan
            </a>
        </div>
    </div>
</section>

@endsection
