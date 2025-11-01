@extends('layouts.app')

@section('title', 'Edit Produk - HASTANA Indonesia')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16 mt-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold mb-2">Edit Produk</h1>
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
                
                <form action="{{ route('products.update', [$weddingOrganizer->slug, $product->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Nama Produk -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    
                    <!-- Deskripsi -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                        <div id="editor" style="height: 300px;"></div>
                        <textarea name="description" id="description" style="display: none;">{{ old('description', $product->description) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Gunakan editor untuk memformat deskripsi produk</p>
                    </div>
                    
                    <!-- Harga Asli -->
                    <div class="mb-6">
                        <label for="original_price" class="block text-sm font-semibold text-gray-700 mb-2">Harga Asli (IDR) <span class="text-red-500">*</span></label>
                        <input type="text" name="original_price_display" id="original_price_display" value="{{ old('original_price', number_format($product->original_price, 0, ',', '.')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required oninput="formatCurrency(this, 'original_price')">
                        <input type="hidden" name="original_price" id="original_price">
                        <p class="text-xs text-gray-500 mt-1">Contoh: 50.000.000</p>
                    </div>
                    
                    <!-- Harga Jual -->
                    <div class="mb-6">
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Harga Jual (IDR) <span class="text-red-500">*</span></label>
                        <input type="text" name="price_display" id="price_display" value="{{ old('price', number_format($product->price, 0, ',', '.')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required oninput="formatCurrency(this, 'price')">
                        <input type="hidden" name="price" id="price">
                        <p class="text-xs text-gray-500 mt-1">Contoh: 45.000.000</p>
                    </div>
                    
                    <!-- Diskon -->
                    <div class="mb-6">
                        <label for="discount" class="block text-sm font-semibold text-gray-700 mb-2">Diskon (IDR)</label>
                        <input type="text" name="discount_display" id="discount_display" value="{{ old('discount', number_format($product->discount, 0, ',', '.')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" readonly>
                        <input type="hidden" name="discount" id="discount">
                        <p class="text-xs text-gray-500 mt-1">Otomatis dihitung: Harga Asli - Harga Jual</p>
                    </div>
                    
                    <!-- Badges -->
                    <div class="mb-6">
                        <label for="badges" class="block text-sm font-semibold text-gray-700 mb-2">Badges</label>
                        <input type="text" name="badges" id="badges" value="{{ old('badges', is_array($product->badges) ? implode(', ', $product->badges) : $product->badges) }}" placeholder="Pisahkan dengan koma (contoh: Best Seller, Promo)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Masukkan badge dan pisahkan dengan koma</p>
                    </div>
                    
                    <!-- Gambar Produk -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk</label>
                        
                        @if($product->images && count($product->images) > 0)
                            <div class="mb-4">
                                <p class="text-xs text-gray-600 mb-2">Gambar yang sudah diupload:</p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    @foreach($product->images as $index => $image)
                                        <div class="relative group" id="image-{{ $index }}">
                                            @php
                                                $imageUrl = str_starts_with($image, 'http') 
                                                    ? $image 
                                                    : Storage::url($image);
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="Product Image {{ $index + 1 }}" class="w-full h-32 object-cover rounded-lg border-2 border-gray-300">
                                            <div class="absolute top-1 left-1 bg-blue-600 text-white text-xs px-2 py-0.5 rounded">
                                                {{ $index + 1 }}
                                            </div>
                                            @if($index === 0)
                                                <div class="absolute top-1 right-1 bg-green-600 text-white text-xs px-2 py-0.5 rounded">
                                                    Utama
                                                </div>
                                            @endif
                                            <!-- Delete Button -->
                                            <button type="button" onclick="deleteImage({{ $index }}, '{{ addslashes($image) }}')" class="absolute bottom-1 right-1 bg-red-600 hover:bg-red-700 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                                <i class="fas fa-trash text-[10px]"></i> Hapus
                                            </button>
                                            <input type="hidden" name="existing_images[]" value="{{ $image }}">
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Total: <span id="image-count">{{ count($product->images) }}</span> gambar</p>
                            </div>
                        @endif
                        
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar Tambahan (Opsional)</label>
                        <input type="file" name="images[]" id="images" accept="image/*" multiple class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">
                            Format: JPG, JPEG, PNG (Max: 2MB per file). Pilih beberapa file sekaligus jika ingin upload banyak gambar.
                        </p>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-2">
                            <p class="text-xs text-blue-800">
                                <i class="fas fa-info-circle mr-1"></i> <strong>Cara Kerja:</strong>
                            </p>
                            <ul class="text-xs text-blue-700 mt-1 ml-4 list-disc space-y-1">
                                <li>Gambar yang sudah ada akan <strong>tetap disimpan</strong></li>
                                <li>Upload gambar baru akan <strong>ditambahkan</strong> ke gambar yang sudah ada</li>
                                <li>Untuk menghapus gambar, klik tombol <strong>"Hapus"</strong> saat hover pada gambar</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Limited Offer -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="limited_offer" id="limited_offer" value="1" {{ old('limited_offer', $product->limited_offer) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm font-semibold text-gray-700">Penawaran Terbatas</span>
                        </label>
                    </div>
                    
                    <!-- Status Aktif -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm font-semibold text-gray-700">Produk Aktif</span>
                        </label>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="flex items-center gap-4">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i>Update Produk
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

    // Set initial content
    var description = {!! json_encode(old('description', $product->description)) !!};
    quill.root.innerHTML = description || '';

    // Sync content to hidden textarea on text change
    quill.on('text-change', function() {
        document.getElementById('description').value = quill.root.innerHTML;
    });

    // Also update on form submit (backup)
    document.querySelector('form').addEventListener('submit', function(e) {
        document.getElementById('description').value = quill.root.innerHTML;
    });

    // Delete image function
    function deleteImage(index, imagePath) {
        if (!confirm('Yakin ingin menghapus gambar ini?')) {
            return;
        }

        // Hide the image container
        const imageContainer = document.getElementById('image-' + index);
        if (imageContainer) {
            imageContainer.style.display = 'none';
            
            // Remove the hidden input so image won't be saved
            const hiddenInput = imageContainer.querySelector('input[name="existing_images[]"]');
            if (hiddenInput) {
                hiddenInput.remove();
            }
            
            // Update image count
            const countElement = document.getElementById('image-count');
            if (countElement) {
                const currentCount = parseInt(countElement.textContent);
                countElement.textContent = currentCount - 1;
            }
        }
    }

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
        // Set initial hidden values
        const originalPriceDisplay = document.getElementById('original_price_display').value;
        const priceDisplay = document.getElementById('price_display').value;
        
        document.getElementById('original_price').value = originalPriceDisplay.replace(/\./g, '');
        document.getElementById('price').value = priceDisplay.replace(/\./g, '');
        
        calculateDiscount();
    });
</script>
@endpush
