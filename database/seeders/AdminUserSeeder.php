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
        User::updateOrCreate(
            ['email' => 'admin@hastana.com'],
            [
                'name' => 'Administrator HASTANA',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'gender' => 'male',
                'date_of_birth' => '1985-01-15',
                'email_verified_at' => now(),
                'no_anggota' => 'HST-ADM-0001',
            ]
        );

        // Admin dari daftar
        User::updateOrCreate(
            ['email' => 'sidorabiweddingorganizer@gmail.com'],
            [
                'name' => 'Kiki Indah Permata',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567801',
                'gender' => 'female',
                'date_of_birth' => '1990-01-01',
                'email_verified_at' => now(),
                'no_anggota' => 'HST-ADM-0002',
            ]
        );

        User::updateOrCreate(
            ['email' => 'rulandmantiri0@gmail.com'],
            [
                'name' => 'Ruland R. Mantiri',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567802',
                'gender' => 'male',
                'date_of_birth' => '1988-02-15',
                'email_verified_at' => now(),
                'no_anggota' => 'HST-ADM-0003',
            ]
        );

        User::updateOrCreate(
            ['email' => 'myudhij@gmail.com'],
            [
                'name' => 'M. Yudhi J',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567803',
                'gender' => 'male',
                'date_of_birth' => '1985-03-20',
                'email_verified_at' => now(),
                'no_anggota' => 'HST-ADM-0004',
            ]
        );

        User::updateOrCreate(
            ['email' => 'weddinghalal@gmail.com'],
            [
                'name' => 'Risa Risdiasari',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567804',
                'gender' => 'female',
                'date_of_birth' => '1992-04-10',
                'email_verified_at' => now(),
                'no_anggota' => 'HST-ADM-0005',
            ]
        );

        User::updateOrCreate(
            ['email' => 'fleur.wo@yahoo.com'],
            [
                'name' => 'Reza Fahlafi Saragih',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567805',
                'gender' => 'male',
                'date_of_birth' => '1987-05-25',
                'email_verified_at' => now(),
                'no_anggota' => 'HST-ADM-0006',
            ]
        );

        User::updateOrCreate(
            ['email' => 'specialweddingmanagement@gmail.com'],
            [
                'name' => 'Toro',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567806',
                'gender' => 'male',
                'date_of_birth' => '1989-06-12',
                'email_verified_at' => now(),
                'no_anggota' => 'HST-ADM-0007',
            ]
        );

        User::updateOrCreate(
            ['email' => 'patronwedding@gmail.com'],
            [
                'name' => 'Yunarsih',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567807',
                'gender' => 'female',
                'date_of_birth' => '1991-07-08',
                'email_verified_at' => now(),
                'no_anggota' => 'HST-ADM-0008',
            ]
        );

        User::updateOrCreate(
            ['email' => 'projectwo@gmail.com'],
            [
                'name' => 'Yura Febriatma H',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567808',
                'gender' => 'female',
                'date_of_birth' => '1993-08-18',
                'email_verified_at' => now(),
                'no_anggota' => 'HST-ADM-0009',
            ]
        );

        User::updateOrCreate(
            ['email' => 'ramadhona.utama@gmail.com'],
            [
                'name' => 'Rama Dhona Utama',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567809',
                'gender' => 'male',
                'date_of_birth' => '1986-09-22',
                'email_verified_at' => now(),
                'no_anggota' => 'HST-ADM-0010',
            ]
        );

        // Operator (menggunakan role admin karena enum terbatas)
        User::updateOrCreate(
            ['email' => 'operator@hastana.com'],
            [
                'name' => 'Operator HASTANA',
                'password' => Hash::make('password123'),
                'role' => 'admin', // Menggunakan admin karena enum terbatas
                'phone' => '081234567891',
                'gender' => 'female',
                'date_of_birth' => '1990-03-20',
                'email_verified_at' => now(),
                'no_anggota' => 'HST-OPR-0001',
            ]
        );

        // Member Regular
        User::updateOrCreate(
            ['email' => 'member@hastana.com'],
            [
                'name' => 'Member HASTANA',
                'password' => Hash::make('password123'),
                'role' => 'member',
                'phone' => '081234567892',
                'gender' => 'male',
                'date_of_birth' => '1992-07-10',
                'email_verified_at' => now(),
                'no_anggota' => 'HST-MEM-0001',
            ]
        );

        // Customer
        User::updateOrCreate(
            ['email' => 'customer@hastana.com'],
            [
                'name' => 'Customer HASTANA',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '081234567893',
                'gender' => 'female',
                'date_of_birth' => '1988-11-25',
                'email_verified_at' => now(),
                'no_anggota' => 'HST-CUS-0001',
            ]
        );

        $this->command->info('User seeder completed successfully!');
        $this->command->info('Created users with available roles:');
        $this->command->info('- Admin: admin@hastana.com, operator@hastana.com (password: password123)');
        $this->command->info('- Admin Team: sidorabiweddingorganizer@gmail.com, rulandmantiri0@gmail.com, myudhij@gmail.com, etc. (password: password123)');
        $this->command->info('- Member: member@hastana.com (password: password123)');
        $this->command->info('- Customer: customer@hastana.com (password: password123)');
        $this->command->info('Note: Role enum currently supports: admin, member, customer');
        $this->command->info('Total Admin accounts: ' . User::where('role', 'admin')->count());
    }
}
