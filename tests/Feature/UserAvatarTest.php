<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserAvatarTest extends TestCase
{
    use RefreshDatabase;

    public function test_remote_google_avatar_resolves_to_external_url(): void
    {
        $user = User::factory()->create([
            'avatar' => 'https://lh3.googleusercontent.com/a/example=s96-c',
        ]);

        $this->assertTrue($user->hasRemoteAvatar());
        $this->assertFalse($user->hasStoredAvatar());
        $this->assertSame('https://lh3.googleusercontent.com/a/example=s96-c', $user->avatar_url);
    }

    public function test_stored_avatar_resolves_to_public_storage_url(): void
    {
        $user = User::factory()->create([
            'avatar' => 'avatars/member.jpg',
        ]);

        $this->assertFalse($user->hasRemoteAvatar());
        $this->assertTrue($user->hasStoredAvatar());
        $this->assertSame(asset('storage/avatars/member.jpg'), $user->avatar_url);
    }

    public function test_profile_upload_replaces_google_avatar(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'avatar' => 'https://lh3.googleusercontent.com/a/example=s96-c',
        ]);

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $response->assertRedirect(route('profile.edit'));

        $user->refresh();

        $this->assertTrue($user->hasStoredAvatar());
        $this->assertStringStartsWith('avatars/', $user->avatar);
        Storage::disk('public')->assertExists($user->avatar);
    }
}
