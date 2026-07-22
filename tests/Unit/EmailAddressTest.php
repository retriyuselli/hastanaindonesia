<?php

namespace Tests\Unit;

use App\Models\User;
use App\Support\EmailAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailAddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_normalizes_gmail_dot_and_plus_aliases(): void
    {
        $this->assertSame(
            'ramadhonautama@gmail.com',
            EmailAddress::normalize('ramadhona.utama@gmail.com'),
        );
        $this->assertSame(
            'ramadhonautama@gmail.com',
            EmailAddress::normalize('rama.dhona.utama+hastana@gmail.com'),
        );
        $this->assertSame(
            'ramadhonautama@gmail.com',
            EmailAddress::normalize('ramadhonautama@googlemail.com'),
        );
    }

    public function test_it_does_not_strip_dots_for_non_gmail_providers(): void
    {
        $this->assertSame(
            'rama.dhona@outlook.com',
            EmailAddress::normalize('Rama.Dhona@outlook.com'),
        );
    }

    public function test_find_user_treats_gmail_aliases_as_one_identity_and_prefers_oldest_account(): void
    {
        $older = User::factory()->create([
            'email' => 'ramadhona.utama@gmail.com',
        ]);
        User::factory()->create([
            'email' => 'ramadhonautama@gmail.com',
        ]);

        $found = EmailAddress::findUser('rama.dhona.utama@gmail.com');

        $this->assertNotNull($found);
        $this->assertTrue($found->is($older));
        $this->assertTrue(EmailAddress::exists('ramadhonautama@gmail.com'));
    }
}
