<?php

namespace App\Http\Controllers;

use App\Models\EventParticipant;
use App\Models\EventHastana;
use App\Models\WeddingOrganizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Hitung total event yang sudah didaftarkan
        $totalRegistered = EventParticipant::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed', 'attended'])
            ->count();

        // Hitung event yang akan datang
        $upcomingEvents = EventParticipant::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed', 'attended'])
            ->whereHas('eventHastana', function($q) {
                $q->where('start_date', '>=', now());
            })
            ->count();

        // Hitung event yang sudah selesai
        $completedEvents = EventParticipant::where('user_id', $user->id)
            ->whereIn('status', ['confirmed', 'attended'])
            ->whereHas('eventHastana', function($q) {
                $q->where('end_date', '<', now());
            })
            ->count();

        // Ambil semua event yang sudah didaftarkan
        $myEvents = EventParticipant::with(['eventHastana.eventCategory'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed', 'attended'])
            ->latest()
            ->get();

        // Event rekomendasi
        $recommendedEvents = EventHastana::with('eventCategory')
            ->where('status', 'published')
            ->where('start_date', '>=', now())
            ->whereDoesntHave('participants', function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->whereIn('status', ['pending', 'confirmed', 'attended']);
            })
            ->orderBy('start_date', 'asc')
            ->limit(6)
            ->get();

        // Ambil Wedding Organizer milik user
        $myWeddingOrganizer = WeddingOrganizer::where('user_id', $user->id)->first();

        return view('dashboard', compact(
            'totalRegistered',
            'upcomingEvents',
            'completedEvents',
            'myEvents',
            'recommendedEvents',
            'myWeddingOrganizer'
        ));
    }
}
