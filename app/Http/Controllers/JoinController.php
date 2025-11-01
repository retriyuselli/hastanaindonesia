<?php

namespace App\Http\Controllers;

use App\Models\WeddingOrganizer;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class JoinController extends Controller
{
    /**
     * Show the registration form
     */
    public function index()
    {
        // Check if user already has a wedding organizer
        $alreadyRegistered = false;
        $existingOrganizer = null;
        
        if (Auth::check()) {
            $existingOrganizer = WeddingOrganizer::where('user_id', Auth::id())->first();
            $alreadyRegistered = $existingOrganizer !== null;
        }

        // Get all regions
        $regions = Region::orderBy('region_name')->get();

        return view('join', [
            'alreadyRegistered' => $alreadyRegistered,
            'existingOrganizer' => $existingOrganizer,
            'regions' => $regions
        ]);
    }

    /**
     * Handle the registration form submission
     */
    public function store(Request $request)
    {
        // Log incoming request data for debugging
        Log::info('Join Form Submission', [
            'all_data' => $request->all(),
            'has_deed' => $request->has('deed_of_establishment'),
            'deed_value' => $request->input('deed_of_establishment'),
            'legal_entity_type' => $request->input('legal_entity_type'),
        ]);

        // Check if user already has a wedding organizer (for update)
        $existingOrganizer = WeddingOrganizer::where('user_id', Auth::id())->first();
        $isUpdate = $existingOrganizer !== null;

        // Validate the form data
        $validated = $request->validate([
            'organizer_name' => 'required|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'email' => $isUpdate 
                ? 'required|email|unique:wedding_organizers,email,' . $existingOrganizer->id 
                : 'required|email|unique:wedding_organizers,email',
            'phone' => 'required|string|max:20',
            'established_year' => 'required|integer|min:1990|max:' . date('Y'),
            'business_type' => 'required|string|in:' . implode(',', array_keys(config('indonesia.business_types'))),
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'region_id' => 'required|exists:regions,id',
            'website' => 'nullable|url|max:255',
            'instagram' => 'nullable|string|max:100',
            'description' => 'required|string|min:50',
            'specializations' => 'required|string',
            'services' => 'nullable|string',
            'price_range_min' => 'nullable|numeric|min:0',
            'price_range_max' => 'nullable|numeric|min:0|gte:price_range_min',
            'completed_events' => 'nullable|integer|min:0',
            'awards' => 'nullable|string',
            'certification_level' => 'nullable|string|in:' . implode(',', array_keys(config('indonesia.certification_levels', []))),
            'business_license' => 'required|string|max:100',
            'legal_documents' => 'nullable|array',
            'legal_documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            // Legal detail fields (optional)
            'legal_entity_type' => 'nullable|string|in:PT,CV,Firma,UD,Koperasi,Yayasan',
            'deed_of_establishment' => 'nullable|string|max:100',
            'deed_date' => 'nullable|date',
            'notary_name' => 'nullable|string|max:255',
            'notary_license_number' => 'nullable|string|max:100',
            'nib_number' => 'nullable|string|max:13',
            'nib_issued_date' => 'nullable|date',
            'nib_valid_until' => 'nullable|date',
            'npwp_number' => 'nullable|string|max:20',
            'npwp_issued_date' => 'nullable|date',
            'tax_office' => 'nullable|string|max:255',
            'terms' => 'required|accepted',
            'newsletter' => 'nullable|boolean',
        ], [
            'organizer_name.required' => 'Nama Wedding Organizer wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain',
            'phone.required' => 'Nomor telepon wajib diisi',
            'established_year.required' => 'Tahun berdiri wajib diisi',
            'established_year.min' => 'Tahun berdiri tidak valid',
            'established_year.max' => 'Tahun berdiri tidak boleh melebihi tahun sekarang',
            'business_type.required' => 'Jenis usaha wajib dipilih',
            'address.required' => 'Alamat wajib diisi',
            'city.required' => 'Kota wajib diisi',
            'province.required' => 'Provinsi wajib dipilih',
            'region_id.required' => 'Wilayah operasional wajib dipilih',
            'region_id.exists' => 'Wilayah operasional tidak valid',
            'description.required' => 'Deskripsi wajib diisi',
            'description.min' => 'Deskripsi minimal 50 karakter',
            'specializations.required' => 'Spesialisasi/layanan wajib diisi',
            'price_range_max.gte' => 'Harga maksimum harus lebih besar atau sama dengan harga minimum',
            'business_license.required' => 'Nomor izin usaha wajib diisi',
            'legal_documents.*.mimes' => 'Dokumen legal harus berupa file PDF, JPG, JPEG, atau PNG',
            'legal_documents.*.max' => 'Ukuran file dokumen legal maksimal 5MB',
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);

        // Clean up Instagram username (remove @ if present)
        if (!empty($validated['instagram'])) {
            $validated['instagram'] = ltrim($validated['instagram'], '@');
        }

        // Convert specializations to JSON array
        $specializations = array_map('trim', explode(',', $validated['specializations']));
        $validated['specializations'] = json_encode($specializations);

        // Convert services to JSON array if provided
        if (!empty($validated['services'])) {
            $services = array_map('trim', explode(',', $validated['services']));
            $validated['services'] = json_encode($services);
        }

        // Handle file upload for legal_documents
        if ($request->hasFile('legal_documents')) {
            $uploadedFiles = [];
            foreach ($request->file('legal_documents') as $file) {
                $path = $file->store('wedding-organizer-documents', 'public');
                $uploadedFiles[] = $path;
                
                // Log successful upload
                Log::info('Legal document uploaded', [
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize()
                ]);
            }
            $validated['legal_documents'] = $uploadedFiles; // Simpan sebagai array, akan di-cast otomatis oleh model
            
            Log::info('Total legal documents uploaded', [
                'count' => count($uploadedFiles),
                'files' => $uploadedFiles
            ]);
        } else {
            Log::info('No legal documents uploaded in this request');
        }

        // Generate slug from organizer name (only for new registration)
        if (!$isUpdate) {
            $validated['slug'] = Str::slug($validated['organizer_name']);
            
            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (WeddingOrganizer::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Set default values
        $validated['completed_events'] = $validated['completed_events'] ?? 0; // Default 0 if not provided
        
        // Only set these for new registration
        if (!$isUpdate) {
            $validated['user_id'] = Auth::id(); // Set user_id to currently logged in user
            $validated['is_approved'] = false; // Menunggu approval admin
            $validated['is_active'] = false; // Akan diaktifkan setelah approval
            $validated['subscribe_newsletter'] = $request->boolean('newsletter');
        }

        try {
            if ($isUpdate) {
                // Update existing wedding organizer
                $existingOrganizer->update($validated);
                $message = 'Data wedding organizer Anda berhasil diperbarui!';
                
                Log::info('Wedding Organizer Updated', [
                    'id' => $existingOrganizer->id,
                    'organizer_name' => $validated['organizer_name'],
                    'has_legal_documents' => isset($validated['legal_documents']),
                    'legal_fields' => [
                        'legal_entity_type' => $validated['legal_entity_type'] ?? null,
                        'deed_of_establishment' => $validated['deed_of_establishment'] ?? null,
                        'notary_name' => $validated['notary_name'] ?? null,
                        'nib_number' => $validated['nib_number'] ?? null,
                        'npwp_number' => $validated['npwp_number'] ?? null,
                    ]
                ]);
            } else {
                // Create new wedding organizer
                $weddingOrganizer = WeddingOrganizer::create($validated);
                $message = 'Terima kasih telah mendaftar! Kami akan menghubungi Anda dalam 3-5 hari kerja untuk proses verifikasi.';
                
                Log::info('Wedding Organizer Created', [
                    'id' => $weddingOrganizer->id,
                    'organizer_name' => $validated['organizer_name'],
                    'user_id' => $validated['user_id'],
                    'has_legal_documents' => isset($validated['legal_documents']),
                    'legal_documents_count' => isset($validated['legal_documents']) ? count($validated['legal_documents']) : 0
                ]);
            }

            // Send success message
            return redirect()
                ->route('join')
                ->with('success', $message);

        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Wedding Organizer Registration/Update Error: ' . $e->getMessage(), [
                'exception' => $e,
                'validated_data' => $validated,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses data. Silakan coba lagi.');
        }
    }
}
