# Dokumen Akses & Panduan Admin
## Project: Waskita Company Profile Website

> **RAHASIA** — Jangan di-share secara publik atau di-commit ke GitHub.

---

## 1. Akses Admin Panel

| Info       | Detail                           |
|------------|----------------------------------|
| URL Admin  | `http://localhost:8000/admin`    |
| Email      | `admin@waskita.com`              |
| Password   | `admin123`                       |

### Lupa password admin?
Jalankan perintah ini di terminal project:
```bash
php artisan make:filament-user
```
Masukkan nama, email `admin@waskita.com`, dan password baru.

---

## 2. Akses Database

| Info          | Detail          |
|---------------|-----------------|
| Driver        | MySQL           |
| Host          | 127.0.0.1       |
| Port          | 3306            |
| Nama Database | `waskita_db`    |
| Username      | `root`          |
| Password      | _(kosong)_      |

Akses via phpMyAdmin atau MySQL Workbench menggunakan data di atas.

---

## 3. Data Perusahaan (Company Settings)

Semua data ini dapat diubah di Admin Panel → **Company Settings**.

| Field         | Nilai Awal                                      |
|---------------|-------------------------------------------------|
| Nama          | PT Waskita Karya                                |
| Alamat        | Jl. Sudirman No. 123, Jakarta Pusat 10220       |
| Telepon       | (021) 555-1234                                  |
| Email         | info@waskitakarya.com                           |
| WhatsApp      | +6281234567890                                  |

---

## 4. Panduan Penggunaan Admin Panel

### A. Login
1. Buka `http://localhost:8000/admin`
2. Masukkan email dan password admin
3. Klik **Sign In**

### B. Company Settings (Pengaturan Perusahaan)
**Admin Panel → Company Settings**

Yang bisa diubah:
- Nama perusahaan, tagline, deskripsi
- Alamat, telepon, email, WhatsApp
- Logo perusahaan
- Hero: judul, subtitle, gambar latar, video latar
- Link Instagram & Facebook

### C. Kelola Kategori Produk
**Admin Panel → Product Categories**

- **Tambah kategori**: Klik tombol **New**
- **Isi**: Nama, slug (otomatis), deskripsi, gambar, urutan tampil
- **Aktif/nonaktif**: Toggle `is_active`

Kategori yang tersedia saat ini:
1. Sofa & Lounge
2. Kursi & Armchair
3. Meja
4. Ruang Makan
5. Kamar Tidur
6. Outdoor & Teras
7. Lemari & Rak
8. Dekorasi
9. Pencahayaan
10. Karpet & Permadani

### D. Kelola Produk
**Admin Panel → Products**

- **Tambah produk**: Klik tombol **New**
- **Field wajib**: Nama, kategori, harga
- **Gambar**: Upload foto produk (bisa lebih dari satu)
- **Featured**: Centang supaya muncul di halaman utama
- **Aktif**: Harus dicentang supaya muncul di website

### E. Upload Hero Video
**Admin Panel → Company Settings → Hero Video**

1. Klik field **Hero Video**
2. Upload file `.mp4` (rekomendasikan resolusi 1920×1080)
3. Klik **Save**
4. Video akan autoplay, muted, loop di halaman utama

---

## 5. Menjalankan Server Lokal

```bash
# Masuk ke folder project
cd c:\waskita-project

# Jalankan server Laravel
php artisan serve

# Buka di browser
http://localhost:8000
```

Untuk development (dengan hot reload):
```bash
# Terminal 1 — Laravel server
php artisan serve

# Terminal 2 — Vite dev server
npm run dev
```

---

## 6. Perintah Penting

| Perintah                        | Fungsi                                     |
|---------------------------------|--------------------------------------------|
| `php artisan serve`             | Jalankan server lokal                      |
| `php artisan migrate`           | Jalankan migrasi database                  |
| `php artisan db:seed`           | Isi data awal (kategori + produk)          |
| `php artisan storage:link`      | Link folder storage ke public              |
| `npm run build`                 | Build aset CSS & JS untuk production       |
| `php artisan make:filament-user`| Buat / reset akun admin                   |
| `php artisan optimize:clear`    | Bersihkan cache aplikasi                   |

---

## 7. Struktur Folder Penting

```
waskita-project/
├── app/
│   ├── Filament/Resources/    ← Panel admin (CRUD)
│   └── Models/                ← Model database
├── database/
│   └── seeders/               ← Data awal produk & kategori
├── resources/
│   ├── views/                 ← Tampilan halaman website
│   └── js/app.js              ← Animasi & interaksi
├── storage/app/public/        ← File upload (gambar, video)
├── .env                       ← Konfigurasi database & app
└── public/                    ← Root web server (production)
```

---

## 8. Backup

### Backup Database
```bash
mysqldump -u root waskita_db > backup_waskita_TANGGAL.sql
```

### Restore Database
```bash
mysql -u root waskita_db < backup_waskita_TANGGAL.sql
```

### File Upload (Gambar & Video)
Folder yang perlu di-backup: `storage/app/public/`

---

*Dokumen dibuat: Juni 2026*
