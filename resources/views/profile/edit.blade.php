@extends('layouts.app')

@section('title', 'Profil Saya - HASTANA Indonesia')

@section('content')
<!-- Profile Hero -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16 mt-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <div class="w-24 h-24 rounded-full mx-auto mb-4 shadow-xl overflow-hidden {{ auth()->user()->avatar ? '' : 'bg-gradient-to-r from-white to-gray-200 flex items-center justify-center text-blue-600 text-4xl font-bold' }}">
                @if(auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <h1 class="text-4xl font-bold mb-2">{{ auth()->user()->name }}</h1>
            <p class="text-blue-100">{{ auth()->user()->email }}</p>
        </div>
    </div>
</section>

<!-- Profile Content -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            
            <!-- Success Messages -->
            @if (session('status') === 'profile-updated')
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
                    <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                    <p class="text-green-800 font-medium">Profil berhasil diperbarui!</p>
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
                    <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                    <p class="text-green-800 font-medium">Password berhasil diperbarui!</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-user-cog text-blue-600 mr-2"></i>
                            Pengaturan Akun
                        </h3>
                        <nav class="space-y-2">
                            <a href="#profile-info" class="profile-nav-link active flex items-center py-2 px-3 rounded-lg transition">
                                <i class="fas fa-user text-sm mr-3 w-5"></i>
                                Informasi Profil
                            </a>
                            <a href="#password" class="profile-nav-link flex items-center py-2 px-3 rounded-lg transition">
                                <i class="fas fa-key text-sm mr-3 w-5"></i>
                                Ubah Password
                            </a>
                            <a href="#security" class="profile-nav-link flex items-center py-2 px-3 rounded-lg transition">
                                <i class="fas fa-shield-alt text-sm mr-3 w-5"></i>
                                Keamanan Akun
                            </a>
                        </nav>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <a href="{{ route('dashboard') }}" class="flex items-center text-gray-600 hover:text-blue-600 transition">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Profile Information -->
                    <div id="profile-info" class="bg-white rounded-lg shadow-md p-6 scroll-mt-24">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-user text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Informasi Profil</h2>
                                <p class="text-sm text-gray-600">Perbarui informasi profil dan alamat email Anda</p>
                            </div>
                        </div>

                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('patch')

                            <!-- Avatar Upload -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-camera text-blue-600 mr-1"></i>
                                    Foto Profil
                                </label>
                                <div class="flex items-center gap-6">
                                    <!-- Current Avatar Preview -->
                                    <div class="relative">
                                        <div id="avatar-preview" class="w-24 h-24 rounded-full overflow-hidden bg-gradient-to-r from-blue-500 to-blue-700 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                            @if($user->avatar)
                                                <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        @if($user->avatar)
                                            <button type="button" onclick="removeAvatar()" class="absolute -top-1 -right-1 w-7 h-7 bg-red-500 text-white rounded-full hover:bg-red-600 transition flex items-center justify-center shadow-lg">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Upload Button -->
                                    <div class="flex-1">
                                        <input 
                                            type="file" 
                                            id="avatar" 
                                            name="avatar" 
                                            accept="image/*"
                                            class="hidden"
                                            onchange="previewAvatar(event)">
                                        <label 
                                            for="avatar" 
                                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 cursor-pointer transition">
                                            <i class="fas fa-upload mr-2"></i>
                                            Pilih Foto
                                        </label>
                                        <p class="text-xs text-gray-500 mt-2">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            JPG, PNG atau GIF. Maksimal 2MB.
                                        </p>
                                        @error('avatar')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user text-blue-600 mr-1"></i>
                                    Nama Lengkap
                                </label>
                                <input 
                                    id="name" 
                                    name="name" 
                                    type="text" 
                                    value="{{ old('name', $user->name) }}" 
                                    required 
                                    autofocus
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Masukkan nama lengkap Anda">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-envelope text-blue-600 mr-1"></i>
                                    Alamat Email
                                </label>
                                <input 
                                    id="email" 
                                    name="email" 
                                    type="email" 
                                    value="{{ old('email', $user->email) }}" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="email@example.com">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                        <p class="text-sm text-yellow-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Email Anda belum diverifikasi.
                                        </p>
                                        <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-sm text-blue-600 hover:text-blue-700 underline font-medium">
                                                Kirim ulang email verifikasi
                                            </button>
                                        </form>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 text-sm text-green-600">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Link verifikasi baru telah dikirim ke email Anda!
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-phone text-blue-600 mr-1"></i>
                                    Nomor Telepon
                                </label>
                                <input 
                                    id="phone" 
                                    name="phone" 
                                    type="tel" 
                                    value="{{ old('phone', $user->phone ?? '') }}" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Format: 08xx-xxxx-xxxx (tanpa spasi atau tanda hubung)
                                </p>
                            </div>

                            <div class="flex items-center gap-4 pt-4">
                                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-md hover:shadow-lg">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Update Password -->
                    <div id="password" class="bg-white rounded-lg shadow-md p-6 scroll-mt-24">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-key text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Ubah Password</h2>
                                <p class="text-sm text-gray-600">Pastikan akun Anda menggunakan password yang kuat dan aman</p>
                            </div>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <label for="update_password_current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-lock text-green-600 mr-1"></i>
                                    Password Saat Ini
                                </label>
                                <input 
                                    id="update_password_current_password" 
                                    name="current_password" 
                                    type="password"
                                    autocomplete="current-password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                    placeholder="Masukkan password saat ini">
                                @error('current_password', 'updatePassword')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="update_password_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-key text-green-600 mr-1"></i>
                                    Password Baru
                                </label>
                                <input 
                                    id="update_password_password" 
                                    name="password" 
                                    type="password"
                                    autocomplete="new-password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                    placeholder="Masukkan password baru (minimal 8 karakter)">
                                @error('password', 'updatePassword')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="update_password_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-check-circle text-green-600 mr-1"></i>
                                    Konfirmasi Password Baru
                                </label>
                                <input 
                                    id="update_password_password_confirmation" 
                                    name="password_confirmation" 
                                    type="password"
                                    autocomplete="new-password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                    placeholder="Masukkan ulang password baru">
                                @error('password_confirmation', 'updatePassword')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="font-semibold text-blue-900 mb-2 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Tips Password Aman:
                                </h4>
                                <ul class="text-sm text-blue-800 space-y-1">
                                    <li><i class="fas fa-check text-green-600 mr-1"></i> Minimal 8 karakter</li>
                                    <li><i class="fas fa-check text-green-600 mr-1"></i> Kombinasi huruf besar dan kecil</li>
                                    <li><i class="fas fa-check text-green-600 mr-1"></i> Gunakan angka dan simbol</li>
                                    <li><i class="fas fa-check text-green-600 mr-1"></i> Hindari kata-kata umum</li>
                                </ul>
                            </div>

                            <div class="flex items-center gap-4 pt-4">
                                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-800 transition duration-200 shadow-md hover:shadow-lg">
                                    <i class="fas fa-save mr-2"></i>
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Delete Account -->
                    <div id="security" class="bg-white rounded-lg shadow-md p-6 scroll-mt-24">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Hapus Akun</h2>
                                <p class="text-sm text-gray-600">Hapus akun Anda secara permanen</p>
                            </div>
                        </div>

                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                            <h4 class="font-semibold text-red-900 mb-2 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Peringatan!
                            </h4>
                            <p class="text-sm text-red-800 mb-3">
                                Setelah akun Anda dihapus, semua data dan informasi akan dihapus secara permanen. Sebelum menghapus akun, mohon unduh data yang ingin Anda simpan.
                            </p>
                        </div>

                        <button 
                            x-data="" 
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                            class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Hapus Akun
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delete Account Modal -->
<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
        @csrf
        @method('delete')

        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                Hapus Akun?
            </h2>
            <p class="text-gray-600">
                Apakah Anda yakin ingin menghapus akun Anda? Semua data akan dihapus secara permanen.
            </p>
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-lock text-red-600 mr-1"></i>
                Masukkan Password untuk Konfirmasi
            </label>
            <input
                id="password"
                name="password"
                type="password"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                placeholder="Password Anda">
            @error('password', 'userDeletion')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3">
            <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                Batal
            </button>
            <button type="submit" class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-trash-alt mr-2"></i>
                Ya, Hapus Akun
            </button>
        </div>
    </form>
</x-modal>

<style>
    .profile-nav-link {
        color: #6b7280;
    }
    
    .profile-nav-link:hover {
        background: linear-gradient(135deg, rgba(30, 64, 175, 0.1), rgba(220, 38, 38, 0.05));
        color: #1e40af;
    }
    
    .profile-nav-link.active {
        background: linear-gradient(135deg, rgba(30, 64, 175, 0.1), rgba(220, 38, 38, 0.05));
        color: #1e40af;
        font-weight: 600;
    }
    
    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }
</style>

<script>
    // Smooth scroll to sections
    document.querySelectorAll('.profile-nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links
            document.querySelectorAll('.profile-nav-link').forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // Scroll to target
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Avatar preview
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                event.target.value = '';
                return;
            }

            // Validate file type
            if (!file.type.match('image.*')) {
                alert('File harus berupa gambar!');
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                preview.innerHTML = `<img src="${e.target.result}" alt="Avatar Preview" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(file);
        }
    }

    // Remove avatar
    function removeAvatar() {
        if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
            // Create hidden input to mark avatar for deletion
            const form = document.querySelector('form[action="{{ route('profile.update') }}"]');
            let removeInput = document.getElementById('remove_avatar');
            if (!removeInput) {
                removeInput = document.createElement('input');
                removeInput.type = 'hidden';
                removeInput.name = 'remove_avatar';
                removeInput.id = 'remove_avatar';
                removeInput.value = '1';
                form.appendChild(removeInput);
            }
            
            // Reset preview to initial
            const preview = document.getElementById('avatar-preview');
            preview.innerHTML = '{{ strtoupper(substr($user->name ?? "U", 0, 1)) }}';
            preview.className = 'w-24 h-24 rounded-full overflow-hidden bg-gradient-to-r from-blue-500 to-blue-700 flex items-center justify-center text-white text-3xl font-bold shadow-lg';
            
            // Clear file input
            document.getElementById('avatar').value = '';
        }
    }
</script>
@endsection
