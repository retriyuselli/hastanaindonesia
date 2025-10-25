# Wedding Organizer Registration Form - Complete Fields

## Daftar Field yang Telah Ditambahkan ke Form join.blade.php

### ✅ Field yang Sudah Ada Sebelumnya (Required)

1. **organizer_name** - Nama Wedding Organizer
2. **email** - Email
3. **phone** - Nomor Telepon
4. **established_year** - Tahun Berdiri
5. **business_type** - Jenis Usaha (Perorangan, CV, PT, dll)
6. **address** - Alamat Lengkap
7. **city** - Kota (dependent dropdown)
8. **province** - Provinsi
9. **description** - Deskripsi (min 50 karakter)
10. **specializations** - Spesialisasi (comma-separated)
11. **business_license** - Nomor Izin Usaha

### ✅ Field yang Sudah Ada Sebelumnya (Optional)

1. **brand_name** - Nama Brand/PT/CV
2. **postal_code** - Kode Pos
3. **website** - Website
4. **instagram** - Instagram Handle

---

## 🆕 Field Baru yang Ditambahkan (October 23, 2025)

### 1. **services** (Nullable/Optional)

-   **Type:** Textarea
-   **Format:** Comma-separated
-   **Placeholder:** "Full Planning, Decoration, Catering Coordination, Photography, Videography, etc"
-   **Validation:** `nullable|string`
-   **Storage:** JSON array
-   **Description:** Layanan spesifik yang ditawarkan oleh wedding organizer

### 2. **price_range_min** (Nullable/Optional)

-   **Type:** Number input
-   **Prefix:** Rp
-   **Placeholder:** "50000000"
-   **Validation:** `nullable|numeric|min:0`
-   **Description:** Harga minimum paket wedding organizer
-   **Example:** 50.000.000 (50 juta)

### 3. **price_range_max** (Nullable/Optional)

-   **Type:** Number input
-   **Prefix:** Rp
-   **Placeholder:** "500000000"
-   **Validation:** `nullable|numeric|min:0|gte:price_range_min`
-   **Description:** Harga maksimum paket wedding organizer
-   **Example:** 500.000.000 (500 juta)
-   **Note:** Harus lebih besar atau sama dengan price_range_min

### 4. **completed_events** (Nullable/Optional)

-   **Type:** Number input
-   **Default:** 0
-   **Placeholder:** "25"
-   **Validation:** `nullable|integer|min:0`
-   **Description:** Total jumlah acara pernikahan yang sudah ditangani
-   **Example:** 25 events

### 5. **awards** (Nullable/Optional)

-   **Type:** Textarea
-   **Rows:** 2
-   **Placeholder:** "Best Wedding Organizer 2023, TOP 10 WO Indonesia 2022, dll"
-   **Validation:** `nullable|string`
-   **Description:** Daftar penghargaan yang pernah diterima
-   **Example:** "Best Wedding Organizer Jakarta 2023, Indonesia Wedding Vendor Award 2022"

### 6. **certification_level** (Nullable/Optional)

-   **Type:** Select dropdown
-   **Options:** Dari config `indonesia.certification_levels`
    -   `basic` → 🥉 Basic
    -   `intermediate` → 🥈 Intermediate
    -   `advanced` → 🥇 Advanced
    -   `expert` → 💎 Expert
-   **Validation:** `nullable|string|in:basic,intermediate,advanced,expert`
-   **Description:** Level sertifikasi kompetensi yang akan dinilai oleh tim HASTANA
-   **Default:** Kosong (akan diisi setelah penilaian admin)

### 7. **legal_documents** (Nullable/Optional)

-   **Type:** File upload (multiple)
-   **Accept:** `.pdf, .jpg, .jpeg, .png`
-   **Max Size:** 5MB per file
-   **Validation:** `nullable|array` dan `nullable|file|mimes:pdf,jpg,jpeg,png|max:5120`
-   **Storage:** `public/wedding-organizer-documents/`
-   **Format:** JSON array of file paths
-   **Description:** Upload dokumen legal seperti NIB, NPWP, Akta Pendirian, KTP
-   **Note:** Opsional saat pendaftaran, bisa dilengkapi nanti via admin panel

---

## 📋 Field yang TIDAK Ditambahkan ke Public Form (Admin Only)

Field-field berikut **HANYA** tersedia di Filament Admin Panel, tidak di form public:

1. **region_id** - Akan diisi oleh admin saat approval
2. **rating** - Dikelola sistem berdasarkan review
3. **verification_status** - Diatur oleh admin (pending/verified/rejected)
4. **is_featured** - Diatur oleh admin
5. **status** - Diatur oleh admin (active/inactive/suspended)
6. **verified_at** - Timestamp otomatis saat verifikasi
7. **verified_by** - User ID admin yang verifikasi
8. **legal_entity_type** - Detail badan usaha (admin)
9. **deed_of_establishment** - Nomor akta pendirian (admin)
10. **deed_date** - Tanggal akta (admin)
11. **notary_name** - Nama notaris (admin)
12. **notary_license_number** - Nomor izin notaris (admin)
13. **nib_number** - Nomor NIB detail (admin)
14. **nib_issued_date** - Tanggal terbit NIB (admin)
15. **nib_valid_until** - NIB berlaku sampai (admin)
16. **npwp_number** - Nomor NPWP detail (admin)
17. **npwp_issued_date** - Tanggal terbit NPWP (admin)
18. **tax_office** - Kantor pajak (admin)
19. **legal_document_status** - Status dokumen legal (admin)
20. **legal_document_notes** - Catatan reviewer (admin)
21. **legal_verified_at** - Timestamp verifikasi legal (admin)
22. **legal_verified_by** - Admin yang verifikasi legal (admin)

---

## 🔄 Data Processing di Controller

### JoinController::store() Processing

```php
// 1. Clean Instagram handle
if (!empty($validated['instagram'])) {
    $validated['instagram'] = ltrim($validated['instagram'], '@');
}

// 2. Convert specializations comma-separated to JSON array
$specializations = array_map('trim', explode(',', $validated['specializations']));
$validated['specializations'] = json_encode($specializations);

// 3. Convert services comma-separated to JSON array
if (!empty($validated['services'])) {
    $services = array_map('trim', explode(',', $validated['services']));
    $validated['services'] = json_encode($services);
}

// 4. Upload legal documents to storage
if ($request->hasFile('legal_documents')) {
    $uploadedFiles = [];
    foreach ($request->file('legal_documents') as $file) {
        $path = $file->store('wedding-organizer-documents', 'public');
        $uploadedFiles[] = $path;
    }
    $validated['legal_documents'] = json_encode($uploadedFiles);
}

// 5. Generate unique slug
$validated['slug'] = Str::slug($validated['organizer_name']);
$originalSlug = $validated['slug'];
$counter = 1;
while (WeddingOrganizer::where('slug', $validated['slug'])->exists()) {
    $validated['slug'] = $originalSlug . '-' . $counter;
    $counter++;
}

// 6. Auto-fill system values
$validated['user_id'] = Auth::id();
$validated['is_approved'] = false;
$validated['is_active'] = false;
$validated['subscribe_newsletter'] = $request->boolean('newsletter');
$validated['completed_events'] = $validated['completed_events'] ?? 0;
```

---

## 📊 Summary

### Total Fields di Public Form

-   **Required:** 11 fields
-   **Optional:** 11 fields
-   **Total:** 22 fields

### Form Sections

1. ✅ **Informasi Dasar** (7 fields)
    - organizer_name, brand_name, email, phone, established_year, business_type
2. ✅ **Informasi Lokasi** (4 fields)
    - address, province, city, postal_code
3. ✅ **Kontak & Media Sosial** (2 fields)
    - website, instagram
4. ✅ **Informasi Profesional** (8 fields)
    - description, specializations, services, price_range_min, price_range_max, completed_events, awards, certification_level
5. ✅ **Informasi Legal** (2 fields)

    - business_license, legal_documents

6. ✅ **Persetujuan** (2 fields)
    - terms (required), newsletter (optional)

---

## 🎯 Validation Rules Summary

| Field               | Required | Type           | Validation                         |
| ------------------- | -------- | -------------- | ---------------------------------- |
| organizer_name      | ✅       | string         | max:255                            |
| brand_name          | ❌       | string         | max:255                            |
| email               | ✅       | email          | unique:wedding_organizers          |
| phone               | ✅       | string         | max:20                             |
| established_year    | ✅       | integer        | min:1990, max:current_year         |
| business_type       | ✅       | string         | in:config values                   |
| address             | ✅       | string         | -                                  |
| city                | ✅       | string         | max:100                            |
| province            | ✅       | string         | max:100                            |
| postal_code         | ❌       | string         | max:10                             |
| website             | ❌       | url            | max:255                            |
| instagram           | ❌       | string         | max:100                            |
| description         | ✅       | string         | min:50                             |
| specializations     | ✅       | string         | -                                  |
| services            | ❌       | string         | -                                  |
| price_range_min     | ❌       | numeric        | min:0                              |
| price_range_max     | ❌       | numeric        | min:0, gte:price_range_min         |
| completed_events    | ❌       | integer        | min:0                              |
| awards              | ❌       | string         | -                                  |
| certification_level | ❌       | string         | in:config values                   |
| business_license    | ✅       | string         | max:100                            |
| legal_documents     | ❌       | array of files | mimes:pdf,jpg,jpeg,png, max:5120KB |
| terms               | ✅       | boolean        | accepted                           |
| newsletter          | ❌       | boolean        | -                                  |

---

## 📝 Custom Validation Messages (Bahasa Indonesia)

```php
'organizer_name.required' => 'Nama Wedding Organizer wajib diisi'
'email.unique' => 'Email sudah terdaftar, gunakan email lain'
'established_year.max' => 'Tahun berdiri tidak boleh melebihi tahun sekarang'
'business_type.required' => 'Jenis usaha wajib dipilih'
'description.min' => 'Deskripsi minimal 50 karakter'
'price_range_max.gte' => 'Harga maksimum harus lebih besar atau sama dengan harga minimum'
'legal_documents.*.mimes' => 'Dokumen legal harus berupa file PDF, JPG, JPEG, atau PNG'
'legal_documents.*.max' => 'Ukuran file dokumen legal maksimal 5MB'
'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan'
```

---

## 🔐 File Upload Security

### Legal Documents Upload

-   **Disk:** `public`
-   **Directory:** `wedding-organizer-documents/`
-   **Full Path:** `storage/app/public/wedding-organizer-documents/`
-   **Public URL:** `storage/wedding-organizer-documents/{filename}`
-   **Accepted Types:** PDF, JPG, JPEG, PNG
-   **Max Size:** 5MB per file
-   **Multiple Files:** Yes (array)

### Storage Configuration

Make sure symbolic link is created:

```bash
php artisan storage:link
```

---

## 📅 Change Log

**October 23, 2025**

-   ✅ Added `services` field (textarea, comma-separated)
-   ✅ Added `price_range_min` field (numeric with Rp prefix)
-   ✅ Added `price_range_max` field (numeric with Rp prefix, validated >= min)
-   ✅ Added `completed_events` field (integer, default 0)
-   ✅ Added `awards` field (textarea)
-   ✅ Added `certification_level` field (select from config)
-   ✅ Added `legal_documents` field (multiple file upload)
-   ✅ Updated JoinController validation rules
-   ✅ Updated JoinController data processing
-   ✅ Form already has `enctype="multipart/form-data"`

---

## 🧪 Testing Checklist

### Form Display

-   [ ] All new fields appear in the form
-   [ ] Price fields show "Rp" prefix
-   [ ] Certification level shows all options from config
-   [ ] File upload accepts PDF, JPG, JPEG, PNG
-   [ ] Helper texts are clear and in Bahasa

### Validation

-   [ ] Required fields show error when empty
-   [ ] price_range_max validates >= price_range_min
-   [ ] File upload validates file types
-   [ ] File upload validates max 5MB
-   [ ] Multiple files can be uploaded

### Data Processing

-   [ ] Services converted to JSON array
-   [ ] Files uploaded to correct directory
-   [ ] File paths stored as JSON array
-   [ ] completed_events defaults to 0 if empty
-   [ ] All data saved correctly to database

### Admin Panel (Filament)

-   [ ] All fields visible in admin form
-   [ ] Can edit all new fields
-   [ ] File upload works in admin
-   [ ] Conditional fields work (region_id nullable)

---

**Documentation Created:** October 23, 2025  
**Status:** ✅ Implemented  
**Version:** 2.0
