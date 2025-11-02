<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Blog;
use App\Models\Company;
use App\Models\EventHastana;
use App\Models\EventParticipant;
use App\Models\User;
use App\Models\WeddingOrganizer;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Users
        $totalUsers = User::count();
        $adminUsers = User::where('role', 'admin')->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        // Events
        $totalEvents = EventHastana::count();
        $upcomingEvents = EventHastana::where('status', 'published')
            ->where('start_date', '>', now())
            ->count();
        $totalParticipants = EventParticipant::count();
        
        // Blogs
        $totalBlogs = Blog::count();
        $publishedBlogs = Blog::where('status', 'published')->count();
        $totalViews = Blog::sum('views_count');
        
        // Companies & WOs
        $totalCompanies = Company::where('legal_document_status', 'verified')->count();
        $totalWOs = WeddingOrganizer::where('verification_status', 'verified')->count();
        
        // Revenue from Events
        $totalRevenue = EventParticipant::where('payment_status', 'paid')
            ->join('event_hastanas', 'event_participants.event_hastana_id', '=', 'event_hastanas.id')
            ->sum('event_hastanas.price');
        
        return [
            Stat::make('Total Users', number_format($totalUsers))
                ->description("{$newUsersThisMonth} new this month")
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->chart([
                    $totalUsers * 0.5,
                    $totalUsers * 0.65,
                    $totalUsers * 0.8,
                    $totalUsers * 0.9,
                    $totalUsers
                ]),
            
            Stat::make('Registered Users', number_format($totalUsers))
                ->description("{$adminUsers} admin users")
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([
                    $totalUsers * 0.6,
                    $totalUsers * 0.75,
                    $totalUsers * 0.85,
                    $totalUsers * 0.95,
                    $totalUsers
                ]),
            
            Stat::make('Events', number_format($totalEvents))
                ->description("{$upcomingEvents} upcoming events")
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning')
                ->chart([
                    $totalEvents * 0.4,
                    $totalEvents * 0.6,
                    $totalEvents * 0.75,
                    $totalEvents * 0.9,
                    $totalEvents
                ]),
            
            Stat::make('Event Participants', number_format($totalParticipants))
                ->description("Across all events")
                ->descriptionIcon('heroicon-m-users')
                ->color('info')
                ->chart([
                    $totalParticipants * 0.5,
                    $totalParticipants * 0.7,
                    $totalParticipants * 0.85,
                    $totalParticipants * 0.92,
                    $totalParticipants
                ]),
            
            Stat::make('Blog Articles', number_format($totalBlogs))
                ->description("{$publishedBlogs} published")
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success')
                ->chart([
                    $totalBlogs * 0.4,
                    $totalBlogs * 0.6,
                    $totalBlogs * 0.8,
                    $totalBlogs * 0.9,
                    $totalBlogs
                ]),
            
            Stat::make('Total Views', number_format($totalViews))
                ->description("Blog article views")
                ->descriptionIcon('heroicon-m-eye')
                ->color('primary')
                ->chart([
                    $totalViews * 0.3,
                    $totalViews * 0.5,
                    $totalViews * 0.7,
                    $totalViews * 0.85,
                    $totalViews
                ]),
            
            Stat::make('Companies', number_format($totalCompanies))
                ->description("Verified companies")
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('warning')
                ->chart([
                    $totalCompanies * 0.5,
                    $totalCompanies * 0.7,
                    $totalCompanies * 0.85,
                    $totalCompanies * 0.95,
                    $totalCompanies
                ]),
            
            Stat::make('Wedding Organizers', number_format($totalWOs))
                ->description("Verified WOs")
                ->descriptionIcon('heroicon-m-heart')
                ->color('danger')
                ->chart([
                    $totalWOs * 0.6,
                    $totalWOs * 0.75,
                    $totalWOs * 0.88,
                    $totalWOs * 0.96,
                    $totalWOs
                ]),
            
            Stat::make('Event Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description("From paid events")
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart([
                    $totalRevenue * 0.4,
                    $totalRevenue * 0.6,
                    $totalRevenue * 0.75,
                    $totalRevenue * 0.9,
                    $totalRevenue
                ]),
        ];
    }
}
