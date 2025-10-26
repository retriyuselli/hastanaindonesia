<?php

namespace App\Http\Controllers;

use App\Models\EventHastana;
use App\Models\EventCategory;
use App\Models\EventParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of events
     */
    public function index(Request $request)
    {
        $query = EventHastana::with('eventCategory')
            ->where('status', 'published')
            ->where('is_active', true);

        // Quick Filter (Gratis, Featured, Trending)
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'free':
                    $query->where('is_free', true);
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
                case 'trending':
                    $query->where('is_trending', true);
                    break;
            }
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('event_category_id', $request->category);
        }

        // Filter by event type
        if ($request->has('type') && $request->type != '') {
            $query->where('event_type', $request->type);
        }

        // Filter by price
        if ($request->has('price_filter')) {
            if ($request->price_filter == 'free') {
                $query->where('is_free', true);
            } elseif ($request->price_filter == 'paid') {
                $query->where('is_free', false);
            }
        }

        // Filter by city
        if ($request->has('city') && $request->city != '') {
            $query->where('city', $request->city);
        }

        // Filter by date range
        if ($request->has('date_filter')) {
            $now = now();
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('start_date', $now->toDateString());
                    break;
                case 'this_week':
                    $query->whereBetween('start_date', [
                        $now->startOfWeek(),
                        $now->copy()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('start_date', $now->month)
                          ->whereYear('start_date', $now->year);
                    break;
                case 'upcoming':
                    $query->where('start_date', '>=', $now);
                    break;
            }
        } else {
            // Default: show only upcoming events
            $query->where('start_date', '>=', now());
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'start_date');
        $sortOrder = $request->get('sort_order', 'asc');
        
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('current_participants', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('start_date', $sortOrder);
        }

        // Get events with pagination
        $events = $query->paginate(12)->withQueryString();

        // Get categories for filter
        $categories = EventCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Get available cities for filter
        $cities = EventHastana::where('status', 'published')
            ->where('is_active', true)
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        // Get featured events (for sidebar or highlighted section)
        $featuredEvents = EventHastana::where('status', 'published')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->limit(5)
            ->get();

        // Get trending events
        $trendingEvents = EventHastana::where('status', 'published')
            ->where('is_active', true)
            ->where('is_trending', true)
            ->where('start_date', '>=', now())
            ->orderBy('current_participants', 'desc')
            ->limit(5)
            ->get();

        return view('events.index', compact(
            'events',
            'categories',
            'cities',
            'featuredEvents',
            'trendingEvents'
        ));
    }

    /**
     * Display the specified event
     */
    public function show($slug)
    {
        $event = EventHastana::with('eventCategory')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where('is_active', true)
            ->firstOrFail();

        // Get related events (same category, upcoming)
        $relatedEvents = EventHastana::where('event_category_id', $event->event_category_id)
            ->where('id', '!=', $event->id)
            ->where('status', 'published')
            ->where('is_active', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->limit(4)
            ->get();

        // Parse benefits and requirements
        $benefits = $event->benefits ? explode(',', $event->benefits) : [];
        $requirements = $event->requirements ? explode(',', $event->requirements) : [];

        return view('events.show', compact(
            'event',
            'relatedEvents',
            'benefits',
            'requirements'
        ));
    }

    /**
     * Get events by category
     */
    public function category($categorySlug)
    {
        $category = EventCategory::where('slug', $categorySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $events = EventHastana::with('eventCategory')
            ->where('event_category_id', $category->id)
            ->where('status', 'published')
            ->where('is_active', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->paginate(12);

        $categories = EventCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('events.category', compact('category', 'events', 'categories'));
    }

    /**
     * Get free events
     */
    public function free()
    {
        $events = EventHastana::with('eventCategory')
            ->where('status', 'published')
            ->where('is_active', true)
            ->where('is_free', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->paginate(12);

        $categories = EventCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('events.free', compact('events', 'categories'));
    }

    /**
     * Get featured events
     */
    public function featured()
    {
        $events = EventHastana::with('eventCategory')
            ->where('status', 'published')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->paginate(12);

        $categories = EventCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('events.featured', compact('events', 'categories'));
    }

    /**
     * Get trending events
     */
    public function trending()
    {
        $events = EventHastana::with('eventCategory')
            ->where('status', 'published')
            ->where('is_active', true)
            ->where('is_trending', true)
            ->where('start_date', '>=', now())
            ->orderBy('current_participants', 'desc')
            ->paginate(12);

        $categories = EventCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('events.trending', compact('events', 'categories'));
    }

    /**
     * Show registration form
     */
    public function register($slug)
    {
        $event = EventHastana::with('eventCategory')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where('is_active', true)
            ->firstOrFail();

        // Check if registration is still open
        $capacity = $event->max_participants ?? $event->quota;
        
        // TIDAK redirect jika sudah terdaftar, biarkan form tetap ditampilkan
        // Tombol submit akan otomatis disabled di blade
        
        // Check availability using model methods
        if ($event->is_full || $event->is_past) {
            return redirect()->route('events.show', $slug)
                ->with('error', $event->is_full ? 'Event sudah penuh!' : 'Event sudah berakhir!');
        }

        return view('events.register', compact('event'));
    }

    /**
     * Store registration
     */
    public function storeRegistration(Request $request, $slug)
    {
        $event = EventHastana::where('slug', $slug)
            ->where('status', 'published')
            ->where('is_active', true)
            ->firstOrFail();

        // Validate basic fields
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ];

        // Add payment validation for paid events
        if (!$event->is_free) {
            $rules['payment_method'] = 'required|string|in:bca,mandiri,bni,bri';
            $rules['payment_proof'] = 'required|image|mimes:jpeg,jpg,png|max:2048';
        }

        $validated = $request->validate($rules);

        // Check if user already registered (double check)
        if (Auth::check()) {
            $existingRegistration = EventParticipant::where('event_hastana_id', $event->id)
                ->where(function($query) {
                    $query->where('user_id', Auth::id())
                          ->orWhere('email', Auth::user()->email);
                })
                ->whereIn('status', ['pending', 'confirmed', 'attended'])
                ->first();
            
            if ($existingRegistration) {
                return redirect()->route('events.show', $slug)
                    ->with('info', 'Anda sudah terdaftar di event ini! Kode registrasi: ' . $existingRegistration->registration_code);
            }
        }

        // Check availability again
        // Double-check availability using model method
        if ($event->is_full) {
            return back()->with('error', 'Maaf, event sudah penuh!')->withInput();
        }

        // Handle payment proof upload
        $paymentProofPath = null;
        if (!$event->is_free && $request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        // Save to database
        $participant = EventParticipant::create([
            'event_hastana_id' => $event->id,
            'user_id' => Auth::id(), // Save user_id
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'] ?? null,
            'position' => $validated['position'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'payment_method' => $validated['payment_method'] ?? null,
            'payment_proof' => $paymentProofPath,
            'status' => 'pending',
            'payment_status' => $event->is_free ? 'free' : 'pending',
        ]);

        // Increment participants
        $event->increment('current_participants');

        return redirect()->route('events.show', $slug)
            ->with('success', 'Pendaftaran berhasil! Kode registrasi Anda: ' . $participant->registration_code . '. Kami akan mengirimkan konfirmasi ke email Anda.');
    }

    /**
     * Show E-Ticket
     */
    public function showTicket($registrationCode)
    {
        $participant = EventParticipant::with('eventHastana')
            ->where('registration_code', $registrationCode)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if participant is confirmed
        if ($participant->status !== 'confirmed' && $participant->status !== 'attended') {
            return redirect()->route('dashboard')
                ->with('error', 'Tiket hanya tersedia untuk peserta yang sudah dikonfirmasi.');
        }

        return view('tickets.show', compact('participant'));
    }

    /**
     * Download E-Ticket as PDF (or show printable version)
     */
    public function downloadTicket($registrationCode)
    {
        $participant = EventParticipant::with('eventHastana')
            ->where('registration_code', $registrationCode)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if participant is confirmed
        if ($participant->status !== 'confirmed' && $participant->status !== 'attended') {
            return redirect()->route('dashboard')
                ->with('error', 'Tiket hanya tersedia untuk peserta yang sudah dikonfirmasi.');
        }

        // Check if DomPDF is installed
        if (class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('tickets.pdf', compact('participant'));
            return $pdf->download('E-Ticket-' . $registrationCode . '.pdf');
        }
        
        // Fallback: Return printable HTML page
        return view('tickets.download', compact('participant'));
    }
}
