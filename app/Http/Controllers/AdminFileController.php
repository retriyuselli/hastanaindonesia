<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\EventParticipant;
use App\Models\WeddingOrganizer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function eventParticipantInvoice(Request $request, EventParticipant $eventParticipant): Response
    {
        $this->authorizeAdmin($request);

        $eventParticipant->load(['eventHastana.eventCategory', 'participantAddons.eventAddon']);
        $company = Company::first();

        $pdf = Pdf::loadView('filament.pdfs.event-participant-invoice', [
            'participant' => $eventParticipant,
            'event' => $eventParticipant->eventHastana,
            'company' => $company,
            'logoBase64' => $this->localImageDataUri($company?->logo_url),
        ])
            ->setPaper('a4', 'portrait')
            ->setOption('defaultFont', 'DejaVu Sans')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', false);

        $filename = 'invoice-'.strtolower($eventParticipant->registration_code).'.pdf';

        return $this->pdfResponse($request, $pdf->output(), $filename);
    }

    public function eventParticipantRecap(Request $request): Response
    {
        $this->authorizeAdmin($request);

        $participantsQuery = EventParticipant::query();
        $stats = [
            'total' => (clone $participantsQuery)->count(),
            'confirmed' => (clone $participantsQuery)->whereIn('status', ['confirmed', 'attended'])->count(),
            'pending' => (clone $participantsQuery)->where('status', 'pending')->count(),
            'cancelled' => (clone $participantsQuery)->where('status', 'cancelled')->count(),
            'paid' => (clone $participantsQuery)->where('payment_status', 'paid')->count(),
            'unpaid' => (clone $participantsQuery)->where('payment_status', 'pending')->count(),
            'free' => (clone $participantsQuery)->where('payment_status', 'free')->count(),
            'revenue' => (clone $participantsQuery)->where('payment_status', 'paid')->sum('total_amount'),
        ];

        $participants = EventParticipant::with([
            'eventHastana',
            'participantAddons.eventAddon',
            'user.weddingOrganizer.region',
        ])
            ->lazyById(250);

        $company = Company::first();

        $pdf = Pdf::loadView(
            'filament.pdfs.event-participants-recap',
            compact('participants', 'company', 'stats'),
        )
            ->setPaper('a4', 'landscape')
            ->setOption('defaultFont', 'DejaVu Sans')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', false);

        return $this->pdfResponse(
            $request,
            $pdf->output(),
            'rekapan-peserta-'.now()->format('Ymd-His').'.pdf',
        );
    }

    public function eventParticipantRecapExcel(Request $request): StreamedResponse
    {
        $this->authorizeAdmin($request);

        $payLabels = [
            'paid' => 'LUNAS',
            'free' => 'GRATIS',
            'refunded' => 'REFUNDED',
            'pending' => 'BELUM BAYAR',
        ];

        $participants = EventParticipant::with([
            'eventHastana',
            'participantAddons.eventAddon',
            'user.weddingOrganizer.region',
        ])
            ->orderBy('id')
            ->lazyById(250);

        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekapan Peserta');

        $headers = [
            'No',
            'Nama Peserta',
            'Telepon',
            'Perusahaan',
            'Email',
            'Asal Region',
            'Kode Registrasi',
            'Event',
            'Tanggal Event',
            'Status Pembayaran',
            'Tanggal Upload',
            'Add-on',
            'Total',
        ];

        foreach ($headers as $index => $header) {
            $column = Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column.'1', $header);
        }

        $lastColumn = Coordinate::stringFromColumnIndex(count($headers));
        $sheet->getStyle('A1:'.$lastColumn.'1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '8B1A1A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $rowNumber = 2;
        $index = 0;

        foreach ($participants as $participant) {
            $index++;
            $addons = $participant->participantAddons;
            $addonText = $addons->isEmpty()
                ? '—'
                : $addons
                    ->map(function ($addon): string {
                        $name = $addon->eventAddon?->name ?? 'Add-on';
                        $amount = number_format($addon->quantity * $addon->price_at_time, 0, ',', '.');

                        return $name.' ×'.$addon->quantity.' (Rp '.$amount.')';
                    })
                    ->implode('; ');

            $total = match (true) {
                $participant->payment_status === 'free' => 'GRATIS',
                (float) $participant->total_amount > 0 => (float) $participant->total_amount,
                default => '—',
            };

            $data = [
                $index,
                $participant->name,
                $participant->phone ?: '—',
                trim(($participant->company ?? '').($participant->position ? ', '.$participant->position : '')) ?: '—',
                $participant->email,
                $participant->user?->weddingOrganizer?->region?->region_name ?? '—',
                strtoupper((string) $participant->registration_code),
                $participant->eventHastana?->title ?? '—',
                $participant->eventHastana?->start_date?->format('d M Y') ?? '—',
                $payLabels[$participant->payment_status] ?? strtoupper((string) $participant->payment_status),
                filled($participant->payment_proof)
                    ? ($participant->created_at?->format('d M Y') ?? '—')
                    : '—',
                $addonText,
                $total,
            ];

            foreach ($data as $columnIndex => $value) {
                $column = Coordinate::stringFromColumnIndex($columnIndex + 1);
                $sheet->setCellValue($column.$rowNumber, $value);
            }

            if (is_float($total)) {
                $sheet->getStyle('M'.$rowNumber)
                    ->getNumberFormat()
                    ->setFormatCode('"Rp "* #,##0');
            }

            if ($index % 2 === 0) {
                $sheet->getStyle('A'.$rowNumber.':'.$lastColumn.$rowNumber)->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F9FAFB']],
                ]);
            }

            $rowNumber++;
        }

        foreach (range(1, count($headers)) as $columnIndex) {
            $sheet->getColumnDimensionByColumn($columnIndex)->setAutoSize(true);
        }

        $sheet->freezePane('A2');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'rekapan-peserta-'.now()->format('Ymd-His').'.xlsx';

        return response()->streamDownload(function () use ($writer): void {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-store, max-age=0',
        ]);
    }

    private function authorizeAdmin(Request $request): void
    {
        $superAdminRole = config('filament-shield.super_admin.name', 'super_admin');

        abort_unless($request->user()?->hasAnyRole(['admin', $superAdminRole]), 403);
    }

    private function pdfResponse(Request $request, string $content, string $filename): Response
    {
        $disposition = $request->boolean('download') ? 'attachment' : 'inline';

        $response = response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => $disposition.'; filename="'.$filename.'"',
            'X-Content-Type-Options' => 'nosniff',
        ]);

        $response->setPrivate();
        $response->setMaxAge(0);
        $response->headers->addCacheControlDirective('no-store');

        return $response;
    }

    private function localImageDataUri(?string $path): ?string
    {
        if (blank($path)
            || Str::startsWith($path, ['http://', 'https://'])
            || str_contains($path, '..')) {
            return null;
        }

        $path = ltrim($path, '/');
        if (! Storage::disk('public')->exists($path)) {
            return null;
        }

        $mime = Storage::disk('public')->mimeType($path);
        if (! in_array($mime, ['image/jpeg', 'image/png', 'image/webp', 'image/gif'], true)) {
            return null;
        }

        return 'data:'.$mime.';base64,'.base64_encode(Storage::disk('public')->get($path));
    }
}
