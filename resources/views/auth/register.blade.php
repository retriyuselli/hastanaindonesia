@extends('layouts.app')

@section('title', 'Daftar Akun - HASTANA Indonesia')

@push('styles')
<style>
    .register-bg {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.95), rgba(30, 64, 175, 0.9)),
                   url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><pattern id="diamond-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse"><polygon points="50,0 100,50 50,100 0,50" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23diamond-pattern)"/></svg>');
        background-size: cover, 100px 100px;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }

    .register-card {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .register-input {
        width: 100%;
        padding: 0.875rem 1rem;
        padding-left: 3rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .register-input:focus {
        outline: none;
        border-color: #dc2626;
        box-shadow: none;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        pointer-events: none;
    }

    .register-input:focus + .input-icon {
        color: #dc2626;
    }

    .register-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #dc2626, #1e40af);
        color: white;
        font-weight: 700;
        font-size: 1.125rem;
        border: none;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.4);
    }

    .register-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.5);
    }

    .register-btn:active {
        transform: translateY(0);
    }

    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        color: #9ca3af;
        margin: 1.5rem 0;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e5e7eb;
    }

    .divider span {
        padding: 0 1rem;
        font-size: 0.875rem;
    }

    .benefit-item {
        display: flex;
        align-items: start;
        gap: 1rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 0.75rem;
        backdrop-blur-sm;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6b7280;
        transition: color 0.2s;
    }

    .password-toggle:hover {
        color: #dc2626;
    }

    .strength-meter {
        height: 0.5rem;
        background: #e5e7eb;
        border-radius: 0.25rem;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .strength-bar {
        height: 100%;
        transition: all 0.3s ease;
        border-radius: 0.25rem;
    }

    .strength-weak { width: 33%; background: #ef4444; }
    .strength-medium { width: 66%; background: #f59e0b; }
    .strength-strong { width: 100%; background: #10b981; }
</style>
@endpush

@section('content')
<div class="register-bg">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-8 items-center">
                
                <!-- Left Side - Branding & Benefits -->
                <div class="hidden lg:block text-white">
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm mr-4">
                                <i class="fas fa-rings-wedding text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold">HASTANA</h1>
                                <p class="text-sm opacity-90">Indonesia Wedding Organizer</p>
                            </div>
                        </div>
                        <h2 class="text-4xl font-bold mb-4 leading-tight">
                            Bergabunglah dengan Komunitas Terbesar!
                        </h2>
                        <p class="text-xl opacity-90 mb-8">
                            Tingkatkan profesionalisme wedding organizer Anda bersama HASTANA Indonesia
                        </p>
                    </div>

                    <!-- Benefits -->
                    <div class="space-y-4">
                        <div class="benefit-item">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-users text-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-1">1000+ Member Aktif</h3>
                                <p class="text-sm opacity-80">Jaringan wedding organizer di 34 provinsi</p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-certificate text-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-1">Sertifikasi Resmi</h3>
                                <p class="text-sm opacity-80">Dapatkan sertifikasi yang diakui nasional</p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-graduation-cap text-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-1">Pelatihan Eksklusif</h3>
                                <p class="text-sm opacity-80">Workshop dan seminar untuk member</p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-handshake text-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-1">Kolaborasi Bisnis</h3>
                                <p class="text-sm opacity-80">Partner dengan vendor terpercaya</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Registration Form -->
                <div class="register-card">
                    <div class="p-8 lg:p-12">
                        <!-- Mobile Logo -->
                        <div class="lg:hidden text-center mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-red-600 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-rings-wedding text-white text-3xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">HASTANA Indonesia</h2>
                            <p class="text-gray-600">Wedding Organizer Platform</p>
                        </div>

                        <div class="mb-8 mt-20">
                            <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar Akun</h2>
                            <p class="text-gray-600">Buat akun untuk mengakses semua fitur HASTANA</p>
                        </div>

                        <!-- Error Messages -->
                        @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-0.5"></i>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-red-700 mb-2">Terjadi kesalahan:</p>
                                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-6">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap
                                </label>
                                <div class="relative">
                                    <input 
                                        id="name" 
                                        type="text" 
                                        name="name" 
                                        class="register-input @error('name') border-red-500 @enderror" 
                                        placeholder="John Doe" 
                                        value="{{ old('name') }}" 
                                        required 
                                        autofocus 
                                        autocomplete="name"
                                    >
                                    <i class="fas fa-user input-icon"></i>
                                </div>
                                @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="mb-6">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address
                                </label>
                                <div class="relative">
                                    <input 
                                        id="email" 
                                        type="email" 
                                        name="email" 
                                        class="register-input @error('email') border-red-500 @enderror" 
                                        placeholder="nama@email.com" 
                                        value="{{ old('email') }}" 
                                        required 
                                        autocomplete="username"
                                    >
                                    <i class="fas fa-envelope input-icon"></i>
                                </div>
                                @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @else
                                <p class="mt-2 text-xs text-gray-500">Gunakan email aktif Anda</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-6">
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password
                                </label>
                                <div class="relative">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        name="password" 
                                        class="register-input @error('password') border-red-500 @enderror" 
                                        placeholder="••••••••" 
                                        required 
                                        autocomplete="new-password"
                                    >
                                    <i class="fas fa-lock input-icon"></i>
                                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                                </div>
                                <!-- Password Strength Meter -->
                                <div class="strength-meter">
                                    <div class="strength-bar" id="strengthBar"></div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500" id="strengthText">Minimal 8 karakter</p>
                                @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-6">
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Konfirmasi Password
                                </label>
                                <div class="relative">
                                    <input 
                                        id="password_confirmation" 
                                        type="password" 
                                        name="password_confirmation" 
                                        class="register-input @error('password_confirmation') border-red-500 @enderror" 
                                        placeholder="••••••••" 
                                        required 
                                        autocomplete="new-password"
                                    >
                                    <i class="fas fa-lock input-icon"></i>
                                    <i class="fas fa-eye password-toggle" id="togglePasswordConfirm"></i>
                                </div>
                                @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @else
                                <p class="mt-2 text-xs text-gray-500">Masukkan password yang sama</p>
                                @enderror
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="mb-6">
                                <label class="flex items-start cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        class="mt-1 h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500" 
                                        required
                                    >
                                    <span class="ml-3 text-sm text-gray-600">
                                        Saya menyetujui 
                                        <a href="{{ route('terms') }}" target="_blank" class="text-red-600 hover:text-red-800 font-semibold">
                                            Syarat dan Ketentuan
                                        </a> 
                                        serta 
                                        <a href="{{ route('privacy') }}" target="_blank" class="text-red-600 hover:text-red-800 font-semibold">
                                            Kebijakan Privasi
                                        </a> 
                                        HASTANA Indonesia
                                    </span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="register-btn">
                                <i class="fas fa-user-plus mr-2"></i>
                                Daftar Sekarang
                            </button>

                            <!-- Login Link -->
                            <div class="divider">
                                <span>Sudah punya akun?</span>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('login') }}" class="inline-flex items-center text-red-600 hover:text-red-800 font-semibold transition-colors">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Login Disini
                                </a>
                            </div>
                        </form>

                        <!-- Additional Info -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-center space-x-4 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <i class="fas fa-shield-alt mr-1"></i>
                                    Data Aman
                                </span>
                                <span>•</span>
                                <span class="flex items-center">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Gratis Selamanya
                                </span>
                                <span>•</span>
                                <span class="flex items-center">
                                    <i class="fas fa-bolt mr-1"></i>
                                    Aktivasi Instan
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle Password Visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this;
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
        const passwordInput = document.getElementById('password_confirmation');
        const icon = this;
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Password Strength Meter
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;
        
        // Remove all strength classes
        strengthBar.classList.remove('strength-weak', 'strength-medium', 'strength-strong');
        
        if (password.length === 0) {
            strengthBar.style.width = '0%';
            strengthText.textContent = 'Minimal 8 karakter';
            strengthText.className = 'mt-2 text-xs text-gray-500';
        } else if (strength <= 1) {
            strengthBar.classList.add('strength-weak');
            strengthText.textContent = 'Password lemah';
            strengthText.className = 'mt-2 text-xs text-red-600';
        } else if (strength <= 2) {
            strengthBar.classList.add('strength-medium');
            strengthText.textContent = 'Password sedang';
            strengthText.className = 'mt-2 text-xs text-yellow-600';
        } else {
            strengthBar.classList.add('strength-strong');
            strengthText.textContent = 'Password kuat';
            strengthText.className = 'mt-2 text-xs text-green-600';
        }
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.bg-red-50');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // Password Match Validation
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmation = this.value;
        
        if (confirmation && password !== confirmation) {
            this.classList.add('border-red-500');
        } else {
            this.classList.remove('border-red-500');
        }
    });
</script>
@endpush
