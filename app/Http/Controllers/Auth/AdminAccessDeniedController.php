<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminAccessDeniedController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('auth.admin-access-denied', [
            'title' => $request->session()->get(
                'admin_access_denied_title',
                'Akses Panel Admin Ditolak',
            ),
            'message' => $request->session()->get(
                'admin_access_denied_message',
                'Akun Anda tidak memiliki izin untuk membuka panel admin HASTANA Indonesia.',
            ),
        ]);
    }
}
