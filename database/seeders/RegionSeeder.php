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
            // Pulau Jawa
            [
                'region_name' => 'DPW Jakarta',
                'province' => 'DKI Jakarta',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Jakarta, menaungi wedding organizer profesional di ibu kota dan sekitarnya.',
                'contact_email' => 'jakarta@hastana.id',
                'contact_phone' => '+62-21-12345678',
                'website' => 'https://jakarta.hastana.id',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'postal_code' => '10220',
                'establishment_date' => Carbon::parse('2020-01-15'),
                'is_active' => true,
                'ketua_dpw' => null,
                'wk_ketua_dpw' => null,
                'sekretaris_dpw' => null,
                'bendahara_dpw' => null,
            ],
            [
                'region_name' => 'DPW Jawa Barat',
                'province' => 'Jawa Barat',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Jawa Barat, melayani wedding organizer di Bandung, Bogor, Depok, Bekasi, dan seluruh Jawa Barat.',
                'contact_email' => 'jabar@hastana.id',
                'contact_phone' => '+62-22-87654321',
                'website' => 'https://jabar.hastana.id',
                'address' => 'Jl. Asia Afrika No. 45, Bandung',
                'postal_code' => '40111',
                'establishment_date' => Carbon::parse('2020-02-20'),
                'is_active' => true,
            ],
            [
                'region_name' => 'DPW Jawa Tengah',
                'province' => 'Jawa Tengah',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Jawa Tengah, koordinasi wedding organizer di Semarang, Solo, Yogyakarta, dan sekitarnya.',
                'contact_email' => 'jateng@hastana.id',
                'contact_phone' => '+62-24-11223344',
                'website' => 'https://jateng.hastana.id',
                'address' => 'Jl. Pemuda No. 67, Semarang',
                'postal_code' => '50132',
                'establishment_date' => Carbon::parse('2020-03-10'),
                'is_active' => true,
            ],
            [
                'region_name' => 'DPW Jawa Timur',
                'province' => 'Jawa Timur',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Jawa Timur, mengelola wedding organizer di Surabaya, Malang, Kediri, dan seluruh Jawa Timur.',
                'contact_email' => 'jatim@hastana.id',
                'contact_phone' => '+62-31-99887766',
                'website' => 'https://jatim.hastana.id',
                'address' => 'Jl. Tunjungan No. 89, Surabaya',
                'postal_code' => '60261',
                'establishment_date' => Carbon::parse('2020-04-05'),
                'is_active' => true,
            ],

            // Sumatera
            [
                'region_name' => 'DPW Sumatera Utara',
                'province' => 'Sumatera Utara',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Sumatera Utara, pusat koordinasi wedding organizer di Medan dan sekitarnya.',
                'contact_email' => 'sumut@hastana.id',
                'contact_phone' => '+62-61-55443322',
                'website' => 'https://sumut.hastana.id',
                'address' => 'Jl. Sisingamangaraja No. 12, Medan',
                'postal_code' => '20212',
                'establishment_date' => Carbon::parse('2020-05-15'),
                'is_active' => true,
            ],
            [
                'region_name' => 'DPW Sumatera Barat',
                'province' => 'Sumatera Barat',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Sumatera Barat, menaungi wedding organizer di Padang dan Minangkabau.',
                'contact_email' => 'sumbar@hastana.id',
                'contact_phone' => '+62-751-33221100',
                'website' => 'https://sumbar.hastana.id',
                'address' => 'Jl. Diponegoro No. 34, Padang',
                'postal_code' => '25112',
                'establishment_date' => Carbon::parse('2020-06-20'),
                'is_active' => true,
            ],
            [
                'region_name' => 'DPW Riau',
                'province' => 'Riau',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Riau, melayani wedding organizer di Pekanbaru dan seluruh provinsi Riau.',
                'contact_email' => 'riau@hastana.id',
                'contact_phone' => '+62-761-77889900',
                'website' => 'https://riau.hastana.id',
                'address' => 'Jl. Sudirman No. 56, Pekanbaru',
                'postal_code' => '28116',
                'establishment_date' => Carbon::parse('2020-07-10'),
                'is_active' => true,
            ],

            // Kalimantan
            [
                'region_name' => 'DPW Kalimantan Timur',
                'province' => 'Kalimantan Timur',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Kalimantan Timur, koordinasi wedding organizer di Balikpapan, Samarinda, dan sekitarnya.',
                'contact_email' => 'kaltim@hastana.id',
                'contact_phone' => '+62-542-44556677',
                'website' => 'https://kaltim.hastana.id',
                'address' => 'Jl. Jenderal Sudirman No. 78, Balikpapan',
                'postal_code' => '76112',
                'establishment_date' => Carbon::parse('2020-08-25'),
                'is_active' => true,
            ],
            [
                'region_name' => 'DPW Kalimantan Selatan',
                'province' => 'Kalimantan Selatan',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Kalimantan Selatan, mengelola wedding organizer di Banjarmasin dan sekitarnya.',
                'contact_email' => 'kalsel@hastana.id',
                'contact_phone' => '+62-511-66778899',
                'website' => 'https://kalsel.hastana.id',
                'address' => 'Jl. Ahmad Yani No. 90, Banjarmasin',
                'postal_code' => '70117',
                'establishment_date' => Carbon::parse('2020-09-15'),
                'is_active' => true,
            ],

            // Sulawesi
            [
                'region_name' => 'DPW Sulawesi Selatan',
                'province' => 'Sulawesi Selatan',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Sulawesi Selatan, pusat wedding organizer di Makassar dan Sulawesi Selatan.',
                'contact_email' => 'sulsel@hastana.id',
                'contact_phone' => '+62-411-88990011',
                'website' => 'https://sulsel.hastana.id',
                'address' => 'Jl. Metro Tanjung Bunga No. 123, Makassar',
                'postal_code' => '90224',
                'establishment_date' => Carbon::parse('2020-10-20'),
                'is_active' => true,
            ],
            [
                'region_name' => 'DPW Sulawesi Utara',
                'province' => 'Sulawesi Utara',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Sulawesi Utara, melayani wedding organizer di Manado dan sekitarnya.',
                'contact_email' => 'sulut@hastana.id',
                'contact_phone' => '+62-431-22334455',
                'website' => 'https://sulut.hastana.id',
                'address' => 'Jl. Sam Ratulangi No. 45, Manado',
                'postal_code' => '95111',
                'establishment_date' => Carbon::parse('2020-11-10'),
                'is_active' => true,
            ],

            // Bali & Nusa Tenggara
            [
                'region_name' => 'DPW Bali',
                'province' => 'Bali',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Bali, destinasi wedding terpopuler dengan wedding organizer profesional terbaik.',
                'contact_email' => 'bali@hastana.id',
                'contact_phone' => '+62-361-55667788',
                'website' => 'https://bali.hastana.id',
                'address' => 'Jl. Sunset Road No. 67, Denpasar',
                'postal_code' => '80117',
                'establishment_date' => Carbon::parse('2020-12-01'),
                'is_active' => true,
            ],
            [
                'region_name' => 'DPW Nusa Tenggara Barat',
                'province' => 'Nusa Tenggara Barat',
                'description' => 'Dewan Pimpinan Wilayah HASTANA NTB, menaungi wedding organizer di Lombok dan sekitarnya.',
                'contact_email' => 'ntb@hastana.id',
                'contact_phone' => '+62-370-77889900',
                'website' => 'https://ntb.hastana.id',
                'address' => 'Jl. Pejanggik No. 89, Mataram',
                'postal_code' => '83115',
                'establishment_date' => Carbon::parse('2021-01-15'),
                'is_active' => true,
            ],

            // Papua
            [
                'region_name' => 'DPW Papua',
                'province' => 'Papua',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Papua, mengembangkan industri wedding organizer di ujung timur Indonesia.',
                'contact_email' => 'papua@hastana.id',
                'contact_phone' => '+62-967-11223344',
                'website' => 'https://papua.hastana.id',
                'address' => 'Jl. Ahmad Yani No. 12, Jayapura',
                'postal_code' => '99112',
                'establishment_date' => Carbon::parse('2021-02-20'),
                'is_active' => true,
            ],

            // Maluku
            [
                'region_name' => 'DPW Maluku',
                'province' => 'Maluku',
                'description' => 'Dewan Pimpinan Wilayah HASTANA Maluku, melayani wedding organizer di kepulauan Maluku.',
                'contact_email' => 'maluku@hastana.id',
                'contact_phone' => '+62-911-99887766',
                'website' => 'https://maluku.hastana.id',
                'address' => 'Jl. Pattimura No. 34, Ambon',
                'postal_code' => '97116',
                'establishment_date' => Carbon::parse('2021-03-10'),
                'is_active' => true,
            ],
        ];

        foreach ($regions as $region) {
            Region::updateOrCreate(
                ['region_name' => $region['region_name']],
                $region
            );
        }

        $this->command->info('Region seeder completed! Created ' . count($regions) . ' regions covering major provinces in Indonesia.');
    }
}
