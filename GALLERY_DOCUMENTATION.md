# Gallery Foto HASTANA Indonesia

## Overview

Website HASTANA Indonesia kini menggunakan gallery foto sederhana yang menampilkan momen-momen terbaik dan karya menawan dari anggota wedding organizer HASTANA Indonesia.

## Fitur Gallery

### 🖼️ **Photo Grid Layout**

-   Grid responsif dengan 4 kolom di desktop, 2 kolom di tablet, 1 kolom di mobile
-   8 foto gallery dengan berbagai tema pernikahan
-   Hover effects yang smooth dengan animasi scale dan overlay

### 🎨 **Visual Design**

-   **Card Design**: Rounded corners dengan shadow yang elegan
-   **Hover Effects**:
    -   Transform translateY untuk efek angkat
    -   Scale image saat hover
    -   Gradient overlay dengan informasi foto
    -   Search icon di pojok kanan atas

### 📱 **Responsive Design**

-   Mobile-first approach
-   Lazy loading untuk performa optimal
-   Touch-friendly pada mobile device

## Foto yang Ditampilkan

Gallery menampilkan 8 kategori foto pernikahan:

1. **Setup Ballroom Mewah** - Dekorasi ballroom untuk resepsi pernikahan
2. **Akad Nikah Tradisional** - Upacara akad nikah yang khidmat
3. **Garden Wedding** - Pernikahan outdoor di taman yang indah
4. **Behind The Scenes** - Proses persiapan dekorasi pernikahan
5. **Table Setting Elegan** - Penataan meja untuk perjamuan
6. **Busana Tradisional** - Pengantin dengan busana adat Indonesia
7. **Konsultasi Pernikahan** - Sesi planning dengan wedding organizer
8. **Dekorasi Venue** - Setup dekorasi venue pernikahan

## Technical Implementation

### CSS Classes

```css
.gallery-item - Main container untuk setiap foto
.gallery-item:hover - Hover state dengan transform dan shadow
.gallery-item img - Image dengan transition
.gallery-item:hover img - Scale effect saat hover
```

### Image Sources

Menggunakan Unsplash API dengan parameter:

-   Ukuran: 400x400 pixels
-   Crop: center
-   Format: optimized untuk web

### Lazy Loading

Semua images menggunakan `loading="lazy"` untuk performa optimal.

## Customization

### Mengganti Foto

Untuk mengganti foto dalam gallery, edit file:
`resources/views/front/home.blade.php`

Cari bagian `<!-- Gallery Section -->` dan update:

1. **URL gambar**: Ganti `src` dengan URL gambar baru
2. **Alt text**: Update `alt` attribute untuk SEO
3. **Title & Description**: Update konten dalam overlay

### Menambah/Mengurangi Foto

Untuk menambah foto baru, copy salah satu `<!-- Gallery Item -->` dan sesuaikan:

-   URL gambar
-   Alt text
-   Title dan description
-   Pastikan total grid tetap seimbang

### Mengubah Layout

Grid layout dapat diubah dengan memodifikasi class:

```html
<!-- Current: 1 col mobile, 2 col tablet, 4 col desktop -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Alternative: 1 col mobile, 3 col tablet, 6 col desktop -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4"></div>
</div>
```

## Benefits

### ✅ **Keunggulan Gallery Foto**

1. **Sederhana & Reliable** - Tidak bergantung pada API eksternal
2. **Fast Loading** - Gambar dioptimasi dengan lazy loading
3. **SEO Friendly** - Alt text dan structured data
4. **Easy Maintenance** - Edit langsung di code, tanpa setup kompleks
5. **Custom Control** - Full control atas konten dan layout

### 🎯 **User Experience**

-   Visual yang menarik dengan hover effects
-   Loading cepat dengan lazy loading
-   Responsive di semua device
-   Informasi foto yang jelas
-   Call-to-action yang prominent

## Future Enhancements

### Possible Improvements

1. **Lightbox Modal**

    - Implementasi modal untuk view foto full-size
    - Navigation antar foto dalam modal
    - Zoom functionality

2. **Dynamic Gallery**

    - Integrasi dengan database
    - Admin panel untuk upload/manage foto
    - Categories dan filtering

3. **Performance**

    - WebP format support
    - Progressive loading
    - CDN integration

4. **Social Features**
    - Share buttons
    - Like/favorite functionality
    - Comments system

## Maintenance

### Regular Updates

-   Ganti foto secara berkala untuk konten fresh
-   Update alt text untuk SEO
-   Monitor performance dan loading speed
-   Test responsiveness di berbagai device

### Performance Monitoring

```bash
# Check image optimization
php artisan optimize

# Clear caches
php artisan cache:clear
php artisan view:clear
```

---

Gallery foto ini memberikan pengalaman visual yang menarik tanpa kompleksitas integrasi API, memastikan website HASTANA Indonesia tetap cepat, reliable, dan mudah di-maintain.
