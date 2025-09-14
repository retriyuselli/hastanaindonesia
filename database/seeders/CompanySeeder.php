<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Region;
use Carbon\Carbon;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = [
            'company_name' => 'Himpunan Perusahaan Penata Acara Indonesia',
            'business_license' => 'SIUP/001/HASTANA/2020',
            'owner_name' => 'Dr. Ir. Soekarno Hastana, M.M.',
            'email' => 'info@hastana.id',
            'phone' => '+62-21-12345678',
            'address' => 'Gedung HASTANA Center, Jl. HR. Rasuna Said Kav. C-5, Kuningan',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'postal_code' => '12940',
            'website' => 'https://www.hastana.id',
            'description' => 'Himpunan Perusahaan Penata Acara Indonesia (HASTANA) adalah organisasi profesi yang menaungi wedding organizer dan event organizer di seluruh Indonesia. Didirikan dengan tujuan untuk meningkatkan profesionalisme industri wedding planning, memberikan standar kualitas pelayanan, serta memfasilitasi pengembangan bisnis anggota melalui sertifikasi, pelatihan, dan networking.',
            'logo_url' => '/images/hastana-logo.png',
            'established_year' => 2020,
            'employee_count' => 25,
            
            // Data Legalitas
            'legal_entity_type' => 'Perkumpulan',
            'deed_of_establishment' => 'No. 01 Tahun 2020',
            'deed_date' => Carbon::parse('2020-01-15'),
            'notary_name' => 'Dr. Maria Siti Hardiyanti Rukmana, S.H., M.Kn.',
            'notary_license_number' => 'SK.01/2019/HASTANA',
            'nib_number' => '1234567890123456',
            'nib_issued_date' => Carbon::parse('2020-02-01'),
            'nib_valid_until' => Carbon::parse('2025-02-01'),
            'npwp_number' => '01.234.567.8-901.000',
            'npwp_issued_date' => Carbon::parse('2020-02-15'),
            'tax_office' => 'KPP Pratama Jakarta Kuningan',
            'legal_document_status' => 'verified',
            'legal_document_notes' => 'Semua dokumen legal telah diverifikasi dan sesuai dengan peraturan yang berlaku.',
            'legal_verified_at' => Carbon::parse('2020-03-01'),
            'legal_verified_by' => 1, // Admin user ID
            'legal_documents' => json_encode([
                'akta_pendirian' => '/documents/hastana/akta-pendirian.pdf',
                'sk_kemenkumham' => '/documents/hastana/sk-kemenkumham.pdf',
                'nib_document' => '/documents/hastana/nib-hastana.pdf',
                'npwp_document' => '/documents/hastana/npwp-hastana.pdf',
                'domicile_letter' => '/documents/hastana/surat-domisili.pdf'
            ])
        ];

        Company::updateOrCreate(
            ['company_name' => $company['company_name']],
            $company
        );

        $this->command->info('Company seeder completed! Created HASTANA Indonesia headquarters company profile.');
    }
}
