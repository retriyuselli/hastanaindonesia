<?php

namespace App\Http\Controllers;

use App\Models\EventParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PrivateFileController extends Controller
{
    public function showEventParticipantPaymentProof(Request $request, EventParticipant $eventParticipant): BinaryFileResponse
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        $superAdminRole = config('filament-shield.super_admin.name', 'super_admin');
        $isAdmin = $user->hasAnyRole(['admin', $superAdminRole]);
        $isOwner = $eventParticipant->user_id !== null && (int) $eventParticipant->user_id === (int) $user->id;

        if (! $isAdmin && ! $isOwner) {
            abort(403);
        }

        $path = $eventParticipant->payment_proof;

        if (! is_string($path) || $path === '' || str_contains($path, '..')) {
            abort(404);
        }

        if (! Str::startsWith($path, 'payment_proofs/')) {
            abort(404);
        }

        $filename = basename($path);

        if (Storage::disk('private')->exists($path)) {
            return response()->file(Storage::disk('private')->path($path), [
                'Content-Disposition' => 'inline; filename="'.$filename.'"',
            ]);
        }

        if (Storage::disk('public')->exists($path)) {
            return response()->file(Storage::disk('public')->path($path), [
                'Content-Disposition' => 'inline; filename="'.$filename.'"',
            ]);
        }

        abort(404);
    }
}

