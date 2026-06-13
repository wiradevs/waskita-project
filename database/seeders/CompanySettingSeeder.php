<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'company_name',     'value' => 'PT Waskita Karya',       'type' => 'text'],
            ['key' => 'company_tagline',  'value' => 'Membangun Kepercayaan, Menghadirkan Kualitas', 'type' => 'text'],
            ['key' => 'company_about',    'value' => "PT Waskita Karya adalah perusahaan yang bergerak di bidang konstruksi dan material bangunan dengan pengalaman lebih dari 20 tahun.\n\nKami berkomitmen untuk menyediakan produk berkualitas tinggi dengan harga yang kompetitif dan pelayanan yang profesional kepada seluruh pelanggan kami.\n\nDengan tim ahli yang berpengalaman dan fasilitas produksi modern, kami siap memenuhi kebutuhan konstruksi dan renovasi Anda.", 'type' => 'textarea'],
            ['key' => 'company_address',  'value' => 'Jl. Sudirman No. 123, Jakarta Pusat, DKI Jakarta 10220', 'type' => 'text'],
            ['key' => 'company_phone',    'value' => '(021) 555-1234',          'type' => 'text'],
            ['key' => 'company_email',    'value' => 'info@waskitakarya.com',   'type' => 'text'],
            ['key' => 'company_whatsapp', 'value' => '+6281234567890',          'type' => 'text'],
            ['key' => 'hero_title',       'value' => 'Solusi Konstruksi Terpercaya untuk Anda', 'type' => 'text'],
            ['key' => 'hero_subtitle',    'value' => 'Kami menyediakan berbagai produk dan layanan konstruksi berkualitas tinggi untuk memenuhi kebutuhan proyek Anda.', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            CompanySetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
