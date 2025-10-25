# 📝 Dokumentasi Form Pendaftaran Wedding Organizer

**Tanggal:** 23 Oktober 2025  
**Status:** ✅ Ready to Use

## 📋 Ringkasan

Form pendaftaran untuk Wedding Organizer telah berhasil disederhanakan dan disesuaikan dengan model `WeddingOrganizer`. Form sekarang hanya meminta data penting untuk proses pendaftaran awal, dengan dokumen lengkap dapat dilengkapi kemudian melalui dashboard admin.

---

## 🎯 URL dan Routes

| Method | URL          | Route Name   | Controller             |
| ------ | ------------ | ------------ | ---------------------- |
| GET    | `/bergabung` | `join`       | `JoinController@index` |
| POST   | `/bergabung` | `join.store` | `JoinController@store` |

---

## 📝 Field Form

### ✅ **Required Fields (11 fields)**

| No  | Field Name         | Type     | Validation                                     | Contoh                                |
| --- | ------------------ | -------- | ---------------------------------------------- | ------------------------------------- |
| 1   | `organizer_name`   | Text     | required, max:255                              | "Elegant Wedding Organizer"           |
| 2   | `email`            | Email    | required, unique, email                        | "info@elegantwedding.com"             |
| 3   | `phone`            | Tel      | required, max:20                               | "081234567890"                        |
| 4   | `established_year` | Number   | required, 1990-2025                            | "2020"                                |
| 5   | `business_type`    | Select   | required, in:Perorangan,CV,PT,Koperasi,Lainnya | "PT"                                  |
| 6   | `address`          | Textarea | required                                       | "Jl. Wedding Street No. 123"          |
| 7   | `city`             | Text     | required, max:100                              | "Jakarta"                             |
| 8   | `province`         | Select   | required                                       | "DKI Jakarta"                         |
| 9   | `description`      | Textarea | required, min:50                               | Deskripsi singkat WO                  |
| 10  | `specializations`  | Textarea | required                                       | "Traditional Wedding, Modern Wedding" |
| 11  | `business_license` | Text     | required, max:100                              | "1234567890123456"                    |
| 12  | `terms`            | Checkbox | required, accepted                             | checked                               |

### 🔹 **Optional Fields (4 fields)**

| No  | Field Name    | Type     | Validation             | Contoh                           |
| --- | ------------- | -------- | ---------------------- | -------------------------------- |
| 1   | `brand_name`  | Text     | nullable, max:255      | "Elegant WO"                     |
| 2   | `postal_code` | Text     | nullable, max:10       | "12345"                          |
| 3   | `website`     | URL      | nullable, url, max:255 | "https://www.elegantwedding.com" |
| 4   | `instagram`   | Text     | nullable, max:100      | "elegantwedding" (tanpa @)       |
| 5   | `newsletter`  | Checkbox | nullable, boolean      | checked/unchecked                |

---

## 🎨 Fitur Form

### 1. **Validasi Real-time**

-   ✅ Field wajib ditandai dengan asterisk (\*)
-   ✅ Error message ditampilkan per field dengan border merah
-   ✅ Error summary ditampilkan di atas form
-   ✅ Old values dipertahankan saat validation error

### 2. **Success & Error Notifications**

```blade
@if(session('success'))
    <!-- Green notification box -->
@endif

@if(session('error'))
    <!-- Red error box -->
@endif

@if($errors->any())
    <!-- Error list -->
@endif
```

### 3. **Auto-Processing**

Controller otomatis:

-   ✅ Generate unique slug dari `organizer_name`
-   ✅ Clean Instagram username (hapus @)
-   ✅ Convert `specializations` ke JSON array
-   ✅ Set default `is_approved = false`
-   ✅ Set default `is_active = false`
-   ✅ Set `subscribe_newsletter` dari checkbox

---

## 🔧 File yang Dimodifikasi

### 1. **Controller Baru**

📁 `app/Http/Controllers/JoinController.php`

-   Method `index()` - Tampilkan form
-   Method `store()` - Proses pendaftaran
-   Validasi lengkap dengan custom error messages
-   Error handling dengan try-catch

### 2. **Routes**

📁 `routes/web.php`

```php
use App\Http\Controllers\JoinController;

Route::get('/bergabung', [JoinController::class, 'index'])->name('join');
Route::post('/bergabung', [JoinController::class, 'store'])->name('join.store');
```

### 3. **Model Update**

📁 `app/Models/WeddingOrganizer.php`
Tambahan di `$fillable`:

-   `is_approved`
-   `is_active`
-   `subscribe_newsletter`
-   `slug`

Tambahan di `$casts`:

-   `'is_approved' => 'boolean'`
-   `'is_active' => 'boolean'`
-   `'subscribe_newsletter' => 'boolean'`

### 4. **View**

📁 `resources/views/join.blade.php`

-   ✅ Form action: `{{ route('join.store') }}`
-   ✅ Method: POST
-   ✅ CSRF Token
-   ✅ Error handling untuk setiap field
-   ✅ Old values support
-   ✅ Success/Error notifications

---

## 📊 Database Changes

Tidak ada perubahan database diperlukan. Semua field sudah tersedia di tabel `wedding_organizers`.

**Field yang TIDAK digunakan saat pendaftaran:**

-   `user_id` - akan diset saat approval admin
-   `region_id` - akan diset saat approval admin
-   `certification_level` - dilengkapi di admin panel
-   `services` - dilengkapi di admin panel
-   `price_range_min/max` - dilengkapi di admin panel
-   `completed_events` - dilengkapi di admin panel
-   `rating` - sistem rating
-   `awards` - dilengkapi di admin panel
-   `verification_status` - otomatis 'pending'
-   `is_featured` - set oleh admin
-   `npwp_number` - dilengkapi di admin panel
-   dll (dokumen legal lainnya)

---

## 🚀 Cara Menggunakan

### 1. **User mengisi form**

Akses: `http://yourdomain.com/bergabung`

### 2. **Submit form**

-   Jika berhasil: redirect ke `/bergabung` dengan success message
-   Jika gagal: kembali ke form dengan error messages dan old values

### 3. **Success Message**

```
Terima kasih telah mendaftar!
Kami akan menghubungi Anda dalam 3-5 hari kerja untuk proses verifikasi.
```

### 4. **Admin Process**

-   Admin akan melihat pendaftaran baru di Filament Admin
-   Status awal: `is_approved = false`, `is_active = false`
-   Admin dapat approve dan melengkapi data di admin panel

---

## 🔒 Security Features

1. **CSRF Protection** - Token Laravel
2. **Email Uniqueness** - Cek duplicate email
3. **Input Validation** - Server-side validation lengkap
4. **XSS Protection** - Blade escaping otomatis
5. **Error Logging** - Log error untuk debugging

---

## 📝 Custom Error Messages (Bahasa Indonesia)

```php
'organizer_name.required' => 'Nama Wedding Organizer wajib diisi'
'email.unique' => 'Email sudah terdaftar, gunakan email lain'
'description.min' => 'Deskripsi minimal 50 karakter'
'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan'
// ... dan lainnya
```

---

## 🎯 Next Steps

1. ✅ Form sudah siap digunakan
2. ⏳ Buat Filament Resource untuk approval admin
3. ⏳ Setup email notification untuk admin saat ada pendaftaran baru
4. ⏳ Setup email confirmation untuk user
5. ⏳ Buat dashboard untuk pending registrations

---

## 🧪 Testing

### Manual Testing Checklist:

-   [ ] Akses halaman `/bergabung`
-   [ ] Submit form kosong (cek validasi required)
-   [ ] Submit dengan email invalid
-   [ ] Submit dengan email duplicate
-   [ ] Submit dengan description < 50 karakter
-   [ ] Submit form lengkap dan valid
-   [ ] Cek data tersimpan di database
-   [ ] Cek success message muncul
-   [ ] Cek old values bertahan saat ada error

---

## 📞 Provinsi yang Tersedia

Dropdown provinsi include:

1. DKI Jakarta
2. Jawa Barat
3. Jawa Tengah
4. Jawa Timur
5. Bali
6. Sumatera Utara
7. Sumatera Barat
8. Sumatera Selatan
9. Kalimantan Timur
10. Sulawesi Selatan

_(Dapat ditambah sesuai kebutuhan)_

---

## 💡 Tips

1. **Instagram Username**: User input dengan/tanpa @ sama-sama diterima (auto-clean)
2. **Specializations**: Pisahkan dengan koma, akan otomatis diconvert ke JSON array
3. **Slug**: Auto-generate dari organizer_name, unique guaranteed
4. **Year Validation**: Min 1990, Max tahun sekarang (2025)

---

**Status:** ✅ **Production Ready**
