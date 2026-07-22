<x-guest-layout>
    <div style="text-align: center;">
        <h1 class="guest-title">Atur Ulang Password</h1>
        <p class="guest-subtitle">
            Buat password baru untuk akun Anda.
        </p>
    </div>

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

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                required
                autofocus
                autocomplete="username"
            >
        </div>

        <div>
            <label for="password">Password Baru</label>
            <input
                id="password"
                type="password"
                name="password"
                placeholder="••••••••"
                required
                autocomplete="new-password"
            >
        </div>

        <div>
            <label for="password_confirmation">Konfirmasi Password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                placeholder="••••••••"
                required
                autocomplete="new-password"
            >
        </div>

        <button type="submit" class="guest-btn">
            Simpan Password Baru
        </button>
    </form>

    <div class="guest-divider"></div>

    <p class="guest-footer">
        <a class="guest-link" href="{{ route('login') }}">Kembali ke Login</a>
    </p>
</x-guest-layout>
