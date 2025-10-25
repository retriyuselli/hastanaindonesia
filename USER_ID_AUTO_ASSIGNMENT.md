# Auto Assignment user_id untuk Wedding Organizer

## Ringkasan Perubahan

Sistem pendaftaran Wedding Organizer telah diupdate agar `user_id` secara otomatis diisi dengan ID user yang sedang login/aktif.

## Perubahan yang Dilakukan

### 1. Route Protection (routes/web.php)

-   ✅ Route `/bergabung` sekarang dilindungi dengan middleware `auth`
-   ✅ Hanya user yang sudah login yang bisa mengakses form pendaftaran
-   ✅ User yang belum login akan diarahkan ke halaman login

```php
// Join/Registration routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/bergabung', [JoinController::class, 'index'])->name('join');
    Route::post('/bergabung', [JoinController::class, 'store'])->name('join.store');
});
```

### 2. JoinController Updates

#### a. Import Auth Facade

```php
use Illuminate\Support\Facades\Auth;
```

#### b. Validasi User Sudah Terdaftar

Menambahkan pengecekan di method `index()` dan `store()`:

```php
// Check if user already has a wedding organizer
if (Auth::check() && WeddingOrganizer::where('user_id', Auth::id())->exists()) {
    return redirect()
        ->route('home')
        ->with('error', 'Anda sudah terdaftar sebagai Wedding Organizer.');
}
```

#### c. Auto-assign user_id

Di method `store()`, sebelum create:

```php
// Set default values
$validated['user_id'] = Auth::id(); // Set user_id to currently logged in user
$validated['is_approved'] = false; // Menunggu approval admin
$validated['is_active'] = false; // Akan diaktifkan setelah approval
$validated['subscribe_newsletter'] = $request->boolean('newsletter');
```

### 3. View Update (resources/views/join.blade.php)

Menambahkan informasi user yang sedang login di bagian atas form:

```blade
@auth
<div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 rounded-lg p-4 flex items-start">
    <i class="fas fa-user-circle text-blue-600 text-xl mr-3 mt-1"></i>
    <div class="flex-1">
        <h4 class="font-semibold mb-1">Pendaftaran atas nama:</h4>
        <p class="text-sm">
            <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})
        </p>
        <p class="text-xs mt-2 text-blue-600">
            <i class="fas fa-info-circle mr-1"></i>
            Wedding organizer yang Anda daftarkan akan terhubung dengan akun Anda
        </p>
    </div>
</div>
@endauth
```

### 4. Database Migration

Migration: `2025_10_23_095543_make_user_id_nullable_in_wedding_organizers_table.php`

-   ✅ `region_id` dibuat nullable (akan diisi admin saat approval)
-   ✅ `user_id` tetap NOT NULL (selalu terisi dari user yang login)

```php
public function up(): void
{
    // Make region_id nullable because it will be assigned by admin during approval
    // user_id is no longer nullable as it's automatically filled from authenticated user
    DB::statement('ALTER TABLE wedding_organizers MODIFY COLUMN region_id BIGINT UNSIGNED NULL');
}
```

### 5. Filament Form Update

File: `app/Filament/Admin/Resources/WeddingOrganizers/Schemas/WeddingOrganizerForm.php`

-   ✅ `region_id` field diubah dari `required()` menjadi `nullable()`
-   ✅ Helper text diupdate untuk menjelaskan bahwa region_id diisi oleh admin

```php
Select::make('region_id')
    ->label('Wilayah')
    ->options(Region::pluck('region_name', 'id'))
    ->nullable()
    ->searchable()
    ->placeholder('Pilih wilayah')
    ->helperText('Wilayah operasional wedding organizer (akan diisi oleh admin)'),
```

## Workflow Baru

### Untuk Member (Public)

1. User harus **login terlebih dahulu**
2. Akses halaman `/bergabung`
3. Sistem menampilkan info user yang sedang login
4. Sistem otomatis mengecek apakah user sudah pernah mendaftar
    - Jika sudah: redirect ke home dengan pesan error
    - Jika belum: tampilkan form pendaftaran
5. Isi form pendaftaran (tanpa perlu input user_id)
6. Submit form
7. Sistem otomatis mengisi `user_id` dengan ID user yang login
8. Data tersimpan dengan status:
    - `user_id`: ID user yang login
    - `is_approved`: false
    - `is_active`: false
    - `region_id`: null (akan diisi admin)

### Untuk Admin (Filament)

1. Admin melihat pendaftaran baru di Filament
2. Admin melakukan verifikasi data
3. Admin mengisi `region_id` (wilayah operasional)
4. Admin mengubah:
    - `is_approved`: true
    - `is_active`: true
5. Wedding Organizer sudah aktif dan bisa menggunakan sistem

## Keuntungan Sistem Baru

### 1. Keamanan

-   ✅ Hanya user terautentikasi yang bisa mendaftar
-   ✅ Mencegah spam dan pendaftaran palsu
-   ✅ Satu user hanya bisa memiliki satu wedding organizer

### 2. Traceability

-   ✅ Setiap wedding organizer terhubung dengan user account
-   ✅ Mudah tracking siapa yang mendaftar
-   ✅ Memudahkan komunikasi via email user

### 3. User Experience

-   ✅ User tidak perlu input data user_id (otomatis)
-   ✅ Info user yang login ditampilkan jelas
-   ✅ Validasi duplikasi otomatis
-   ✅ Pesan error yang jelas

### 4. Admin Management

-   ✅ Admin bisa lihat user yang terkait dengan wedding organizer
-   ✅ Admin bisa assign region setelah verifikasi
-   ✅ Proses approval lebih terstruktur

## Testing

### Test Case 1: User Belum Login

**Expected Result:** Redirect ke halaman login

```
1. Buka http://localhost:8001/bergabung (tanpa login)
2. Sistem redirect ke /login
```

### Test Case 2: User Sudah Login, Belum Punya Wedding Organizer

**Expected Result:** Form pendaftaran ditampilkan dengan info user

```
1. Login sebagai user
2. Buka http://localhost:8001/bergabung
3. Lihat info user di bagian atas form (nama dan email)
4. Isi form pendaftaran
5. Submit
6. Data tersimpan dengan user_id = ID user yang login
```

### Test Case 3: User Sudah Punya Wedding Organizer

**Expected Result:** Redirect ke home dengan pesan error

```
1. Login sebagai user yang sudah punya wedding organizer
2. Buka http://localhost:8001/bergabung
3. Sistem redirect ke home
4. Muncul pesan: "Anda sudah terdaftar sebagai Wedding Organizer."
```

### Test Case 4: Admin Membuat Wedding Organizer di Filament

**Expected Result:** Admin bisa pilih user_id dan region_id opsional

```
1. Login ke Filament sebagai admin
2. Buka menu Wedding Organizers → Create
3. Pilih user_id dari dropdown
4. Region_id bersifat opsional (bisa diisi nanti)
5. Isi data lainnya
6. Save
```

## File yang Dimodifikasi

1. ✅ `routes/web.php` - Tambah middleware auth
2. ✅ `app/Http/Controllers/JoinController.php` - Auto-assign user_id dan validasi duplikasi
3. ✅ `resources/views/join.blade.php` - Tampilkan info user yang login
4. ✅ `app/Filament/Admin/Resources/WeddingOrganizers/Schemas/WeddingOrganizerForm.php` - Update region_id nullable
5. ✅ `database/migrations/2025_10_23_095543_make_user_id_nullable_in_wedding_organizers_table.php` - Migration region_id nullable

## Migration yang Dijalankan

```bash
php artisan migrate
```

Status: ✅ **COMPLETED** (2025_10_23_095543_make_user_id_nullable_in_wedding_organizers_table - 49.78ms)

## Catatan Penting

1. **User harus login dulu** sebelum bisa mengakses form pendaftaran
2. **Satu user = satu wedding organizer** (tidak bisa duplikat)
3. **user_id otomatis terisi** dari Auth::id()
4. **region_id nullable** karena diisi admin saat approval
5. **Email validation** tetap unique per wedding organizer (bukan per user)

## Dokumentasi Terkait

-   BLOG_ENGAGEMENT_DOCUMENTATION.md
-   BLOG_SEEDER_DOCUMENTATION.md
-   TEMPLATE_SYSTEM_DOCUMENTATION.md
-   NEGO_VENDOR_TRACKING_GUIDE.md

---

**Created:** October 23, 2025
**Status:** ✅ Implemented & Tested
**Version:** 1.0
