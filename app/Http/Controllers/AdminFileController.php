<?php

namespace App\Http\Controllers;

use App\Models\EventParticipant;
use App\Models\WeddingOrganizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminFileController extends Controller
{
    public function downloadWeddingOrganizerLegalDocument(Request $request, WeddingOrganizer $weddingOrganizer, int $index): BinaryFileResponse
    {
        $superAdminRole = config('filament-shield.super_admin.name', 'super_admin');

        if (! $request->user()?->hasAnyRole(['admin', $superAdminRole])) {
            abort(403);
        }

        $documents = $weddingOrganizer->legal_documents ?? [];

        if (! is_array($documents) || ! array_key_exists($index, $documents)) {
            abort(404);
        }

        $path = $documents[$index];

        if (! is_string($path) || $path === '' || str_contains($path, '..')) {
            abort(404);
        }

        if (! Str::startsWith($path, 'wedding-organizer-documents/')) {
            abort(404);
        }

        if (Storage::disk('private')->exists($path)) {
            return response()->download(Storage::disk('private')->path($path));
        }

        if (Storage::disk('public')->exists($path)) {
            return response()->download(Storage::disk('public')->path($path));
        }

        abort(404);
    }

    public function downloadEventParticipantPaymentProof(Request $request, EventParticipant $eventParticipant): BinaryFileResponse
    {
        $superAdminRole = config('filament-shield.super_admin.name', 'super_admin');

        if (! $request->user()?->hasAnyRole(['admin', $superAdminRole])) {
            abort(403);
        }

        $path = $eventParticipant->payment_proof;

        if (! is_string($path) || $path === '' || str_contains($path, '..')) {
            abort(404);
        }

        if (! Str::startsWith($path, 'payment_proofs/')) {
            abort(404);
        }

        if (Storage::disk('private')->exists($path)) {
            return response()->download(Storage::disk('private')->path($path));
        }

        if (Storage::disk('public')->exists($path)) {
            return response()->download(Storage::disk('public')->path($path));
        }

        abort(404);
    }
}
