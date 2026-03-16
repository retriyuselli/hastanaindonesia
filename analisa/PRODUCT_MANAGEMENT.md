# Product Management - HASTANA Indonesia

## Overview

System untuk mengelola produk/paket wedding organizer.

## Database Structure

### Tabel: `products`

```sql
- id (primary key)
- wedding_organizer_id (foreign key to wedding_organizers)
- name (string) - Nama produk
- slug (string, unique) - URL friendly name
- description (text) - Deskripsi produk
- original_price (decimal) - Harga asli
- price (decimal) - Harga setelah diskon
- discount (decimal) - Jumlah diskon (auto calculated)
- images (json) - Array gambar produk
- features (json) - Array fitur/benefit
- badges (json) - Array badge (FREE PREWED, BEST DEAL, etc)
- limited_offer (boolean) - Penawaran terbatas
- is_active (boolean) - Status aktif
- sort_order (integer) - Urutan tampilan
- timestamps
- soft_deletes
```

## Model: Product

### Fillable Fields

```php
'wedding_organizer_id',
'name',
'slug',
'description',
'original_price',
'price',
'discount',
'images',
'features',
'badges',
'limited_offer',
'is_active',
'sort_order',
```

### Auto Features

-   **Auto Slug**: Otomatis generate slug dari name
-   **Auto Discount**: Otomatis hitung discount dari original_price - price
-   **Main Image Accessor**: `$product->main_image` - Mengambil gambar pertama
-   **Discount Percentage**: `$product->discount_percentage` - Persentase diskon

### Relationships

```php
// Get wedding organizer
$product->weddingOrganizer

// Get products dari wedding organizer
$weddingOrganizer->products
$weddingOrganizer->activeProducts
```

### Scopes

```php
Product::active()->get(); // Produk aktif saja
Product::limitedOffer()->get(); // Penawaran terbatas saja
```

## Cara Menambah Product

### 1. Via Tinker

```bash
php artisan tinker
```

```php
use App\Models\Product;

Product::create([
    'wedding_organizer_id' => 1,
    'name' => 'Wedding Package Premium',
    'description' => 'Paket pernikahan premium dengan berbagai fasilitas lengkap',
    'original_price' => 25000000,
    'price' => 11500000,
    'images' => [
        'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=800&fit=crop',
        'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=800&h=800&fit=crop',
        'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800&h=800&fit=crop',
    ],
    'features' => [
        'Wedding Organizer & Coordinator',
        'Dekorasi Pelaminan Premium',
        'Dokumentasi Foto (500+ foto)',
        'Video Cinematic HD',
        'Make Up Pengantin & Keluarga',
        'Prewedding Indoor/Outdoor',
        'Undangan Digital & Cetak',
        'MC Profesional',
    ],
    'badges' => ['FREE PREWED', 'BEST DEAL'],
    'limited_offer' => true,
    'is_active' => true,
    'sort_order' => 1
]);
```

### 2. Via Seeder

Buat file seeder:

```bash
php artisan make:seeder ProductSeeder
```

Edit `database/seeders/ProductSeeder.php`:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\WeddingOrganizer;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $organizers = WeddingOrganizer::all();

        foreach ($organizers as $organizer) {
            // Product 1
            Product::create([
                'wedding_organizer_id' => $organizer->id,
                'name' => 'Wedding Package Premium',
                'description' => 'Paket pernikahan premium dengan berbagai fasilitas lengkap untuk mewujudkan pernikahan impian Anda.',
                'original_price' => 25000000,
                'price' => 11500000,
                'images' => [
                    'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800&h=800&fit=crop',
                ],
                'features' => [
                    'Wedding Organizer & Coordinator',
                    'Dekorasi Pelaminan Premium',
                    'Dokumentasi Foto (500+ foto)',
                    'Video Cinematic HD',
                    'Make Up Pengantin & Keluarga',
                    'Prewedding Indoor/Outdoor',
                    'Undangan Digital & Cetak',
                    'MC Profesional',
                ],
                'badges' => ['FREE PREWED', 'BEST DEAL'],
                'limited_offer' => true,
                'is_active' => true,
                'sort_order' => 1
            ]);

            // Product 2
            Product::create([
                'wedding_organizer_id' => $organizer->id,
                'name' => 'Wedding Package Silver',
                'description' => 'Paket pernikahan yang cocok untuk acara intimate dengan keluarga dan teman dekat.',
                'original_price' => 18000000,
                'price' => 8500000,
                'images' => [
                    'https://images.unsplash.com/photo-1606800052052-a08af7148866?w=800&h=800&fit=crop',
                ],
                'features' => [
                    'Wedding Organizer',
                    'Dekorasi Pelaminan',
                    'Dokumentasi Foto (300+ foto)',
                    'Video Cinematic',
                    'Make Up Pengantin',
                ],
                'badges' => ['BEST VALUE'],
                'limited_offer' => false,
                'is_active' => true,
                'sort_order' => 2
            ]);
        }
    }
}
```

Jalankan seeder:

```bash
php artisan db:seed --class=ProductSeeder
```

## Routes

```php
// Lihat detail product
GET /anggota/{id}/product/{productId}
Route name: members.product
```

## Views

-   `resources/views/front/member-detail.blade.php` - Tampil list products di tab Store
-   `resources/views/front/product-detail.blade.php` - Halaman detail product

## Filament Resource (Optional)

Untuk mengelola products via admin panel, bisa buat Filament Resource:

```bash
php artisan make:filament-resource Product --generate
```

## Upload Images

Untuk upload gambar real (bukan URL):

1. Simpan di storage:

```php
$path = $request->file('image')->store('products', 'public');
```

2. Simpan path di database:

```php
'images' => ['products/image-name.jpg']
```

3. Tampilkan di view:

```blade
<img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}">
```

## Notes

-   Discount otomatis dihitung dari `original_price - price`
-   Slug otomatis generate dari name
-   Main image adalah gambar pertama di array images
-   Product hanya tampil jika `is_active = true`
-   Products diurutkan berdasarkan `sort_order`
