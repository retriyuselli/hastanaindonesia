<x-guest-layout>
    <div style="text-align: center;">
        <div style="display:flex;align-items:center;justify-content:center;width:72px;height:72px;margin:0 auto 16px;border-radius:9999px;background:#fef2f2;">
            <svg style="width:36px;height:36px;color:#dc2626;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>

        <h1 class="guest-title">{{ $title }}</h1>
        <p class="guest-subtitle" style="margin-top: 12px;">
            {{ $message }}
        </p>
    </div>

    <div style="margin-top: 8px; padding: 14px 16px; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 12px;">
        <p style="margin: 0; color: #9a3412; font-size: 13px; text-align: center; line-height: 1.5;">
            Panel admin hanya untuk pengurus yang memiliki peran admin.
            Jika Anda anggota biasa, silakan lanjut ke beranda atau dashboard.
        </p>
    </div>

    <div style="display: grid; gap: 10px; margin-top: 8px;">
        <a href="{{ route('home') }}" class="guest-btn" style="text-decoration: none;">
            Kembali ke Beranda
        </a>

        @auth
            <a href="{{ route('dashboard') }}" class="guest-btn" style="text-decoration: none; background: #111827; box-shadow: none;">
                Ke Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="guest-link" style="display:block;text-align:center;padding:10px 0;">
                Login dengan akun lain
            </a>
        @endauth
    </div>
</x-guest-layout>
