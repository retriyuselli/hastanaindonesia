<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IuranController extends Controller
{
    public function bayar(Request $request, Iuran $iuran)
    {
        if ($iuran->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_method' => 'required|string',
            'payment_proof'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('iuran_proofs', 'private');

        $iuran->update([
            'payment_method' => $request->payment_method,
            'payment_proof'  => $path,
            'status'         => 'pending',
            'paid_at'        => now(),
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu konfirmasi admin.');
    }
}
