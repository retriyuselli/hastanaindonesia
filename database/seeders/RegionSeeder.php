<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;
use Carbon\Carbon;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            [
                'region_name' => 'Sumatera Utara',
                'province' => 'Sumatera Utara',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Sumatera Utara, pusat koordinasi wedding organizer di Medan dan sekitarnya.',
                'contact_email' => 'sumut@hastanaindonesia.id',
                'contact_phone' => '+62-61-55443322',
                'website' => 'https://hastanaindonesia.id/sumatera-utara',
                'address' => 'Jl. Sisingamangaraja No. 12, Medan',
                'postal_code' => '20212',
                'establishment_date' => Carbon::parse('2020-05-15'),
                'is_active' => true,
                'ketua_dpw' => null,
                'wk_ketua_dpw' => null,
                'sekretaris_dpw' => null,
                'bendahara_dpw' => null,
            ],
            [
                'region_name' => 'Sumatera Selatan',
                'province' => 'Sumatera Selatan',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Sumatera Selatan, melayani wedding organizer di Palembang dan sekitarnya.',
                'contact_email' => 'sumsel@hastanaindonesia.id',
                'contact_phone' => '+62-711-33445566',
                'website' => 'https://hastanaindonesia.id/sumatera-selatan',
                'address' => 'Jl. Sudirman No. 78, Palembang',
                'postal_code' => '30126',
                'establishment_date' => Carbon::parse('2020-06-10'),
                'is_active' => true,
            ],
            [
                'region_name' => 'Lampung',
                'province' => 'Lampung',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Lampung, menaungi wedding organizer di Bandar Lampung dan sekitarnya.',
                'contact_email' => 'lampung@hastanaindonesia.id',
                'contact_phone' => '+62-721-77889900',
                'website' => 'https://hastanaindonesia.id/lampung',
                'address' => 'Jl. Zainal Abidin Pagar Alam No. 45, Bandar Lampung',
                'postal_code' => '35142',
                'establishment_date' => Carbon::parse('2020-07-20'),
                'is_active' => true,
            ],
            [
                'region_name' => 'Jabodetabek',
                'province' => 'DKI Jakarta',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Jabodetabek, menaungi wedding organizer profesional di Jakarta, Bogor, Depok, Tangerang, dan Bekasi.',
                'contact_email' => 'jabodetabek@hastanaindonesia.id',
                'contact_phone' => '+62-21-12345678',
                'website' => 'https://hastanaindonesia.id/jabodetabek',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'postal_code' => '10220',
                'establishment_date' => Carbon::parse('2020-01-15'),
                'is_active' => true,
            ],
            [
                'region_name' => 'Yogyakarta',
                'province' => 'D.I. Yogyakarta',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Yogyakarta, koordinasi wedding organizer di Yogyakarta dan sekitarnya.',
                'contact_email' => 'yogya@hastanaindonesia.id',
                'contact_phone' => '+62-274-44556677',
                'website' => 'https://hastanaindonesia.id/yogyakarta',
                'address' => 'Jl. Malioboro No. 89, Yogyakarta',
                'postal_code' => '55271',
                'establishment_date' => Carbon::parse('2020-08-25'),
                'is_active' => true,
            ],
            [
                'region_name' => 'Jawa Tengah',
                'province' => 'Jawa Tengah',
                                'description' => 'Dewan Pimpinan Wilayah HASTANA Jawa Tengah, koordinasi wedding organizer di Jawa Tengah dan sekitarnya.',
                'contact_email' => 'jateng@hastanaindonesia.id',
                'contact_phone' => '+62-24-33445566',
                'website' => 'https://hastanaindonesia.id/jawa-tengah',
                'address' => 'Jl. Pemuda No. 67, Semarang',
                'postal_code' => '50132',
                'establishment_date' => Carbon::parse('2020-03-10'),
                'is_active' => true,
            ],
            [
                'region_name' => 'Jawa Timur',
                'province' => 'Jawa Timur',
                                'description' => 'Dewan Pimpinan Wilayah HASTANA Jawa Timur, koordinasi wedding organizer di Jawa Timur dan sekitarnya.',
                'contact_email' => 'jatim@hastanaindonesia.id',
                'contact_phone' => '+62-31-77889900',
                'website' => 'https://hastanaindonesia.id/jawa-timur',
                'address' => 'Jl. Tunjungan No. 89, Surabaya',
                'postal_code' => '60261',
                'establishment_date' => Carbon::parse('2020-04-05'),
                'is_active' => true,
            ],
        ];

        foreach ($regions as $region) {
            Region::updateOrCreate(
                ['region_name' => $region['region_name']],
                $region
            );
        }

        $this->command->info('Region seeder completed! Created ' . count($regions) . ' regions covering major areas in Indonesia.');
    }
}
