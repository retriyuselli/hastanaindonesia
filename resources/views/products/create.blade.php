@extends('layouts.app')

@section('title', 'Tambah Produk - HASTANA Indonesia')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16 mt-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold mb-2">Tambah Produk Baru</h1>
            <p class="text-blue-100">{{ $weddingOrganizer->organizer_name }}</p>
        </div>
    </div>
</section>

<!-- Form Content -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            
            <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
                
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <strong class="font-bold">Terjadi kesalahan!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('products.store', $weddingOrganizer->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Nama Produk -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    
                    <!-- Deskripsi -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                        <div id="editor" style="height: 300px;"></div>
                        <textarea name="description" id="description" style="display: none;">{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Gunakan editor untuk memformat deskripsi produk</p>
                    </div>
                    
                    <!-- Harga Asli -->
                    <div class="mb-6">
                        <label for="original_price" class="block text-sm font-semibold text-gray-700 mb-2">Harga Asli (IDR) <span class="text-red-500">*</span></label>
                        <input type="text" name="original_price_display" id="original_price_display" value="{{ old('original_price') ? number_format(old('original_price'), 0, ',', '.') : '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required oninput="formatCurrency(this, 'original_price')">
                        <input type="hidden" name="original_price" id="original_price">
                        <p class="text-xs text-gray-500 mt-1">Contoh: 50.000.000</p>
                    </div>
                    
                    <!-- Harga Jual -->
                    <div class="mb-6">
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Harga Jual (IDR) <span class="text-red-500">*</span></label>
                        <input type="text" name="price_display" id="price_display" value="{{ old('price') ? number_format(old('price'), 0, ',', '.') : '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required oninput="formatCurrency(this, 'price')">
                        <input type="hidden" name="price" id="price">
                        <p class="text-xs text-gray-500 mt-1">Contoh: 45.000.000</p>
                    </div>
                    
                    <!-- Diskon -->
                    <div class="mb-6">
                        <label for="discount" class="block text-sm font-semibold text-gray-700 mb-2">Diskon (IDR)</label>
                        <input type="text" name="discount_display" id="discount_display" value="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" readonly>
                        <input type="hidden" name="discount" id="discount" value="0">
                        <p class="text-xs text-gray-500 mt-1">Otomatis dihitung: Harga Asli - Harga Jual</p>
                    </div>
                    
                    <!-- Badges -->
                    <div class="mb-6">
                        <label for="badges" class="block text-sm font-semibold text-gray-700 mb-2">Badges</label>
                        <input type="text" name="badges" id="badges" value="{{ old('badges') }}" placeholder="Pisahkan dengan koma (contoh: Best Seller, Promo)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Masukkan badge dan pisahkan dengan koma</p>
                    </div>
                    
                    <!-- Gambar Produk -->
                    <div class="mb-6">
                        <label for="images" class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk <span class="text-red-500">*</span></label>
                        <input type="file" name="images[]" id="images" accept="image/*" multiple class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG (Max: 2MB per file). Upload beberapa gambar sekaligus. Gambar pertama akan menjadi gambar utama.</p>
                    </div>
                    
                    <!-- Limited Offer -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="limited_offer" id="limited_offer" value="1" {{ old('limited_offer') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm font-semibold text-gray-700">Penawaran Terbatas</span>
                        </label>
                    </div>
                    
                    <!-- Status Aktif -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm font-semibold text-gray-700">Produk Aktif</span>
                        </label>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="flex items-center gap-4">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i>Simpan Produk
                        </button>
                        <a href="{{ route('products.manage', $weddingOrganizer->slug) }}" class="px-6 py-3 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    </div>
                    
                </form>
                
            </div>
            
        </div>
    </div>
</section>
@endsection

@push('styles')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    // Initialize Quill editor
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link'],
                ['clean']
            ]
        },
        placeholder: 'Tulis deskripsi produk di sini...'
    });

    // Set initial content if any
    var description = {!! json_encode(old('description')) !!};
    if (description) {
        quill.root.innerHTML = description;
    }

    // Sync content to hidden textarea on text change
    quill.on('text-change', function() {
        document.getElementById('description').value = quill.root.innerHTML;
    });

    // Also update on form submit (backup)
    document.querySelector('form').addEventListener('submit', function(e) {
        document.getElementById('description').value = quill.root.innerHTML;
    });

    // Calculate discount automatically
    function calculateDiscount() {
        const originalPrice = parseFloat(document.getElementById('original_price').value) || 0;
        const salePrice = parseFloat(document.getElementById('price').value) || 0;
        const discount = originalPrice - salePrice;
        
        const discountValue = discount >= 0 ? discount : 0;
        document.getElementById('discount').value = discountValue.toFixed(2);
        document.getElementById('discount_display').value = formatNumber(discountValue);
    }

    // Format currency input with thousand separator
    function formatCurrency(element, hiddenFieldId) {
        let value = element.value.replace(/\./g, ''); // Remove dots
        value = value.replace(/[^0-9]/g, ''); // Remove non-numeric
        
        // Store raw number in hidden field
        document.getElementById(hiddenFieldId).value = value;
        
        // Format with thousand separator
        if (value) {
            element.value = formatNumber(value);
        } else {
            element.value = '';
        }
        
        // Recalculate discount
        calculateDiscount();
    }

    // Format number with thousand separator (dot)
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Calculate on page load
    window.addEventListener('load', function() {
        calculateDiscount();
    });
</script>
@endpush
