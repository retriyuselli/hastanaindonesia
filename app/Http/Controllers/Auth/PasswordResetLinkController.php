<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\EmailAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = EmailAddress::findUser((string) $request->input('email'));

        if (! $user) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Email tidak ditemukan atau gagal mengirim link reset password.']);
        }

        $status = Password::sendResetLink([
            'email' => $user->email,
        ]);

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', 'Link reset password sudah dikirim ke email Anda. Silakan cek inbox atau folder spam.')
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => 'Email tidak ditemukan atau gagal mengirim link reset password.']);
    }
}
