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
        // Clear existing data
        Product::query()->delete();
        ProductCategory::query()->delete();

        $categories = [
            ['name' => 'Sofa & Lounge',       'slug' => 'sofa-lounge',       'description' => 'Sofa, sectional, dan kursi lounge untuk ruang tamu'],
            ['name' => 'Kursi & Armchair',     'slug' => 'kursi-armchair',    'description' => 'Kursi makan, armchair, dan accent chair'],
            ['name' => 'Meja',                 'slug' => 'meja',              'description' => 'Coffee table, side table, dan console table'],
            ['name' => 'Ruang Makan',          'slug' => 'ruang-makan',       'description' => 'Meja makan dan set dining room'],
            ['name' => 'Kamar Tidur',          'slug' => 'kamar-tidur',       'description' => 'Bed frame, nakas, dan furniture kamar tidur'],
            ['name' => 'Outdoor & Teras',      'slug' => 'outdoor-teras',     'description' => 'Sun lounger, kursi teras, dan set outdoor'],
            ['name' => 'Lemari & Rak',         'slug' => 'lemari-rak',        'description' => 'Lemari, rak buku, dan kabinet penyimpanan'],
            ['name' => 'Dekorasi',             'slug' => 'dekorasi',          'description' => 'Vas, cermin, artwork, dan aksesori dekorasi'],
            ['name' => 'Pencahayaan',          'slug' => 'pencahayaan',       'description' => 'Lampu standing, lampu meja, dan pendant light'],
            ['name' => 'Karpet & Permadani',   'slug' => 'karpet-permadani',  'description' => 'Karpet area, permadani, dan runner'],
        ];

        $catMap = [];
        foreach ($categories as $i => $cat) {
            $record = ProductCategory::create(array_merge($cat, [
                'sort_order' => $i + 1,
                'is_active'  => true,
            ]));
            $catMap[$cat['slug']] = $record->id;
        }

        $products = [
            // ── Sofa & Lounge ──────────────────────────────
            [
                'category' => 'sofa-lounge',
                'name'     => 'Sofa Athens 3 Seater',
                'price'    => 12500000,
                'unit'     => 'set',
                'featured' => true,
                'desc'     => 'Sofa 3 dudukan dengan rangka kayu solid dan kain linen premium. Desain timeless Scandinavian dengan kaki metal matte hitam.',
            ],
            [
                'category' => 'sofa-lounge',
                'name'     => 'Lounge Chair Rattan Natural',
                'price'    => 5800000,
                'unit'     => 'pcs',
                'featured' => true,
                'desc'     => 'Lounge chair berbahan rotan alami hand-woven dengan bantal duduk linen cream. Ringan dan tahan lama.',
            ],
            [
                'category' => 'sofa-lounge',
                'name'     => 'Sectional Sofa L-Shape',
                'price'    => 22000000,
                'unit'     => 'set',
                'featured' => false,
                'desc'     => 'Sofa sudut L-shape berbahan beludru premium dengan chaise lounge. Rangka kayu solid, kaki walnut.',
            ],
            [
                'category' => 'sofa-lounge',
                'name'     => 'Ottoman Boucle Ivory',
                'price'    => 3200000,
                'unit'     => 'pcs',
                'featured' => false,
                'desc'     => 'Ottoman bulat berbahan boucle ivory premium. Multifungsi sebagai footrest, coffee table, maupun extra seat.',
            ],

            // ── Kursi & Armchair ───────────────────────────
            [
                'category' => 'kursi-armchair',
                'name'     => 'Armchair Woven Florence',
                'price'    => 4500000,
                'unit'     => 'pcs',
                'featured' => true,
                'desc'     => 'Armchair berstruktur besi powder coat dengan anyaman PE rattan sintetis. Elegan untuk indoor maupun semi-outdoor.',
            ],
            [
                'category' => 'kursi-armchair',
                'name'     => 'Dining Chair Teak Solid',
                'price'    => 2800000,
                'unit'     => 'pcs',
                'featured' => false,
                'desc'     => 'Kursi makan berbahan kayu jati solid grade A dengan finishing natural oil. Kokoh dan tahan hingga puluhan tahun.',
            ],
            [
                'category' => 'kursi-armchair',
                'name'     => 'Accent Chair Velvet Sage',
                'price'    => 3900000,
                'unit'     => 'pcs',
                'featured' => true,
                'desc'     => 'Accent chair bergaya mid-century modern dengan kain velvet warna sage green. Kaki kayu walnut solid.',
            ],
            [
                'category' => 'kursi-armchair',
                'name'     => 'Sun Lounger Adjustable',
                'price'    => 6500000,
                'unit'     => 'pcs',
                'featured' => false,
                'desc'     => 'Sun lounger rangka aluminium anti-karat dengan sandaran adjustable 5 posisi. Ideal untuk kolam renang dan teras.',
            ],

            // ── Meja ───────────────────────────────────────
            [
                'category' => 'meja',
                'name'     => 'Coffee Table Marble Nero',
                'price'    => 8900000,
                'unit'     => 'pcs',
                'featured' => true,
                'desc'     => 'Coffee table dengan top marmer nero marquina Italia dan kaki metal brushed gold. Statement piece yang mewah.',
            ],
            [
                'category' => 'meja',
                'name'     => 'Side Table Oak Minimalis',
                'price'    => 2400000,
                'unit'     => 'pcs',
                'featured' => false,
                'desc'     => 'Side table kayu oak solid dengan satu laci dan rak bawah. Finishing natural matte, cocok untuk berbagai gaya interior.',
            ],
            [
                'category' => 'meja',
                'name'     => 'Console Table Walnut',
                'price'    => 5600000,
                'unit'     => 'pcs',
                'featured' => false,
                'desc'     => 'Console table kayu walnut solid dengan kaki ramping elegan. Ideal sebagai entryway table atau media console.',
            ],

            // ── Ruang Makan ────────────────────────────────
            [
                'category' => 'ruang-makan',
                'name'     => 'Meja Makan Solid Teak 180cm',
                'price'    => 14500000,
                'unit'     => 'pcs',
                'featured' => true,
                'desc'     => 'Meja makan kayu jati solid ukuran 180x90cm. Top table natural edge dengan kaki kayu besar berbentuk trapesium.',
            ],
            [
                'category' => 'ruang-makan',
                'name'     => 'Dining Set Rattan 4 Kursi',
                'price'    => 18000000,
                'unit'     => 'set',
                'featured' => true,
                'desc'     => 'Set meja makan rotan alami 120cm bulat dengan 4 kursi. Nuansa tropical yang hangat dan elegan.',
            ],
            [
                'category' => 'ruang-makan',
                'name'     => 'Bar Stool Industrial',
                'price'    => 1900000,
                'unit'     => 'pcs',
                'featured' => false,
                'desc'     => 'Bar stool bergaya industrial dengan seat kayu reclaimed dan kaki besi adjustable. Cocok untuk kitchen island.',
            ],

            // ── Kamar Tidur ────────────────────────────────
            [
                'category' => 'kamar-tidur',
                'name'     => 'Bed Frame King Walnut',
                'price'    => 18500000,
                'unit'     => 'pcs',
                'featured' => true,
                'desc'     => 'Bed frame ukuran King (180x200cm) berbahan kayu walnut solid. Headboard upholstered fabric greige premium.',
            ],
            [
                'category' => 'kamar-tidur',
                'name'     => 'Nakas Scandinavian Oak',
                'price'    => 3200000,
                'unit'     => 'pcs',
                'featured' => false,
                'desc'     => 'Nakas kayu oak dengan satu laci dan kaki miring bergaya Scandinavian. Finishing natural oil tahan lama.',
            ],
            [
                'category' => 'kamar-tidur',
                'name'     => 'Dresser 6 Drawer Minimalis',
                'price'    => 8800000,
                'unit'     => 'pcs',
                'featured' => false,
                'desc'     => 'Dresser 6 laci dengan top marmer putih carrara. Rangka MDF premium lapis veneer oak. Handle brass.',
            ],

            // ── Outdoor & Teras ────────────────────────────
            [
                'category' => 'outdoor-teras',
                'name'     => 'Outdoor Sofa Set 5 Pcs',
                'price'    => 24000000,
                'unit'     => 'set',
                'featured' => true,
                'desc'     => 'Set sofa outdoor 5 pcs berbahan aluminium powder coat dengan bantal waterproof Sunbrella. Tahan cuaca dan UV.',
            ],
            [
                'category' => 'outdoor-teras',
                'name'     => 'Hanging Chair Macrame',
                'price'    => 4200000,
                'unit'     => 'pcs',
                'featured' => false,
                'desc'     => 'Hanging chair berbahan macrame cotton handmade. Rangka besi galvanis hitam. Kapasitas 120kg.',
            ],

            // ── Lemari & Rak ───────────────────────────────
            [
                'category' => 'lemari-rak',
                'name'     => 'Display Cabinet Oak 4 Pintu',
                'price'    => 12000000,
                'unit'     => 'pcs',
                'featured' => true,
                'desc'     => 'Display cabinet kayu oak 4 pintu kaca dengan lampu LED strip interior. Finishing natural, ukuran 200x40x220cm.',
            ],
            [
                'category' => 'lemari-rak',
                'name'     => 'Rak Buku Industrial 5 Tingkat',
                'price'    => 4800000,
                'unit'     => 'pcs',
                'featured' => false,
                'desc'     => 'Rak buku bergaya industrial dengan rak kayu reclaimed dan rangka besi hitam. Ukuran 180x30x200cm.',
            ],

            // ── Dekorasi ───────────────────────────────────
            [
                'category' => 'dekorasi',
                'name'     => 'Cermin Oval Frame Rotan',
                'price'    => 2800000,
                'unit'     => 'pcs',
                'featured' => true,
                'desc'     => 'Cermin oval berframe rotan alami hand-woven. Ukuran 60x90cm. Tampilan bohemian yang hangat dan artistik.',
            ],
            [
                'category' => 'dekorasi',
                'name'     => 'Vas Keramik Sculptural Set',
                'price'    => 1500000,
                'unit'     => 'set',
                'featured' => false,
                'desc'     => 'Set 3 vas keramik sculptural berbagai ukuran. Warna cream, sage, dan terracotta. Buatan tangan pengrajin lokal.',
            ],

            // ── Pencahayaan ────────────────────────────────
            [
                'category' => 'pencahayaan',
                'name'     => 'Lampu Arc Standing Gold',
                'price'    => 4600000,
                'unit'     => 'pcs',
                'featured' => true,
                'desc'     => 'Lampu standing arc dengan tiang metal matte gold dan shade marmer alabaster. Tinggi 190cm. Statement lighting.',
            ],
            [
                'category' => 'pencahayaan',
                'name'     => 'Pendant Light Rattan Cluster',
                'price'    => 3200000,
                'unit'     => 'pcs',
                'featured' => false,
                'desc'     => 'Pendant light cluster 3 bola rotan alami. Kabel tali braided, fitting E27. Cocok untuk ruang makan.',
            ],

            // ── Karpet & Permadani ─────────────────────────
            [
                'category' => 'karpet-permadani',
                'name'     => 'Karpet Wool Geometric 200x300',
                'price'    => 9500000,
                'unit'     => 'pcs',
                'featured' => true,
                'desc'     => 'Karpet wool premium bermotif geometric Maroko. Ukuran 200x300cm. Hand-knotted, ketebalan 12mm.',
            ],
            [
                'category' => 'karpet-permadani',
                'name'     => 'Runner Jute Natural 80x250',
                'price'    => 2200000,
                'unit'     => 'pcs',
                'featured' => false,
                'desc'     => 'Runner karpet berbahan jute alami 80x250cm. Tekstur natural yang hangat, ideal untuk lorong atau dapur.',
            ],
        ];

        foreach ($products as $i => $p) {
            $catId = $catMap[$p['category']] ?? null;
            if (! $catId) continue;

            Product::create([
                'product_category_id' => $catId,
                'name'                => $p['name'],
                'slug'                => Str::slug($p['name']),
                'short_description'   => $p['desc'],
                'description'         => '<p>' . $p['desc'] . '</p><p>Untuk informasi lebih lanjut mengenai spesifikasi, ketersediaan stok, dan penawaran harga terbaik, silakan hubungi tim kami melalui WhatsApp.</p>',
                'price'               => $p['price'],
                'price_unit'          => $p['unit'],
                'is_featured'         => $p['featured'],
                'is_active'           => true,
                'sort_order'          => $i + 1,
            ]);
        }
    }
}
