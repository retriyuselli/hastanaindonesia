<?php

namespace App\Http\Responses;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminAccessDeniedRedirect
{
    public static function fromRequest(Request $request): ?RedirectResponse
    {
        if (! $request->is('admin', 'admin/*') || ! auth()->check()) {
            return null;
        }

        return redirect()
            ->route('admin.access-denied')
            ->with('admin_access_denied_title', 'Akses Panel Admin Ditolak')
            ->with(
                'admin_access_denied_message',
                'Akun Anda tidak memiliki izin untuk membuka panel admin HASTANA Indonesia.',
            );
    }
}
