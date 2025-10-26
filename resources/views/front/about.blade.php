@extends('layouts.app')

@section('title', 'Tentang HASTANA Indonesia - Himpunan Perusahaan Penata Acara Seluruh Indonesia')
@section('description', 'Pelajari lebih lanjut tentang HASTANA Indonesia, sejarah, visi misi, dan komitmen kami dalam memajukan industri wedding organizer di Indonesia.')

@section('content')

<!-- Hero Section -->
<x-ui.hero-section 
    title="Tentang HASTANA Indonesia"
    subtitle="Mengenal Lebih Dekat Himpunan Perusahaan Penata Acara Seluruh Indonesia"
    description="Organisasi resmi yang menaungi para wedding organizer profesional di seluruh Indonesia dengan komitmen tinggi terhadap kualitas dan profesionalisme."
/>

<!-- Main Content -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        
        <!-- Sejarah HASTANA -->
        <div class="max-w-4xl mx-auto mb-20">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                    Sejarah <span class="text-hastana-blue">HASTANA</span>
                </h2>
                <div class="w-20 h-1 bg-gradient-to-r from-hastana-blue to-hastana-red mx-auto"></div>
            </div>
            
            <div class="prose prose-base max-w-none text-gray-700 leading-relaxed">
                @if($about && $about->history)
                    {!! $about->history !!}
                @else
                    <p class="text-base mb-6">
                        <strong>Himpunan Perusahaan Penata Acara Seluruh Indonesia (HASTANA)</strong> didirikan pada tahun 2010 sebagai respons terhadap kebutuhan akan standarisasi dan profesionalisme dalam industri wedding organizer di Indonesia.
                    </p>
                    <p class="mb-6">
                        Berawal dari sekelompok kecil wedding organizer berpengalaman di Jakarta, HASTANA tumbuh menjadi organisasi nasional yang menaungi lebih dari 1000 wedding organizer tersertifikasi di seluruh Indonesia. Kami berkomitmen untuk meningkatkan standar kualitas pelayanan dan menciptakan ekosistem bisnis yang sehat dalam industri penyelenggaraan acara pernikahan.
                    </p>
                    <p class="mb-6">
                        Dalam perjalanannya, HASTANA telah menjadi jembatan antara wedding organizer profesional dengan klien yang membutuhkan pelayanan berkualitas tinggi. Kami juga aktif dalam memberikan pelatihan, sertifikasi, dan program pengembangan berkelanjutan untuk para anggota.
                    </p>
                @endif
            </div>
        </div>

        <!-- Visi Misi -->
        <div class="mb-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Visi -->
                <x-ui.card class="p-8 h-full" :showReadMore="false">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-hastana-blue to-blue-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-eye text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Visi Kami</h3>
                    </div>
                    @if($about && $about->vision)
                        <p class="text-gray-700 text-base leading-relaxed text-center">
                            {{ $about->vision }}
                        </p>
                    @else
                        <p class="text-gray-700 text-base leading-relaxed text-center">
                            Menjadi organisasi terdepan yang mengembangkan industri wedding organizer Indonesia dengan standar internasional, menciptakan ekosistem profesional yang berkelanjutan, dan membanggakan Indonesia di kancah global.
                        </p>
                    @endif
                </x-ui.card>

                <!-- Misi -->
                <x-ui.card class="p-8 h-full" :showReadMore="false">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-hastana-red to-red-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-target text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Misi Kami</h3>
                    </div>
                    @if($about && $about->mission)
                        <div class="text-gray-700 leading-relaxed text-center">
                            {!! $about->mission !!}
                        </div>
                    @else
                        <ul class="text-gray-700 leading-relaxed space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-hastana-blue mr-3 mt-1"></i>
                                <span>Mengembangkan standar kualitas dan profesionalisme wedding organizer Indonesia</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-hastana-blue mr-3 mt-1"></i>
                                <span>Menyediakan program sertifikasi dan pelatihan berkelanjutan</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-hastana-blue mr-3 mt-1"></i>
                                <span>Memfasilitasi kolaborasi dan networking antar profesional</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-hastana-blue mr-3 mt-1"></i>
                                <span>Memberikan advokasi dan perlindungan bagi anggota</span>
                            </li>
                        </ul>
                    @endif
                </x-ui.card>

            </div>
        </div>

        <!-- Nilai-nilai HASTANA -->
        <div class="mb-20">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                    Nilai-nilai <span class="text-hastana-red">HASTANA</span>
                </h2>
                <div class="w-20 h-1 bg-gradient-to-r from-hastana-red to-hastana-blue mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                @if($about && $about->values && count($about->values) > 0)
                    @foreach($about->values as $index => $value)
                        <x-ui.card class="p-6 text-center card-hover" :showReadMore="false">
                            @php
                                $colors = ['blue', 'green', 'purple', 'red', 'yellow'];
                                $icons = ['fa-medal', 'fa-handshake', 'fa-lightbulb', 'fa-users', 'fa-gem'];
                                $color = $colors[$index % count($colors)];
                                $icon = $icons[$index % count($icons)];
                            @endphp
                            <div class="w-16 h-16 bg-gradient-to-br from-{{ $color }}-500 to-{{ $color }}-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas {{ $icon }} text-white text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-3 text-center">{{ $value['title'] }}</h4>
                            <p class="text-gray-600 text-sm leading-relaxed text-center">
                                {{ $value['description'] }}
                            </p>
                        </x-ui.card>
                    @endforeach
                @else
                    <!-- Default values if no data from database -->
                    <!-- Profesionalisme -->
                    <x-ui.card class="p-6 text-center card-hover" :showReadMore="false">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-medal text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-3">Profesionalisme</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Berkomitmen pada standar tertinggi dalam setiap pelayanan dan kualitas kerja yang dapat dipertanggungjawabkan.
                        </p>
                    </x-ui.card>

                    <!-- Integritas -->
                    <x-ui.card class="p-6 text-center card-hover" :showReadMore="false">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-handshake text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-3">Integritas</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Menjunjung tinggi kejujuran, transparansi, dan etika bisnis dalam setiap aspek operasional organisasi.
                        </p>
                    </x-ui.card>

                    <!-- Inovasi -->
                    <x-ui.card class="p-6 text-center card-hover" :showReadMore="false">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-lightbulb text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-3">Inovasi</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Mendorong kreativitas dan inovasi dalam menghadapi tantangan industri yang terus berkembang.
                        </p>
                    </x-ui.card>

                    <!-- Kolaborasi -->
                    <x-ui.card class="p-6 text-center card-hover" :showReadMore="false">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-3">Kolaborasi</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Membangun sinergi dan kerjasama yang kuat antar anggota untuk kemajuan bersama.
                        </p>
                    </x-ui.card>
                @endif

            </div>
        </div>

        <!-- Statistik HASTANA -->
        <div class="bg-gray-50 py-16 rounded-3xl mb-20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                        HASTANA dalam <span class="text-hastana-blue">Angka</span>
                    </h2>
                    <p class="text-lg text-gray-600">
                        Pencapaian dan kontribusi kami untuk industri wedding organizer Indonesia
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-hastana-blue mb-2">1000+</div>
                        <div class="text-gray-600 font-medium text-sm">Anggota Tersertifikasi</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-hastana-red mb-2">34</div>
                        <div class="text-gray-600 font-medium text-sm">Provinsi Terjangkau</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-hastana-blue mb-2">15+</div>
                        <div class="text-gray-600 font-medium text-sm">Tahun Pengalaman</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-hastana-red mb-2">50,000+</div>
                        <div class="text-gray-600 font-medium text-sm">Pernikahan Tersukseskan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Program & Layanan -->
        <div class="mb-20">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                    Program & <span class="text-hastana-red">Layanan</span>
                </h2>
                <div class="w-20 h-1 bg-gradient-to-r from-hastana-blue to-hastana-red mx-auto mb-6"></div>
                <p class="text-base text-gray-600 max-w-3xl mx-auto">
                    Berbagai program dan layanan yang kami sediakan untuk mengembangkan profesionalisme anggota
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-center">
                
                @if($about && $about->programs && count($about->programs) > 0)
                    @foreach($about->programs as $index => $program)
                        <x-ui.card class="p-8 text-center card-hover" :showReadMore="false">
                            @php
                                $colors = [
                                    'from-yellow-500 to-orange-500',
                                    'from-blue-500 to-indigo-500',
                                    'from-purple-500 to-pink-500',
                                    'from-green-500 to-teal-500',
                                    'from-red-500 to-rose-500'
                                ];
                                $icons = ['fa-certificate', 'fa-chalkboard-teacher', 'fa-network-wired', 'fa-hands-helping', 'fa-users-cog'];
                                $color = $colors[$index % count($colors)];
                                $icon = $icons[$index % count($icons)];
                            @endphp
                            <div class="w-20 h-20 bg-gradient-to-br {{ $color }} rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas {{ $icon }} text-white text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">{{ $program['title'] }}</h3>
                            <p class="text-gray-600 leading-relaxed text-sm">
                                {{ $program['description'] }}
                            </p>
                        </x-ui.card>
                    @endforeach
                @else
                    <!-- Default programs if no data from database -->
                    <!-- Sertifikasi Profesional -->
                    <x-ui.card class="p-8 text-center card-hover" :showReadMore="false">
                        <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-certificate text-white text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Sertifikasi Profesional</h3>
                        <p class="text-gray-600 leading-relaxed mb-6 text-sm">
                            Program sertifikasi komprehensif yang mengukur dan memvalidasi kompetensi wedding organizer sesuai standar nasional.
                        </p>
                        <ul class="text-sm text-gray-600 text-left space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Sertifikat Dasar Wedding Organizer
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Sertifikat Menengah & Lanjutan
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Sertifikat Spesialisasi
                            </li>
                        </ul>
                    </x-ui.card>

                    <!-- Pelatihan & Workshop -->
                    <x-ui.card class="p-8 text-center card-hover" :showReadMore="false">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-chalkboard-teacher text-white text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Pelatihan & Workshop</h3>
                        <p class="text-gray-600 leading-relaxed mb-6 text-sm">
                            Program pelatihan berkelanjutan dengan materi terkini dan instruktur berpengalaman dari dalam dan luar negeri.
                        </p>
                        <ul class="text-sm text-gray-600 text-left space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Workshop Manajemen Event
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Pelatihan Digital Marketing
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Seminar Tren Pernikahan
                            </li>
                        </ul>
                    </x-ui.card>

                    <!-- Networking & Kolaborasi -->
                    <x-ui.card class="p-8 text-center card-hover" :showReadMore="false">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-network-wired text-white text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Networking & Kolaborasi</h3>
                        <p class="text-gray-600 leading-relaxed mb-6 text-sm">
                            Platform networking yang memfasilitasi kolaborasi antar anggota untuk saling berbagi pengalaman dan peluang bisnis.
                        </p>
                        <ul class="text-sm text-gray-600 text-left space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Annual Networking Gala
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Regional Meet-up
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Platform Digital Kolaborasi
                            </li>
                        </ul>
                    </x-ui.card>
                @endif
        </div>

    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-hastana-blue to-hastana-red">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Bergabunglah dengan Komunitas Professional
        </h2>
        <p class="text-xl text-white/90 mb-8 max-w-3xl mx-auto">
            Jadilah bagian dari HASTANA Indonesia dan kembangkan bisnis wedding organizer Anda bersama komunitas terbaik
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <x-ui.button 
                href="{{ route('join') }}" 
                variant="white" 
                size="lg"
                class="inline-flex items-center"
            >
                <i class="fas fa-user-plus mr-3"></i>
                Daftar Keanggotaan
            </x-ui.button>
            <x-ui.button 
                href="{{ route('contact') }}" 
                variant="outline-white" 
                size="lg"
                class="inline-flex items-center"
            >
                <i class="fas fa-phone mr-3"></i>
                Konsultasi Gratis
            </x-ui.button>
        </div>
    </div>
</section>

@endsection