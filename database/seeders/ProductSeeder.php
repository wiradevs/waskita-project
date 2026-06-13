<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Baja & Besi',      'slug' => 'baja-besi',      'description' => 'Material baja dan besi untuk konstruksi'],
            ['name' => 'Semen & Beton',    'slug' => 'semen-beton',    'description' => 'Produk semen dan beton siap pakai'],
            ['name' => 'Bata & Dinding',   'slug' => 'bata-dinding',   'description' => 'Material dinding dan partisi'],
            ['name' => 'Atap & Plafon',    'slug' => 'atap-plafon',    'description' => 'Material atap dan plafon'],
            ['name' => 'Pipa & Sanitasi',  'slug' => 'pipa-sanitasi',  'description' => 'Sistem perpipaan dan sanitasi'],
            ['name' => 'Cat & Finishing',  'slug' => 'cat-finishing',  'description' => 'Produk cat dan finishing bangunan'],
        ];

        foreach ($categories as $i => $cat) {
            ProductCategory::updateOrCreate(['slug' => $cat['slug']], array_merge($cat, ['sort_order' => $i + 1, 'is_active' => true]));
        }

        $products = [
            ['category' => 'baja-besi',    'name' => 'Besi Beton Ulir D10', 'price' => 85000, 'unit' => 'batang', 'featured' => true,
             'desc' => 'Besi beton ulir diameter 10mm, panjang 12 meter. Cocok untuk struktur beton bertulang.'],
            ['category' => 'baja-besi',    'name' => 'Besi Beton Polos D8',  'price' => 65000, 'unit' => 'batang', 'featured' => false,
             'desc' => 'Besi beton polos diameter 8mm, panjang 12 meter. Ideal untuk rangka atap dan kolom.'],
            ['category' => 'baja-besi',    'name' => 'Hollow Baja 4x4 cm',   'price' => 120000, 'unit' => 'batang', 'featured' => true,
             'desc' => 'Hollow baja galvanis ukuran 4x4 cm, tebal 1.2mm. Untuk rangka partisi dan furniture.'],
            ['category' => 'semen-beton',  'name' => 'Semen Tiga Roda 50kg', 'price' => 72000, 'unit' => 'sak', 'featured' => true,
             'desc' => 'Semen portland tipe I, kemasan 50kg. Cocok untuk semua jenis pekerjaan konstruksi.'],
            ['category' => 'semen-beton',  'name' => 'Beton Ready Mix K-250', 'price' => 950000, 'unit' => 'm³', 'featured' => false,
             'desc' => 'Beton ready mix mutu K-250, siap dikirim ke lokasi proyek Anda.'],
            ['category' => 'bata-dinding', 'name' => 'Bata Merah Jumbo',     'price' => 1200, 'unit' => 'biji', 'featured' => false,
             'desc' => 'Bata merah press ukuran jumbo, kualitas A. Cocok untuk dinding eksterior.'],
            ['category' => 'bata-dinding', 'name' => 'Hebel / Bata Ringan',  'price' => 650000, 'unit' => 'm³', 'featured' => true,
             'desc' => 'Bata ringan (hebel) AAC, ukuran 60x20x7.5cm. Ringan, kuat, dan hemat semen.'],
            ['category' => 'atap-plafon',  'name' => 'Genteng Metal Berpasir', 'price' => 45000, 'unit' => 'lembar', 'featured' => true,
             'desc' => 'Genteng metal berpasir anti karat, ketebalan 0.27mm. Ringan dan tahan cuaca.'],
            ['category' => 'atap-plafon',  'name' => 'Plafon Gypsum 9mm',   'price' => 78000, 'unit' => 'lembar', 'featured' => false,
             'desc' => 'Plafon gypsum board tebal 9mm, ukuran 1200x2400mm. Untuk interior bangunan.'],
            ['category' => 'pipa-sanitasi','name' => 'Pipa PVC 4 inch',      'price' => 85000, 'unit' => 'batang', 'featured' => false,
             'desc' => 'Pipa PVC AW diameter 4 inch, panjang 4 meter. Untuk instalasi saluran pembuangan.'],
            ['category' => 'cat-finishing','name' => 'Cat Tembok 25kg',       'price' => 350000, 'unit' => 'ember', 'featured' => true,
             'desc' => 'Cat tembok interior berbasis air, daya sebar luas, warna tahan lama dan mudah dibersihkan.'],
            ['category' => 'cat-finishing','name' => 'Cat Anti Bocor 4kg',   'price' => 185000, 'unit' => 'kg', 'featured' => false,
             'desc' => 'Cat waterproof elastis untuk atap dak dan dinding. Anti bocor dan tahan UV.'],
        ];

        foreach ($products as $i => $p) {
            $category = ProductCategory::where('slug', $p['category'])->first();
            if (! $category) continue;

            Product::updateOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'product_category_id' => $category->id,
                    'name'                => $p['name'],
                    'slug'                => Str::slug($p['name']),
                    'short_description'   => $p['desc'],
                    'description'         => '<p>' . $p['desc'] . '</p><p>Untuk informasi lebih lanjut mengenai spesifikasi, ketersediaan stok, dan penawaran harga, silakan hubungi tim kami.</p>',
                    'price'               => $p['price'],
                    'price_unit'          => $p['unit'],
                    'is_featured'         => $p['featured'],
                    'is_active'           => true,
                    'sort_order'          => $i + 1,
                ]
            );
        }
    }
}
