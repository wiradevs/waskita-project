# Dokumentasi Project Waskita
> Website company profile + katalog produk furniture premium  
> Dibuat: 13 Juni 2026 · Stack: Laravel 12 + Filament v4 + Tailwind CSS v4

---

## Daftar Isi
1. [Informasi Akses](#1-informasi-akses)
2. [Struktur Project](#2-struktur-project)
3. [Database](#3-database)
4. [Fitur Admin Panel](#4-fitur-admin-panel)
5. [Halaman Frontend](#5-halaman-frontend)
6. [Desain & Tema](#6-desain--tema)
7. [Animasi Hero](#7-animasi-hero)
8. [Perintah Berguna](#8-perintah-berguna)
9. [Cara Mengelola Konten](#9-cara-mengelola-konten)
10. [Troubleshooting](#10-troubleshooting)
11. [Stack Teknologi](#11-stack-teknologi)

---

## 1. Informasi Akses

### Menjalankan Server
```bash
# Wajib: pastikan XAMPP (Apache + MySQL) sudah aktif
cd c:\waskita-project
php artisan serve
```
Server berjalan di: **http://localhost:8000**

### URL Penting
| Tujuan | URL |
|--------|-----|
| Website utama | http://localhost:8000 |
| Admin panel | http://localhost:8000/admin |
| phpMyAdmin | http://localhost/phpmyadmin |

### Akun Admin Filament
| Field | Value |
|-------|-------|
| Email | `admin@waskita.com` |
| Nama | Waskita Admin |
| Password | *(dibuat saat setup)* |

**Lupa password? Reset via terminal:**
```bash
cd c:\waskita-project
php artisan tinker --execute="App\Models\User::first()->update(['password' => bcrypt('admin123')]);"
```
Login dengan password baru: `admin123`

---

## 2. Struktur Project

```
c:\waskita-project\
│
├── app/
│   ├── Filament/
│   │   ├── Pages/
│   │   │   └── ManageSettings.php        ← Pengaturan perusahaan & hero
│   │   └── Resources/
│   │       ├── ProductCategoryResource.php ← CRUD kategori
│   │       ├── ProductResource.php         ← CRUD produk + galeri foto
│   │       └── ContactMessageResource.php  ← Kotak masuk pesan
│   ├── Http/Controllers/
│   │   ├── HomeController.php            ← Beranda
│   │   ├── CatalogController.php         ← Katalog & detail produk
│   │   └── ContactController.php         ← Form kontak
│   ├── Models/
│   │   ├── Product.php
│   │   ├── ProductCategory.php
│   │   ├── ProductImage.php
│   │   ├── CompanySetting.php
│   │   └── ContactMessage.php
│   └── Providers/
│       ├── ViewServiceProvider.php       ← Share $settings ke semua view
│       └── Filament/AdminPanelProvider.php
│
├── database/
│   ├── migrations/                       ← Skema tabel
│   └── seeders/
│       ├── CompanySettingSeeder.php      ← Data awal pengaturan
│       └── ProductSeeder.php             ← 6 kategori + 12 produk contoh
│
├── resources/
│   ├── css/app.css                       ← Tema warna + animasi CSS
│   ├── js/app.js                         ← Animasi JS (parallax, counter, video)
│   └── views/
│       ├── layouts/app.blade.php         ← Layout utama (navbar + footer)
│       ├── home.blade.php                ← Beranda + hero video
│       ├── about.blade.php               ← Tentang kami
│       ├── contact.blade.php             ← Kontak
│       └── catalog/
│           ├── index.blade.php           ← Daftar produk
│           └── show.blade.php            ← Detail produk
│
├── routes/web.php                        ← Semua route frontend
├── .env                                  ← Konfigurasi environment
├── vite.config.js                        ← Build CSS/JS
└── DOKUMENTASI.md                        ← File ini
```

---

## 3. Database

### Konfigurasi (.env)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=waskita_db
DB_USERNAME=root
DB_PASSWORD=           ← kosong (XAMPP default)
```

### Tabel-tabel
| Tabel | Keterangan |
|-------|------------|
| `users` | Akun admin |
| `product_categories` | Kategori produk (nama, slug, gambar, urutan) |
| `products` | Produk (nama, slug, deskripsi, harga, thumbnail, featured) |
| `product_images` | Galeri foto produk (bisa banyak per produk) |
| `company_settings` | Pengaturan situs (key-value store) |
| `contact_messages` | Pesan masuk dari form kontak |
| `sessions` | Sesi login |
| `cache` | Cache Laravel |
| `jobs` | Queue jobs |

### Data Awal (Seeder)
- **6 kategori produk** contoh
- **12 produk** contoh
- **Pengaturan perusahaan** default (nama, alamat, WA, dll.)

---

## 4. Fitur Admin Panel

URL: **http://localhost:8000/admin**

### Menu Admin

#### Katalog → Kategori Produk
- Tambah / edit / hapus kategori
- Upload gambar kategori
- Atur urutan tampilan
- Aktif/nonaktif kategori

#### Katalog → Produk
- Tambah / edit / hapus produk
- Upload thumbnail utama
- Upload galeri foto tambahan (multiple)
- Set harga (opsional — bisa dikosongkan untuk "hubungi kami")
- Tandai sebagai Produk Unggulan (tampil di beranda)
- Aktif/nonaktif produk
- Filter & pencarian di tabel

#### Pesan → Pesan Masuk
- Lihat semua pesan dari form kontak
- Tandai sudah dibaca
- Badge jumlah pesan belum dibaca di menu
- Tidak bisa membuat pesan baru dari admin (hanya baca)

#### Pengaturan → Pengaturan Perusahaan

**Tab Identitas Perusahaan:**
| Field | Keterangan |
|-------|------------|
| Nama Perusahaan | Muncul di navbar, footer, tab browser |
| Tagline / Slogan | Muncul di hero (baris italic emas) |
| Tentang Perusahaan | Teks halaman About |
| Alamat | Muncul di footer & halaman kontak |
| Nomor Telepon | Informasi kontak |
| Email | Informasi kontak |
| WhatsApp | Nomor WA untuk tombol "Pesan via WhatsApp" (format: +628xxx) |

**Tab Sosial Media:**
| Field | Keterangan |
|-------|------------|
| Instagram URL | Link ke profil Instagram |
| Facebook URL | Link ke profil Facebook |

**Tab Hero Section:**
| Field | Keterangan |
|-------|------------|
| Judul Hero | Teks baris pertama di hero (putih besar) |
| Subtitle Hero | Teks deskripsi di bawah judul |
| **Video Hero (MP4)** | Upload video background — diutamakan, max 100 MB |
| Gambar Hero | Fallback jika tidak ada video |

**Tab Logo:**
| Field | Keterangan |
|-------|------------|
| Logo Perusahaan | Muncul di navbar (menggantikan teks nama) |

---

## 5. Halaman Frontend

### Route & URL
| Route Name | URL | Keterangan |
|------------|-----|------------|
| `home` | `/` | Beranda |
| `about` | `/tentang` | Tentang kami |
| `catalog.index` | `/katalog` | Semua produk + filter |
| `catalog.show` | `/katalog/{slug}` | Detail produk |
| `contact.index` | `/kontak` | Form kontak |
| `contact.store` | `POST /kontak` | Kirim pesan |

### Fitur Setiap Halaman

#### Beranda (`/`)
- Hero full-screen dengan video/gambar/CSS ambient background
- Grid kategori produk (6 kategori)
- 6 produk unggulan (is_featured = true)
- Brand quote section
- Preview About dengan CTA WhatsApp
- CTA banner emas

#### Katalog (`/katalog`)
- Filter by kategori (sidebar)
- Pencarian by nama produk
- Grid 3 kolom, 12 produk per halaman
- Hover overlay dengan tombol "Pesan Sekarang" via WA
- Pagination

#### Detail Produk (`/katalog/{slug}`)
- Galeri foto dengan thumbnail strip + transisi fade
- Panel info: nama, harga, deskripsi, kategori, status
- Tombol "Pesan via WhatsApp" dengan pesan otomatis terformat
- Produk terkait (kategori sama, 4 produk)

#### Tentang (`/tentang`)
- Header dengan nama & tagline
- Teks about perusahaan
- 4 kolom nilai perusahaan (Kualitas, Desain, Keahlian, Kepercayaan)
- Kotak informasi kontak (alamat, telepon, email, WA)

#### Kontak (`/kontak`)
- Sidebar: tombol WA primer + info kontak
- Form: Nama, Email, Telepon, Subjek, Pesan
- Validasi field wajib
- Pesan tersimpan ke database (lihat di admin)

---

## 6. Desain & Tema

### Palet Warna
| Nama | Hex | Digunakan untuk |
|------|-----|-----------------|
| `cream` | `#FAF8F5` | Background utama |
| `cream-dark` | `#EDE8DF` | Background section sekunder |
| `charcoal` | `#1C1917` | Teks utama, button gelap |
| `charcoal-mid` | `#44403C` | Teks sekunder |
| `warm` | `#78716C` | Teks deskripsi |
| `gold` | `#B8965A` | Aksen utama, CTA |
| `gold-light` | `#D4AF7A` | Aksen italic hero (mode gelap) |
| `border` | `#E5DDD5` | Garis pemisah |

### Font
| Font | Digunakan untuk |
|------|-----------------|
| **Playfair Display** | Heading, judul produk, angka stats |
| **Inter** | Body text, label, button, navigation |

### Filosofi Desain
- **Contemporary Luxury** — elegan, bersih, timeless
- Huruf kapital tracking lebar untuk label/tag
- Garis dekoratif emas (deco-rule)
- Rasio gambar potret (3:4) untuk produk → feel majalah fashion
- Tidak ada border-radius (sudut persegi) → kesan premium & tegas

---

## 7. Animasi Hero

### Urutan Animasi (page load)
| Waktu | Elemen | Animasi |
|-------|--------|---------|
| 0.15s | Curtain (overlay gelap) | Menyapu naik (scaleY 1→0) |
| 0.7s | Right panel / video | Wipe dari kiri ke kanan |
| 0.9s | Garis emas panjang | Draw dari kiri (width 0→3rem) |
| 1.0s | Headline baris 1 | Slide up dari clip mask |
| 1.18s | Headline baris 2 (italic emas) | Slide up dari clip mask |
| 1.2s | Label "Premium Collection" | Fade + letter-spacing menyempit |
| 1.4s | Garis separator emas | Scale dari kiri (scaleX 0→1) |
| 1.52s | Subtitle teks | Fade + slide up |
| 1.68s | Tombol CTA | Fade + slide up |
| 1.82s | Stats + scroll indicator | Fade + slide up |
| 2.1s | Counter angka stats | Count up (0 → 500+, 10+, 1K+) |

### Animasi Interaktif
| Trigger | Elemen | Efek |
|---------|--------|------|
| Mouse move di hero | 3 elemen parallax | Drift halus dengan lerp 5.5% |
| Hover tombol primer | Arrow icon | Geser kanan 5px |
| Scroll halaman | Elemen `[data-animate]` | Fade + slide up via IntersectionObserver |
| Hover product card | Gambar + overlay WA | Zoom gambar + overlay muncul |
| Klik thumbnail galeri | Gambar utama | Fade + scale transition |

### Kontrol Video Hero
- **Tombol ⏸/▶** — pojok kanan bawah hero, glassmorphism style
- **Progress bar emas** — garis tipis di paling bawah, update real-time

---

## 8. Perintah Berguna

### Sehari-hari
```bash
# Jalankan server development
php artisan serve

# Build CSS/JS (setelah edit file view/css/js)
npm run build

# Mode development (auto rebuild saat edit)
npm run dev
```

### Database
```bash
# Jalankan semua migration
php artisan migrate

# Reset database + jalankan ulang seeder
php artisan migrate:fresh --seed

# Hanya jalankan seeder tanpa reset
php artisan db:seed
```

### Storage
```bash
# Buat symlink agar file upload bisa diakses publik (wajib 1x)
php artisan storage:link
```

### Cache
```bash
# Bersihkan semua cache (jika ada perubahan config/setting tidak muncul)
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Informasi
```bash
# Lihat semua route
php artisan route:list

# Lihat semua perintah artisan
php artisan list
```

### Mengelola User Admin
```bash
# Lihat user admin
php artisan tinker --execute="print_r(App\Models\User::first()->toArray());"

# Ganti password admin
php artisan tinker --execute="App\Models\User::first()->update(['password' => bcrypt('passwordbaru')]);"

# Tambah admin baru
php artisan tinker --execute="App\Models\User::create(['name'=>'Admin','email'=>'email@domain.com','password'=>bcrypt('password')]);"
```

---

## 9. Cara Mengelola Konten

### Menambah Produk Baru
1. Login ke `http://localhost:8000/admin`
2. Klik **Katalog → Produk → Tambah Produk**
3. Isi: Nama, Kategori, Harga (opsional), Deskripsi Singkat, Deskripsi Lengkap
4. Upload **Thumbnail** (foto utama)
5. Tambah foto di bagian **Galeri** (bisa banyak)
6. Centang **Produk Unggulan** agar muncul di beranda
7. Pastikan **Status Aktif** dicentang
8. Klik **Simpan**

### Mengganti Video Hero
1. Login admin → **Pengaturan → Hero Section**
2. Upload file MP4 di field **Video Hero**
3. Ukuran max: 100 MB
4. Klik **Simpan Pengaturan**
5. Refresh halaman utama

### Mengganti Nomor WhatsApp
1. Login admin → **Pengaturan → Identitas Perusahaan**
2. Edit field **WhatsApp** — format: `+628xxxxxxxxxx`
3. Klik **Simpan Pengaturan**
4. Semua tombol "Pesan via WA" otomatis menggunakan nomor baru

### Melihat Pesan dari Pengunjung
1. Login admin → **Pesan → Pesan Masuk**
2. Klik baris pesan untuk melihat detail
3. Klik **Tandai Dibaca** untuk mengubah status

---

## 10. Troubleshooting

### Halaman putih / error 500
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
# Cek juga: php artisan serve sudah berjalan?
# Cek: XAMPP MySQL sudah aktif?
```

### Gambar tidak muncul setelah upload
```bash
php artisan storage:link
# Pastikan folder storage/app/public/settings ada izin tulis
```

### Perubahan CSS/JS tidak terlihat
```bash
npm run build
# Atau refresh browser dengan Ctrl+Shift+R (hard refresh)
```

### Database error "Unknown database"
```bash
# Buat database dulu via phpMyAdmin atau:
# Buka phpMyAdmin → New → waskita_db → Create
php artisan migrate
php artisan db:seed
```

### Filament admin tidak bisa diakses
```bash
php artisan optimize:clear
php artisan filament:optimize
```

### Video hero tidak autoplay
- Browser memblokir autoplay dengan suara → video sudah disetel `muted` jadi seharusnya jalan
- Pastikan format file adalah **MP4 (H.264)** — format paling kompatibel
- Ukuran video idealnya < 20 MB untuk loading cepat (compress dulu dengan HandBrake)

---

## 11. Stack Teknologi

| Layer | Teknologi | Versi |
|-------|-----------|-------|
| Backend | Laravel | 12.x |
| Admin Panel | Filament | 4.x |
| CSS Framework | Tailwind CSS | 4.x |
| Build Tool | Vite | 7.x |
| Database | MySQL (XAMPP) | 8.x |
| PHP | PHP | 8.2.12 |
| Font | Google Fonts | — |
| Icons | Heroicons | — |

### Catatan Penting Filament v4
Filament v4 **berbeda signifikan** dari v3. Jika menambah fitur admin baru, perhatikan:

```php
// BENAR di v4:
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;

public static function form(Schema $schema): Schema { ... }
public static function getNavigationIcon(): ?string { return 'heroicon-o-...'; }
public static function getNavigationGroup(): ?string { return 'Nama Grup'; }

// SALAH di v4 (ini sintaks v3):
use Filament\Forms\Form;
use Filament\Forms\Components\Section; // ← salah namespace
use Filament\Tables\Actions\EditAction; // ← salah namespace
protected static ?string $navigationIcon = '...'; // ← type error di v4
protected static ?string $navigationGroup = '...'; // ← type error di v4
```

---

*Dokumentasi ini dibuat otomatis untuk project Waskita Furniture.*  
*Simpan file ini di: `c:\waskita-project\DOKUMENTASI.md`*
