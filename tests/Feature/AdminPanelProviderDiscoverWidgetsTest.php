<?php

namespace Tests\Feature;

use App\Filament\Widgets\ActivityTrendChart;
use App\Filament\Widgets\DashboardStatsOverview;
use App\Filament\Widgets\LatestActivities;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class AdminPanelProviderDiscoverWidgetsTest extends TestCase
{
    public function test_admin_panel_provider_discovers_widgets_from_filament_widgets_folder(): void
    {
        $providerPath = app_path('Providers/Filament/AdminPanelProvider.php');
        $this->assertFileExists($providerPath);

        $contents = File::get($providerPath);

        $this->assertStringNotContainsString("app_path('Filament/Admin/Widgets')", $contents);
        $this->assertStringNotContainsString("for: 'App\\Filament\\Admin\\Widgets'", $contents);

        $this->assertStringContainsString("app_path('Filament/Widgets')", $contents);
        $this->assertStringContainsString("for: 'App\\\\Filament\\\\Widgets'", $contents);

        $this->assertTrue(class_exists(DashboardStatsOverview::class));
        $this->assertTrue(class_exists(ActivityTrendChart::class));
        $this->assertTrue(class_exists(LatestActivities::class));
        $this->assertFalse(@class_exists('App\\Filament\\Admin\\Widgets\\DashboardStatsOverview'));
        $this->assertFalse(@class_exists('App\\Filament\\Admin\\Widgets\\ActivityTrendChart'));
        $this->assertFalse(@class_exists('App\\Filament\\Admin\\Widgets\\LatestActivities'));
    }
}
