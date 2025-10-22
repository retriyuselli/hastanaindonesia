@extends('layouts.frontend')

@section('title', 'HASTANA Indonesia - Wedding Organizer Professional')
@section('description', 'Organisasi resmi yang menaungi para wedding organizer profesional di Indonesia. Mendukung profesionalisme dan kolaborasi WO di seluruh Indonesia.')

@section('content')

<!-- Hero Section -->
<x-ui.hero-section 
    title="HASTANA Indonesia" 
    subtitle="Himpunan Perusahaan Penata Acara Seluruh Indonesia"
    description="Organisasi resmi yang menaungi para wedding organizer profesional di Indonesia. Bersama membangun industri pernikahan yang lebih baik."
    :buttons="[
        [
            'text' => 'Bergabung Sekarang',
            'url' => route('join'),
            'icon' => 'fas fa-handshake',
            'class' => 'bg-hastana-red hover:bg-red-700 text-white'
        ],
        [
            'text' => 'Lihat Anggota',
            'url' => route('members'),
            'icon' => 'fas fa-users',
            'class' => 'bg-white/20 backdrop-blur-sm border border-white/30 text-white hover:bg-white/30'
        ]
    ]"
/>

<!-- Stats Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">HASTANA dalam Angka</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Prestasi dan pencapaian organisasi kami dalam mendukung industri wedding organizer Indonesia</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-hastana-blue mb-2">500+</div>
                <div class="text-gray-600">Anggota Terdaftar</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-hastana-red mb-2">34</div>
                <div class="text-gray-600">Provinsi</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-hastana-blue mb-2">10,000+</div>
                <div class="text-gray-600">Event Sukses</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-hastana-red mb-2">15</div>
                <div class="text-gray-600">Tahun Pengalaman</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Members Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Anggota Unggulan</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Wedding organizer profesional terpilih dengan sertifikasi HASTANA</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
            $featuredMembers = [
                [
                    'name' => 'Sarah Wedding Organizer',
                    'brand' => 'Sarah WO Jakarta',
                    'location' => 'Jakarta Selatan',
                    'specialization' => 'Modern & Traditional Wedding',
                    'image' => 'https://via.placeholder.com/400x300?text=Sarah+WO',
                    'rating' => 5,
                    'completedEvents' => 150,
                    'certification' => 'Certified Pro',
                    'verified' => true,
                    'featured' => true,
                    'contact' => ['whatsapp' => '6281234567890', 'instagram' => 'sarahwo_jakarta']
                ],
                [
                    'name' => 'Elegant Wedding Planner',
                    'brand' => 'Elegant WP',
                    'location' => 'Bandung, Jawa Barat',
                    'specialization' => 'Luxury & Garden Wedding',
                    'image' => 'https://via.placeholder.com/400x300?text=Elegant+WP',
                    'rating' => 5,
                    'completedEvents' => 200,
                    'certification' => 'Master',
                    'verified' => true,
                    'featured' => true,
                    'contact' => ['whatsapp' => '6281234567891', 'instagram' => 'elegantwp_bdg']
                ],
                [
                    'name' => 'Divine Wedding Organizer',
                    'brand' => 'Divine WO',
                    'location' => 'Surabaya, Jawa Timur',
                    'specialization' => 'Cultural & International Wedding',
                    'image' => 'https://via.placeholder.com/400x300?text=Divine+WO',
                    'rating' => 4,
                    'completedEvents' => 120,
                    'certification' => 'Certified',
                    'verified' => true,
                    'featured' => false,
                    'contact' => ['whatsapp' => '6281234567892']
                ]
            ];
            @endphp
            
            @foreach($featuredMembers as $member)
                <x-ui.member-card 
                    :name="$member['name']"
                    :brand="$member['brand']"
                    :image="$member['image']"
                    :location="$member['location']"
                    :specialization="$member['specialization']"
                    :rating="$member['rating']"
                    :completedEvents="$member['completedEvents']"
                    :certification="$member['certification']"
                    :verified="$member['verified']"
                    :featured="$member['featured']"
                    :contact="$member['contact']"
                    url="#"
                />
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <x-ui.button href="{{ route('members') }}" variant="primary" size="lg" icon="fas fa-users">
                Lihat Semua Anggota
            </x-ui.button>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Gallery Portfolio</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Karya-karya terbaik dari anggota HASTANA Indonesia</p>
        </div>
        
        @php
        $galleryItems = [
            [
                'image' => 'https://via.placeholder.com/600x600?text=Wedding+1',
                'title' => 'Pernikahan Adat Jawa',
                'description' => 'Upacara pernikahan adat Jawa yang megah dengan dekorasi tradisional',
                'category' => 'Traditional'
            ],
            [
                'image' => 'https://via.placeholder.com/600x600?text=Wedding+2',
                'title' => 'Garden Wedding',
                'description' => 'Pernikahan outdoor di taman dengan konsep natural dan romantis',
                'category' => 'Outdoor'
            ],
            [
                'image' => 'https://via.placeholder.com/600x600?text=Wedding+3',
                'title' => 'Modern Ballroom',
                'description' => 'Resepsi pernikahan modern di ballroom hotel mewah',
                'category' => 'Modern'
            ],
            [
                'image' => 'https://via.placeholder.com/600x600?text=Wedding+4',
                'title' => 'Beach Wedding',
                'description' => 'Pernikahan pantai dengan suasana sunset yang romantis',
                'category' => 'Beach'
            ],
            [
                'image' => 'https://via.placeholder.com/600x600?text=Wedding+5',
                'title' => 'Intimate Wedding',
                'description' => 'Pernikahan intim dengan keluarga dekat',
                'category' => 'Intimate'
            ],
            [
                'image' => 'https://via.placeholder.com/600x600?text=Wedding+6',
                'title' => 'Cultural Wedding',
                'description' => 'Pernikahan dengan perpaduan budaya Indonesia',
                'category' => 'Cultural'
            ],
            [
                'image' => 'https://via.placeholder.com/600x600?text=Wedding+7',
                'title' => 'Luxury Reception',
                'description' => 'Resepsi mewah dengan dekorasi premium',
                'category' => 'Luxury'
            ],
            [
                'image' => 'https://via.placeholder.com/600x600?text=Wedding+8',
                'title' => 'Rustic Wedding',
                'description' => 'Pernikahan bergaya rustic dengan sentuhan vintage',
                'category' => 'Rustic'
            ]
        ];
        @endphp
        
        <x-ui.gallery-grid :items="$galleryItems" />
        
        <div class="text-center mt-12">
            <x-ui.button href="{{ route('portfolio') }}" variant="outline" size="lg" icon="fas fa-camera">
                Lihat Portfolio Lengkap
            </x-ui.button>
        </div>
    </div>
</section>

<!-- Latest Blog Posts -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Blog & Tips</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Artikel dan tips terbaru seputar dunia wedding organizer</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
            $blogPosts = [
                [
                    'title' => 'Tips Memilih Wedding Organizer Terpercaya',
                    'description' => 'Panduan lengkap dalam memilih wedding organizer yang sesuai dengan budget dan kebutuhan Anda.',
                    'image' => 'https://via.placeholder.com/400x250?text=Tips+WO',
                    'date' => '2024-01-15',
                    'author' => 'HASTANA Editorial',
                    'category' => 'Tips',
                    'url' => '#'
                ],
                [
                    'title' => 'Tren Dekorasi Pernikahan 2024',
                    'description' => 'Mengenal tren dekorasi pernikahan terbaru yang akan populer di tahun 2024.',
                    'image' => 'https://via.placeholder.com/400x250?text=Trend+2024',
                    'date' => '2024-01-10',
                    'author' => 'Sarah WO',
                    'category' => 'Trend',
                    'url' => '#'
                ],
                [
                    'title' => 'Cara Menjadi Wedding Organizer Profesional',
                    'description' => 'Langkah-langkah untuk memulai karir sebagai wedding organizer profesional bersertifikat.',
                    'image' => 'https://via.placeholder.com/400x250?text=Career+WO',
                    'date' => '2024-01-05',
                    'author' => 'HASTANA Training',
                    'category' => 'Career',
                    'url' => '#'
                ]
            ];
            @endphp
            
            @foreach($blogPosts as $post)
                <x-ui.card 
                    :title="$post['title']"
                    :description="$post['description']"
                    :image="$post['image']"
                    :url="$post['url']"
                    :date="$post['date']"
                    :author="$post['author']"
                    :category="$post['category']"
                />
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <x-ui.button href="{{ route('blog') }}" variant="secondary" size="lg" icon="fas fa-newspaper">
                Lihat Semua Artikel
            </x-ui.button>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-hastana-blue">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Siap Bergabung dengan HASTANA?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Jadilah bagian dari komunitas wedding organizer terbesar di Indonesia. Dapatkan sertifikasi, networking, dan dukungan bisnis.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <x-ui.button href="{{ route('join') }}" variant="white" size="xl" icon="fas fa-handshake">
                Daftar Sebagai Anggota
            </x-ui.button>
            <x-ui.button href="{{ route('contact') }}" variant="outline" size="xl" icon="fas fa-envelope">
                Hubungi Kami
            </x-ui.button>
        </div>
    </div>
</section>

@endsection