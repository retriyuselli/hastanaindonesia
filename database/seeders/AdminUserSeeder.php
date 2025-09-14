<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrator
        User::firstOrCreate(
            ['email' => 'admin@hastana.com'],
            [
                'name' => 'Administrator HASTANA',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'gender' => 'male',
                'date_of_birth' => '1985-01-15',
                'email_verified_at' => now(),
            ]
        );

        // Operator (menggunakan role admin karena enum terbatas)
        User::firstOrCreate(
            ['email' => 'operator@hastana.com'],
            [
                'name' => 'Operator HASTANA',
                'password' => Hash::make('password123'),
                'role' => 'admin', // Menggunakan admin karena enum terbatas
                'phone' => '081234567891',
                'gender' => 'female',
                'date_of_birth' => '1990-03-20',
                'email_verified_at' => now(),
            ]
        );

        // Member Regular
        User::firstOrCreate(
            ['email' => 'member1@hastana.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'role' => 'member',
                'phone' => '081234567892',
                'gender' => 'male',
                'date_of_birth' => '1992-07-10',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'member2@hastana.com'],
            [
                'name' => 'Sari Indah',
                'password' => Hash::make('password123'),
                'role' => 'member',
                'phone' => '081234567893',
                'gender' => 'female',
                'date_of_birth' => '1988-11-25',
                'email_verified_at' => now(),
            ]
        );

        // Wedding Organizer (menggunakan role member)
        User::firstOrCreate(
            ['email' => 'wo1@hastana.com'],
            [
                'name' => 'Dewi Wedding Organizer',
                'password' => Hash::make('password123'),
                'role' => 'member', // Menggunakan member karena enum terbatas
                'phone' => '081234567894',
                'gender' => 'female',
                'date_of_birth' => '1987-05-12',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'wo2@hastana.com'],
            [
                'name' => 'Andi Pratama Wedding',
                'password' => Hash::make('password123'),
                'role' => 'member', // Menggunakan member karena enum terbatas
                'phone' => '081234567895',
                'gender' => 'male',
                'date_of_birth' => '1986-09-18',
                'email_verified_at' => now(),
            ]
        );

        // Company (menggunakan role customer)
        User::firstOrCreate(
            ['email' => 'company1@hastana.com'],
            [
                'name' => 'PT. Maju Bersama',
                'password' => Hash::make('password123'),
                'role' => 'customer', // Company menggunakan customer
                'phone' => '021-12345678',
                'gender' => null, // Company tidak memiliki gender
                'date_of_birth' => null, // Company tidak memiliki tanggal lahir
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'company2@hastana.com'],
            [
                'name' => 'CV. Sukses Mandiri',
                'password' => Hash::make('password123'),
                'role' => 'customer', // Company menggunakan customer
                'phone' => '021-87654321',
                'gender' => null,
                'date_of_birth' => null,
                'email_verified_at' => now(),
            ]
        );

        // Additional Members for testing
        for ($i = 3; $i <= 10; $i++) {
            User::firstOrCreate(
                ['email' => "member{$i}@hastana.com"],
                [
                    'name' => "Member Pengujian {$i}",
                    'password' => Hash::make('password123'),
                    'role' => 'member',
                    'phone' => '08123456789' . $i,
                    'gender' => $i % 2 == 0 ? 'female' : 'male',
                    'date_of_birth' => '199' . ($i % 10) . '-0' . ($i % 9 + 1) . '-' . (10 + $i),
                    'email_verified_at' => now(),
                ]
            );
        }

        // Additional customers for testing
        for ($i = 1; $i <= 5; $i++) {
            User::firstOrCreate(
                ['email' => "customer{$i}@hastana.com"],
                [
                    'name' => "Customer {$i}",
                    'password' => Hash::make('password123'),
                    'role' => 'customer',
                    'phone' => '08987654321' . $i,
                    'gender' => $i % 2 == 0 ? 'male' : 'female',
                    'date_of_birth' => '198' . ($i % 10) . '-0' . ($i % 9 + 1) . '-' . (5 + $i),
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('User seeder completed successfully!');
        $this->command->info('Created users with available roles:');
        $this->command->info('- Admin: admin@hastana.com, operator@hastana.com (password: password123)');
        $this->command->info('- Members: member1-member10@hastana.com, wo1-wo2@hastana.com (password: password123)');
        $this->command->info('- Customers: customer1-customer5@hastana.com, company1-company2@hastana.com (password: password123)');
        $this->command->info('Note: Role enum currently supports: admin, member, customer');
    }
}
