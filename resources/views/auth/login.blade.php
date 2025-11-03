@extends('layouts.app')

@section('title', 'Login - HASTANA Indonesia')

@push('styles')
<style>
    .login-bg {
        background: linear-gradient(135deg, rgba(30, 64, 175, 0.95), rgba(220, 38, 38, 0.9)),
                   url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><pattern id="diamond-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse"><polygon points="50,0 100,50 50,100 0,50" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23diamond-pattern)"/></svg>');
        background-size: cover, 100px 100px;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }

    /* Mobile spacing adjustments */
    @media (max-width: 1023px) {
        .login-bg {
            align-items: flex-start;
            padding-top: 4rem;
            padding-bottom: 2rem;
        }
    }

    .login-card {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .login-input {
        width: 100%;
        padding: 0.875rem 1rem;
        padding-left: 3rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .login-input:focus {
        outline: none;
        border-color: #1e40af;
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

    .login-input:focus + .input-icon {
        color: #1e40af;
    }

    .login-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #1e40af, #dc2626);
        color: white;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(30, 64, 175, 0.4);
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 64, 175, 0.5);
    }

    .login-btn:active {
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

    .feature-item {
        display: flex;
        align-items: start;
        gap: 1rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 0.75rem;
        backdrop-blur-sm;
    }

    .checkbox-custom {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid #d1d5db;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .checkbox-custom:checked {
        background-color: #1e40af;
        border-color: #1e40af;
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
        color: #1e40af;
    }
</style>
@endpush

@section('content')
<div class="login-bg">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-8 items-center">
                
                <!-- Left Side - Branding & Info -->
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
                            Selamat Datang di HASTANA
                        </h2>
                        <p class="text-xl opacity-90 mb-8">
                            Kelola bisnis wedding organizer Anda dengan lebih profesional
                        </p>
                    </div>

                    <!-- Features -->
                    <div class="space-y-4">
                        <div class="feature-item">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-chart-line text-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-1">Dashboard Analitik</h3>
                                <p class="text-sm opacity-80">Pantau performa bisnis Anda secara real-time</p>
                            </div>
                        </div>

                        <div class="feature-item">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-users text-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-1">Jaringan Profesional</h3>
                                <p class="text-sm opacity-80">Terhubung dengan 1000+ wedding organizer</p>
                            </div>
                        </div>

                        <div class="feature-item">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-certificate text-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-1">Sertifikasi Resmi</h3>
                                <p class="text-sm opacity-80">Tingkatkan kredibilitas dengan sertifikasi HASTANA</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-4 mt-20">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-rings-wedding text-white text-3xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">HASTANA Indonesia</h2>
                    <p class="text-sm text-white">Wedding Organizer Platform</p>
                </div>
                
                <!-- Right Side - Login Form -->
                <div class="login-card">
                    <div class="p-8 lg:p-12">
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Login</h2>
                            <p class="text-sm text-gray-600">Masuk ke akun Anda untuk melanjutkan</p>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <p class="text-sm text-green-700">{{ session('status') }}</p>
                            </div>
                        </div>
                        @endif

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

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-6">
                                <label for="email" class="block text-xs font-semibold text-gray-700 mb-2">
                                    Email Address
                                </label>
                                <div class="relative">
                                    <input 
                                        id="email" 
                                        type="email" 
                                        name="email" 
                                        class="login-input @error('email') border-red-500 @enderror" 
                                        placeholder="nama@email.com" 
                                        value="{{ old('email') }}" 
                                        required 
                                        autofocus 
                                        autocomplete="username"
                                    >
                                    <i class="fas fa-envelope input-icon"></i>
                                </div>
                                @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-6">
                                <label for="password" class="block text-xs font-semibold text-gray-700 mb-2">
                                    Password
                                </label>
                                <div class="relative">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        name="password" 
                                        class="login-input @error('password') border-red-500 @enderror" 
                                        placeholder="••••••••" 
                                        required 
                                        autocomplete="current-password"
                                    >
                                    <i class="fas fa-lock input-icon"></i>
                                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                                </div>
                                @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between mb-6">
                                <label class="flex items-center cursor-pointer">
                                    <input 
                                        id="remember_me" 
                                        type="checkbox" 
                                        class="checkbox-custom" 
                                        name="remember"
                                    >
                                    <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                                </label>

                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                    Lupa password?
                                </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="login-btn">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Masuk
                            </button>

                            <!-- Register Link -->
                            <div class="divider">
                                <span>Belum punya akun?</span>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('register') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Daftar Sekarang
                                </a>
                            </div>
                        </form>

                        <!-- Additional Info -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <p class="text-xs text-center text-gray-500">
                                <i class="fas fa-shield-alt mr-1"></i>
                                Login Anda dilindungi dengan enkripsi SSL
                            </p>
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

    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>
@endpush
