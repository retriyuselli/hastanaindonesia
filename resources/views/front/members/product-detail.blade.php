@extends('layouts.app')

@section('title', $product['name'] . ' - ' . $member->organizer_name)
@section('description', $product['description'])

@push('styles')
<style>
    .product-image-gallery {
        position: sticky;
        top: 100px;
    }
    
    .thumbnail {
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid transparent;
    }
    
    .thumbnail:hover,
    .thumbnail.active {
        border-color: #ef4444;
    }
    
    .deal-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: #ef4444;
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 0.5rem;
        font-size: 0.625rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }
    
    .price-badge {
        position: absolute;
        bottom: 1rem;
        left: 1rem;
        background: #ef4444;
        color: white;
        padding: 0.3rem 0.5rem;
        border-radius: 0.5rem;
        font-weight: bold;
        font-size: 0.625rem;
        line-height: 1.2;
    }
</style>
@endpush

@section('content')

<div class="min-h-screen bg-gray-50 pt-20">
    <!-- Breadcrumb -->
    <div class="bg-gray-50 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 text-xs">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <i class="fas fa-chevron-right text-gray-400" style="font-size: 0.65rem;"></i>
                <a href="{{ route('members') }}" class="text-gray-500 hover:text-gray-700">Daftar Anggota</a>
                <i class="fas fa-chevron-right text-gray-400" style="font-size: 0.65rem;"></i>
                <a href="{{ route('members.show', $member->slug) }}" class="text-gray-500 hover:text-gray-700">{{ $member->organizer_name }}</a>
                <i class="fas fa-chevron-right text-gray-400" style="font-size: 0.65rem;"></i>
                <span class="text-gray-900">{{ $product['name'] }}</span>
            </div>
        </div>
    </div>

<!-- Product Detail -->
<section class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Product Images -->
            <div class="product-image-gallery">
                <!-- Main Image -->
                <div class="mb-4 relative rounded-2xl overflow-hidden bg-white shadow-lg">
                    <img id="main-product-image" src="{{ $product['images'][0] }}" alt="{{ $product['name'] }}" class="w-full aspect-square object-cover">
                    
                    @if($product['limited_offer'])
                    <span class="deal-badge">
                        <i class="fas fa-clock"></i>
                        Harga Terbatas
                    </span>
                    @endif
                    
                    <span class="price-badge">Diskon Rp {{ rtrim(rtrim(number_format($product['discount'] / 1000000, 1), '0'), '.') }}jt</span>
                </div>
                
                <!-- Thumbnails -->
                <div class="grid grid-cols-4 gap-3">
                    @foreach($product['images'] as $index => $image)
                    <div class="thumbnail {{ $index === 0 ? 'active' : '' }} rounded-lg overflow-hidden" onclick="changeMainImage('{{ $image }}', this)">
                        <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}" class="w-full aspect-square object-cover">
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Product Info -->
            <div>
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <!-- Vendor Info -->
                    <div class="flex items-center mb-4 pb-4 border-b border-gray-200">
                        @if($member->logo)
                            <img src="{{ Storage::url($member->logo) }}" alt="{{ $member->organizer_name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-900 flex items-center justify-center text-white text-sm font-bold mr-3">
                                {{ strtoupper(substr($member->organizer_name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="font-bold text-sm text-gray-900">{{ $member->organizer_name }}</h3>
                            <p class="text-xs text-gray-600">{{ $member->city }}</p>
                        </div>
                    </div>
                    
                    <!-- Product Name -->
                    <h1 class="text-xl font-bold text-gray-900 mb-3">{{ $product['name'] }}</h1>
                    
                    <!-- Badges -->
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @foreach($product['badges'] as $badge)
                        <span class="px-1.5 py-0.5 bg-red-100 text-red-600 text-[10px] font-semibold rounded-full">{{ $badge }}</span>
                        @endforeach
                    </div>
                    
                    <!-- Price -->
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 line-through mb-1">Rp {{ number_format($product['original_price']) }}</p>
                        <p class="text-2xl font-bold text-pink-600 mb-1">Rp {{ number_format($product['price']) }}</p>
                        <p class="text-xs text-green-600 font-semibold">Hemat Rp {{ number_format($product['discount']) }}</p>
                    </div>
                    
                    <!-- Description -->
                    @if(!empty($product['description']))
                    <div class="mb-4 bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border border-gray-100">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-file-alt text-pink-600 text-sm"></i>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Detail Paket</h3>
                        </div>
                        <div class="text-xs text-gray-700 leading-relaxed prose prose-sm max-w-none
                            [&_ol]:list-decimal [&_ol]:pl-5 [&_ol]:space-y-2 [&_ol]:my-2
                            [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:space-y-2 [&_ul]:my-2
                            [&_p]:mb-3 [&_p]:leading-relaxed
                            [&_li]:text-xs [&_li]:leading-relaxed [&_li]:text-gray-700
                            [&_strong]:text-gray-900 [&_strong]:font-bold [&_strong]:text-sm [&_strong]:block [&_strong]:mt-4 [&_strong]:mb-2
                            [&_a]:text-pink-600 [&_a]:underline [&_a]:hover:text-pink-700
                            [&_h1]:text-base [&_h1]:font-bold [&_h1]:mb-2 [&_h1]:text-gray-900
                            [&_h2]:text-sm [&_h2]:font-bold [&_h2]:mb-2 [&_h2]:text-gray-900
                            [&_h3]:text-xs [&_h3]:font-bold [&_h3]:mb-1 [&_h3]:text-gray-900">
                            {!! $product['description'] !!}
                        </div>
                    </div>
                    @endif
                    
                    <!-- Features -->
                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-gray-900 mb-3">Yang Anda Dapatkan:</h3>
                        <div class="space-y-2">
                            @foreach($product['features'] as $feature)
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2 text-xs"></i>
                                <span class="text-xs text-gray-700">{{ $feature }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap justify-center gap-2">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->phone ?? '') }}?text=Halo, saya tertarik dengan {{ $product['name'] }}" target="_blank" class="inline-block px-6 py-2.5 bg-green-500 text-white text-sm font-bold rounded-lg hover:bg-green-600 transition-colors">
                            <i class="fab fa-whatsapp mr-2"></i>Hubungi via WhatsApp
                        </a>
                        
                        @if($member->phone)
                        <a href="tel:{{ $member->phone }}" class="inline-block px-6 py-2.5 bg-pink-500 text-white text-sm font-bold rounded-lg hover:bg-pink-600 transition-colors">
                            <i class="fas fa-phone mr-2"></i>Telepon Sekarang
                        </a>
                        @endif
                        
                        <a href="{{ route('members.show', $member->slug) }}" class="inline-block px-6 py-2.5 border-2 border-gray-300 text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fas fa-store mr-2"></i>Lihat Produk Lainnya
                        </a>
                    </div>
                </div>
                
                <!-- Additional Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 mt-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-2 text-sm"></i>
                        <div>
                            <h4 class="font-bold text-xs text-blue-900 mb-1">Informasi Penting</h4>
                            <p class="text-xs text-blue-800">Harga dan paket dapat disesuaikan dengan kebutuhan dan budget Anda. Hubungi kami untuk konsultasi gratis dan penawaran khusus!</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Related Members -->
@if($relatedMembers && $relatedMembers->count() > 0)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Vendor Lainnya</h2>
            <p class="text-sm text-gray-600">Temukan wedding organizer terbaik lainnya</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedMembers as $related)
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all">
                <div class="text-center">
                    <div class="relative inline-block mb-3">
                        @if($related->logo)
                            <img src="{{ Storage::url($related->logo) }}" alt="{{ $related->organizer_name }}" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-gray-200">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gray-900 flex items-center justify-center text-white text-xl font-bold mx-auto">
                                {{ strtoupper(substr($related->organizer_name, 0, 1)) }}
                            </div>
                        @endif
                        @if($related->verification_status == 'verified')
                        <div class="absolute bottom-0 right-0 bg-white rounded-full p-1 shadow-md">
                            <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <h3 class="font-bold text-base mb-1">{{ $related->organizer_name }}</h3>
                    @if($related->brand_name)
                    <p class="text-xs text-red-500 mb-2">{{ $related->brand_name }}</p>
                    @endif
                    <p class="text-xs text-gray-600 mb-2">{{ $related->city }}</p>
                    
                    {{-- <div class="text-xs text-gray-700 mb-3">
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        {{ number_format($related->rating ?? 0, 1) }}/5
                        @if($related->completed_events)
                        <span class="text-gray-500">({{ $related->completed_events }} ulasan)</span>
                        @endif
                    </div> --}}
                    
                    <a href="{{ route('members.show', $related->slug) }}" class="block w-full px-4 py-2 bg-pink-500 text-white text-sm font-semibold rounded-lg hover:bg-pink-600 transition-colors text-center">
                        <i class="fas fa-eye mr-2"></i>Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

</div>
<!-- End min-h-screen wrapper -->

@endsection

@push('scripts')
<script>
function changeMainImage(imageSrc, element) {
    // Update main image
    document.getElementById('main-product-image').src = imageSrc;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.classList.remove('active');
    });
    element.classList.add('active');
}
</script>
@endpush
