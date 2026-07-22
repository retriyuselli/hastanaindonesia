<x-guest-layout>
    <div style="text-align: center;">
        <h1 class="guest-title">Lupa Password</h1>
        <p class="guest-subtitle">
            Masukkan email akun Anda. Kami akan mengirimkan link untuk mengatur ulang password.
        </p>
    </div>

    @if (session('status'))
        <div style="padding: 14px 16px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px;">
            <p style="margin: 0; color: #166534; font-size: 13px; text-align: center;">
                <i class="fas fa-check-circle"></i>
                &nbsp;{{ session('status') }}
            </p>
        </div>
    @endif

    @if ($errors->any())
        <div style="padding: 14px 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px;">
            <p style="margin: 0 0 8px 0; color: #991b1b; font-size: 13px; font-weight: 700;">
                Terjadi kesalahan:
            </p>
            <ul style="margin: 0; padding-left: 18px; color: #b91c1c; font-size: 13px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="nama@email.com"
                required
                autofocus
                autocomplete="username"
            >
        </div>

        <button type="submit" class="guest-btn">
            Kirim Link Reset Password
        </button>
    </form>

    <div class="guest-divider"></div>

    <p class="guest-footer">
        Ingat password Anda?
        <a class="guest-link" href="{{ route('login') }}">Masuk</a>
    </p>
</x-guest-layout>
