# 🎸 Amapiano Cafe & Resto - Online Reservation System

Amapiano Cafe Reservation System adalah aplikasi pemesanan meja restoran berbasis web interaktif. Dibangun menggunakan **Laravel 13**, **Tailwind CSS v4**, dan **Vanilla JavaScript (AJAX Fetch API)**, sistem ini dirancang dengan estetika premium bergaya *rustic-modern* dan dilengkapi sistem manajemen operasional yang canggih untuk memberikan pengalaman terbaik kepada pelanggan dan staf restoran.

---

## 🌟 Fitur Utama

### 1. Sisi Pelanggan (Customer Facing Page)
* **Interactive Seating Floor Plan**: Denah meja interaktif 2D yang responsif secara *real-time* berbasis AJAX. Meja yang sudah dipesan pada waktu terpilih otomatis terkunci/dinonaktifkan (*disabled*).
* **4-Step Booking Wizard**:
  * **Langkah 1**: Memilih tanggal & waktu kedatangan (dengan batas waktu minimal reservasi H-1).
  * **Langkah 2**: Memilih area kafe yang unik (*Hoof Barn*, *Covent Garden*, atau *VIP Lounge*).
  * **Langkah 3**: Memilih nomor meja secara langsung melalui tata letak visual denah meja.
  * **Langkah 4**: Mengisi data diri pelanggan dan ringkasan persetujuan aturan reservasi.
* **Dynamic Ticket & QR Code**: Tiket sukses reservasi dengan kode unik (`AMP-XXXX`) yang dilengkapi QR Code dinamis langsung di browser untuk kemudahan proses *check-in*.
* **Status Operasional Cafe**: Mengunci formulir booking dan memunculkan banner pemberitahuan eksklusif jika sistem reservasi ditutup oleh Admin.

### 2. Dasbor Staff (Front Desk)
* **Pencarian Pintar & Validasi**: Mencari dan memvalidasi tiket reservasi secara instan. Fitur ini secara otomatis menghapus simbol `#` jika staff menginputkannya (misal: `#AMP-8291` -> `AMP-8291`).
* **Sistem Check-In**: Konfirmasi kehadiran pelanggan dengan satu klik yang mencatat waktu check-in (`checked_in_at`).
* **Peringatan Keterlambatan**: Deteksi otomatis keterlambatan (>15 menit dari jadwal booking) dengan label peringatan berwarna kuning.
* **Daftar Reservasi Masa Depan**: Menampilkan semua reservasi mendatang (mulai hari ini dan seterusnya) diurutkan berdasarkan jadwal terdekat untuk memudahkan perencanaan tempat.

### 3. Dasbor Super Admin
* **Dashboard Overview**: Ringkasan statistik bulanan, okupansi meja hari ini, estimasi pendapatan harian, dan grafik tren mingguan berbasis Chart.js.
* **Direct Reservation Control**: Tombol tindakan cepat untuk mengubah status reservasi pelanggan menjadi *Checked-In* atau *Cancelled* langsung dari panel admin.
* **Manajemen User**: Menambah dan menghapus akun Staff/Admin (dilengkapi pengaman pencegah penghapusan akun sendiri).
* **Promo & Event**: Menambahkan dan menghapus kartu promo diskon atau live music event yang disimpan di dalam cache aplikasi.
* **Operational Toggle**: Saklar operasional (*toggle switch*) sekali klik berbasis AJAX untuk membuka/menutup reservasi online secara *real-time* dengan menyimpan status ke Cache (`store_open`).

---

## 📐 Tata Letak & Kapasitas Meja

Aplikasi ini mendukung **25 meja** yang terbagi ke dalam 3 area utama dengan kapasitas masing-masing:

| Area | ID Meja | Kapasitas Meja | Total Meja |
|---|---|---|---|
| **Hoof Barn** (Main Hall) | `hb-1` s.d `hb-8` | `hb-1`: 2 orang<br>`hb-2` & `hb-3`: 4 orang<br>`hb-4`: 6 orang<br>`hb-5`: 2 orang<br>`hb-6` & `hb-7`: 4 orang<br>`hb-8`: 6 orang | 8 Meja |
| **Covent Garden** (Terrace) | `cg-1` s.d `cg-10` | `cg-1`: 2 orang<br>`cg-2` & `cg-3`: 4 orang<br>`cg-4`: 6 orang<br>`cg-5`: 2 orang<br>`cg-6` s.d `cg-9`: 4 orang<br>`cg-10`: 8 orang | 10 Meja |
| **Limburg** (VIP Lounge) | `lb-1` s.d `lb-7` | `lb-1`: 2 orang<br>`lb-2` & `lb-3`: 4 orang<br>`lb-4`: 2 orang<br>`lb-5`: 6 orang<br>`lb-6` & `lb-7`: 4 orang | 7 Meja |

---

## 🛠️ Spesifikasi Teknologi & Dependensi

* **Backend**: PHP 8.3 & Laravel Framework 13
* **Frontend**: HTML5, Vanilla JavaScript (AJAX Fetch API), Tailwind CSS v4
* **Grafik & Ikon**: Chart.js & FontAwesome v6
* **Database**: MySQL / MariaDB
* **Testing & Formatting**: Pest PHP v4, PHPUnit v12, Laravel Pint
* **Ecosystem Tools**: Laravel Boost v2, Laravel Pail v1, Laravel Pao v1

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

### 1. Klon Repositori
```bash
git clone https://github.com/bamsgrtt/amapiano-cafe.git
cd amapiano-cafe
```

### 2. Pasang Dependensi Composer & NPM
```bash
composer install
npm install
```

### 3. Konfigurasi Environment Berkas `.env`
Salin berkas konfigurasi default dan sesuaikan pengaturan database Anda:
```bash
copy .env.example .env
```
Sesuaikan parameter database di dalam `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=amapiano_cafe
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup Database & Jalankan Migrasi + Seeder
Jalankan migrasi database beserta pengisian data pengujian awal (seeder):
```bash
php artisan migrate:fresh --seed
```

### 5. Kompilasi Aset CSS/JS Vite
Jalankan server kompilasi Vite:
```bash
npm run dev
```

### 6. Jalankan Aplikasi
Mulai local development server Laravel:
```bash
php artisan serve
```
Akses aplikasi melalui browser di [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## 🔑 Akun Kredensial Default (Uji Coba)

Gunakan akun-akun berikut untuk masuk ke dasbor manajemen kafe setelah menjalankan seeder database:

| Peran (Role) | Email | Sandi (Password) | URL Akses Halaman |
|---|---|---|---|
| **Super Admin** | `admin@amapiano.com` | `password` | `/admin/dashboard` |
| **Front Desk Staff** | `staff@amapiano.com` | `password` | `/staff/dashboard` |
| **Customer** | `test@example.com` | `password` | `/` |

---

## 🧪 Pengujian Otomatis (Automated Testing)

Proyek ini telah dilengkapi dengan pengujian unit dan fitur komprehensif menggunakan **Pest PHP** untuk memvalidasi:
- Alur login & pembatasan hak akses halaman berdasarkan peran (*Role-based Access Control*).
- Sistem validasi check-in reservasi dan manipulasi simbol pencarian `#`.
- Keamanan pendaftaran akun staff & proteksi penghapusan akun sendiri.
- Penolakan pembuatan reservasi baru jika status toko ditutup.

Jalankan perintah berikut untuk mengeksekusi semua tes:
```bash
php artisan test --compact
```

---

## 🎨 Pemformatan Kode (Clean Code)

Aplikasi ini menggunakan **Laravel Pint** untuk menjaga gaya penulisan kode PHP agar tetap bersih dan terstandardisasi. Format seluruh file PHP yang berubah menggunakan perintah:
```bash
vendor/bin/pint --dirty --format agent
```
