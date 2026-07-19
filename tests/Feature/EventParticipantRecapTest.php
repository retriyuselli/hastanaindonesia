<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EventParticipantRecapTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_preview_recap_without_browser_caching(): void
    {
        $user = $this->userWithRole('admin');

        $response = $this->actingAs($user)
            ->get(route('admin.files.event-participants.recap'));

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('X-Content-Type-Options', 'nosniff');

        $this->assertStringStartsWith(
            'inline; filename="rekapan-peserta-',
            (string) $response->headers->get('Content-Disposition'),
        );
        $this->assertStringContainsString(
            'no-store',
            (string) $response->headers->get('Cache-Control'),
        );
        $this->assertStringContainsString(
            'private',
            (string) $response->headers->get('Cache-Control'),
        );
    }

    public function test_admin_can_download_recap_as_an_attachment(): void
    {
        $user = $this->userWithRole('admin');

        $response = $this->actingAs($user)
            ->get(route('admin.files.event-participants.recap', ['download' => 1]));

        $response->assertOk();
        $this->assertStringStartsWith(
            'attachment; filename="rekapan-peserta-',
            (string) $response->headers->get('Content-Disposition'),
        );
    }

    public function test_non_admin_panel_user_cannot_access_recap(): void
    {
        $user = $this->userWithRole(
            config('filament-shield.panel_user.name', 'panel_user'),
        );

        $this->actingAs($user)
            ->get(route('admin.files.event-participants.recap'))
            ->assertForbidden();
    }

    private function userWithRole(string $roleName): User
    {
        $role = Role::findOrCreate($roleName);
        $user = User::factory()->create(['status' => 'active']);
        $user->assignRole($role);

        return $user;
    }
}
