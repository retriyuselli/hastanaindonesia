# Panduan Approve Komentar Blog

## Cara 1: Menggunakan Filament Admin Panel (REKOMENDASI)

### Akses Filament Admin:

1. Login ke admin panel: `http://localhost:8888/admin` (atau URL MAMP Anda)
2. Di sidebar, cari menu **"Blog Comments"**
3. Anda akan melihat daftar semua komentar

### Fitur yang Tersedia:

#### **Filter Komentar:**

-   **All comments** - Tampilkan semua komentar
-   **Approved only** - Hanya yang sudah disetujui
-   **Pending only** - Hanya yang menunggu approval

#### **Approve Individual:**

1. Cari komentar yang ingin di-approve
2. Klik tombol **"Approve"** (ikon check circle hijau) di kolom Actions
3. Konfirmasi approval
4. Komentar langsung muncul di website

#### **Reject Individual:**

1. Untuk komentar yang sudah approved, ada tombol **"Reject"** (ikon X kuning)
2. Klik untuk mengembalikan ke status pending

#### **Bulk Approve/Reject:**

1. Centang beberapa komentar sekaligus
2. Klik dropdown "Bulk Actions" di atas tabel
3. Pilih:
    - **"Approve Selected"** - Approve sekaligus
    - **"Reject Selected"** - Reject sekaligus
    - **"Delete Selected"** - Hapus sekaligus

#### **Informasi yang Ditampilkan:**

-   **Blog Article** - Artikel mana komentarnya (klik untuk buka)
-   **Name** - Nama komentator
-   **Email** - Email komentator
-   **Comment** - Isi komentar (50 karakter pertama)
-   **Approved** - Status approval (✓ hijau = approved, ✗ kuning = pending)
-   **Date** - Tanggal komentar dibuat
-   **IP** - IP address komentator (tersembunyi, bisa ditampilkan)

---

## Cara 2: Menggunakan Tinker (Manual via Command Line)

### Approve 1 Komentar Berdasarkan ID:

```bash
php artisan tinker
```

```php
// Approve komentar dengan ID tertentu
$comment = \App\Models\BlogComment::find(1);
$comment->is_approved = true;
$comment->save();
```

### Approve Semua Komentar dari Email Tertentu:

```php
\App\Models\BlogComment::where('email', 'user@example.com')
    ->update(['is_approved' => true]);
```

### Approve Semua Komentar untuk Blog Tertentu:

```php
// Cari blog dulu
$blog = \App\Models\Blog::where('slug', 'judul-artikel')->first();

// Approve semua komentarnya
\App\Models\BlogComment::where('blog_id', $blog->id)
    ->update(['is_approved' => true]);
```

### Approve Semua Komentar Pending:

```php
\App\Models\BlogComment::where('is_approved', false)
    ->update(['is_approved' => true]);
```

### Lihat Komentar Pending:

```php
\App\Models\BlogComment::where('is_approved', false)
    ->with('blog')
    ->get()
    ->each(function($comment) {
        echo "ID: {$comment->id} | {$comment->name} | {$comment->blog->title} | {$comment->comment}\n";
    });
```

---

## Cara 3: Menggunakan Database Tool (phpMyAdmin/TablePlus)

### Via phpMyAdmin:

1. Buka phpMyAdmin di MAMP
2. Pilih database `hastana_indonesia`
3. Klik tabel `blog_comments`
4. Cari komentar yang ingin di-approve
5. Edit kolom `is_approved` menjadi `1` (true)
6. Simpan

### SQL Query:

```sql
-- Approve komentar dengan ID tertentu
UPDATE blog_comments SET is_approved = 1 WHERE id = 1;

-- Approve semua komentar pending
UPDATE blog_comments SET is_approved = 1 WHERE is_approved = 0;

-- Approve komentar untuk blog tertentu
UPDATE blog_comments
SET is_approved = 1
WHERE blog_id = (SELECT id FROM blogs WHERE slug = 'judul-artikel');
```

---

## Cara 4: Membuat Route Admin Custom (Opsional)

Jika ingin membuat endpoint khusus untuk approve:

### Tambahkan di `routes/web.php`:

```php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/comments/{id}/approve', function($id) {
        $comment = \App\Models\BlogComment::findOrFail($id);
        $comment->is_approved = true;
        $comment->save();
        return redirect()->back()->with('success', 'Comment approved!');
    })->name('admin.comments.approve');
});
```

---

## Troubleshooting

### Komentar Tidak Muncul Setelah Di-Approve:

1. Clear cache Laravel:

    ```bash
    php artisan cache:clear
    php artisan view:clear
    ```

2. Pastikan `is_approved = 1` di database

3. Cek query di `routes/web.php` sudah benar:
    ```php
    ->where('is_approved', true)
    ```

### Badge Status di Website:

-   Komentar dengan `is_approved = true` → Badge hijau "Terverifikasi"
-   Komentar dengan `is_approved = false` → Badge kuning "Menunggu Review"

Note: Hanya komentar yang `is_approved = true` yang tampil di website publik.

---

## Rekomendasi Workflow:

1. **User submit komentar** → Status: `is_approved = false` (pending)
2. **Admin login ke Filament** → Lihat komentar pending
3. **Admin review komentar** → Baca isi komentar
4. **Admin approve/reject** → Klik tombol Approve atau Delete
5. **Komentar muncul di website** → Otomatis tampil dengan badge "Terverifikasi"

---

**Gunakan Cara 1 (Filament Admin)** - Paling mudah, lengkap, dan user-friendly! ✅
