# Aplikasi Listrik Pascabayar

Sistem manajemen listrik pascabayar berbasis web menggunakan Laravel 12. Aplikasi ini memungkinkan PLN untuk mengelola data pelanggan, mencatat penggunaan listrik bulanan, generate tagihan otomatis, dan memproses pembayaran.

## 🚀 Fitur Utama

### 1. **Multi-Level User Access**
- **Admin**: Akses penuh ke semua fitur sistem
- **Operator**: Mengelola data pelanggan, penggunaan, tagihan, dan pembayaran
- **Pelanggan**: Melihat informasi akun, penggunaan, dan tagihan sendiri

### 2. **Manajemen Pelanggan**
- ✅ CRUD data pelanggan
- ✅ Auto-generate ID pelanggan (PEL001, PEL002, ...)
- ✅ Manajemen daya listrik (450VA, 900VA, 1300VA, 2200VA, 3500VA)
- ✅ Status pelanggan (Aktif, Nonaktif, Suspend)
- ✅ Pembuatan akun user otomatis untuk pelanggan

### 3. **Pencatatan Penggunaan Listrik**
- ✅ Input meter awal dan meter akhir per bulan
- ✅ Auto-calculate total kWh
- ✅ Ambil meter akhir bulan lalu sebagai meter awal
- ✅ Validasi periode (tidak boleh duplikat)

### 4. **Sistem Tagihan Otomatis**
- ✅ Generate tagihan otomatis via database trigger
- ✅ Perhitungan berdasarkan tarif per kWh
- ✅ Sistem denda keterlambatan 2% per bulan
- ✅ Jatuh tempo 20 hari dari tanggal tagihan
- ✅ Status: Belum Bayar, Sudah Bayar, Terlambat

### 5. **Pembayaran**
- ✅ Multi metode pembayaran (Tunai, Transfer, EDC, QRIS)
- ✅ Update status tagihan otomatis setelah bayar
- ✅ Cetak struk pembayaran
- ✅ Validasi jumlah pembayaran

### 6. **Dashboard & Laporan**
- ✅ Dashboard dengan statistik real-time
- ✅ Grafik pendapatan bulanan
- ✅ Laporan penggunaan listrik
- ✅ Laporan pembayaran
- ✅ Laporan tunggakan
- ✅ Laporan pelanggan per daya

## 📋 Requirements

- PHP >= 8.2
- MySQL >= 8.0
- Composer
- Laravel 12
- Node.js & NPM (optional, untuk asset compilation)

## 🔧 Instalasi

### 1. Clone Repository
```bash
cd /home/hosea/Documents/project/aplikasi-listrik
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Environment
File `.env` sudah dikonfigurasi:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aplikasi_listrik_pascabayar
DB_USERNAME=root
DB_PASSWORD=root
```

### 4. Import Database
Database sudah ter-import. Jika perlu re-import:
```bash
mysql -u root -proot < database_schema.sql
```

Atau via HeidiSQL/phpMyAdmin, import file: `database_schema.sql`

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Run Application
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Akses aplikasi di: **http://localhost:8000**

## 👤 Demo Credentials

### Admin
- **Username**: `admin`
- **Password**: `admin123`

### Operator
- **Username**: `operator1`
- **Password**: `operator123`

### Pelanggan
- **Username**: `PEL001`
- **Password**: `password123`

## 📊 Database Schema

### Tabel Utama:
1. **level** - Role/level user (Admin, Operator, Pelanggan)
2. **user** - Data user untuk login
3. **tarif** - Tarif listrik per kWh
4. **daya_listrik** - Daya listrik dalam VA (450, 900, 1300, 2200, 3500)
5. **pelanggan** - Data pelanggan PLN
6. **penggunaan** - Pencatatan penggunaan listrik bulanan
7. **tagihan** - Tagihan yang di-generate otomatis
8. **pembayaran** - Data pembayaran tagihan

### Fitur Database:
- ✅ **Trigger**: Auto-generate tagihan saat input penggunaan
- ✅ **View**: `vw_informasi_penggunaan` untuk reporting
- ✅ **Stored Procedure**: `sp_pelanggan_900watt()` - List pelanggan 900VA
- ✅ **Function**: `fn_total_penggunaan_bulan()` - Get total kWh per periode

## 🏗️ Struktur Aplikasi

```
aplikasi-listrik/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Login/Logout
│   │   │   ├── DashboardController.php     # Dashboard
│   │   │   ├── PelangganController.php     # CRUD Pelanggan
│   │   │   ├── PenggunaanController.php    # Input Penggunaan
│   │   │   ├── TagihanController.php       # Kelola Tagihan
│   │   │   ├── PembayaranController.php    # Proses Pembayaran
│   │   │   └── LaporanController.php       # Reports
│   │   └── Middleware/
│   │       └── CheckRole.php               # Role-based access
│   └── Models/
│       ├── Level.php
│       ├── User.php
│       ├── Tarif.php
│       ├── DayaListrik.php
│       ├── Pelanggan.php
│       ├── Penggunaan.php
│       ├── Tagihan.php
│       └── Pembayaran.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php               # Master layout
│       ├── auth/
│       │   └── login.blade.php
│       ├── dashboard/
│       ├── pelanggan/
│       ├── penggunaan/
│       ├── tagihan/
│       ├── pembayaran/
│       └── laporan/
├── routes/
│   └── web.php                             # All routes
├── database/
│   └── schema.sql                          # Database schema
└── database_schema.sql                     # Complete DB with data
```

## 🎯 Workflow Aplikasi

### 1. **Tambah Pelanggan Baru**
1. Login sebagai Admin/Operator
2. Menu Pelanggan → Tambah Pelanggan
3. Isi data lengkap pelanggan
4. Pilih daya listrik
5. Optional: centang "Buat akun user" untuk akses pelanggan
6. Simpan → ID auto-generated (PEL001, PEL002, ...)

### 2. **Input Penggunaan Bulanan**
1. Menu Penggunaan → Input Penggunaan
2. Pilih pelanggan
3. Pilih bulan & tahun
4. Input meter awal (atau ambil dari bulan lalu)
5. Input meter akhir
6. Total kWh dihitung otomatis
7. Simpan → **Tagihan auto-generated via trigger**

### 3. **Proses Pembayaran**
1. Menu Pembayaran → Input Pembayaran
2. Pilih tagihan yang akan dibayar
3. Sistem auto-fill jumlah yang harus dibayar
4. Pilih metode pembayaran
5. Simpan → Status tagihan berubah "Sudah Bayar"

### 4. **Lihat Laporan**
- **Laporan Penggunaan**: Filter per bulan/tahun
- **Laporan Pembayaran**: Filter per tanggal & metode
- **Laporan Tunggakan**: List semua tagihan belum bayar
- **Pelanggan per Daya**: Statistik jumlah pelanggan per kategori daya

## 🔐 Security Features

- ✅ Authentication menggunakan Laravel Auth
- ✅ Password hashing dengan MD5 (sesuai database legacy)
- ✅ CSRF Protection
- ✅ Role-based middleware
- ✅ Input validation
- ✅ SQL Injection prevention via Eloquent ORM

## 📱 Responsive Design

- ✅ Bootstrap 5
- ✅ Font Awesome icons
- ✅ DataTables untuk tabel interaktif
- ✅ Mobile-friendly layout

## 🧪 Testing

```bash
# Test koneksi database
php artisan tinker
>>> \DB::connection()->getPdo();

# Test query
>>> App\Models\Pelanggan::count();
>>> App\Models\User::where('username', 'admin')->first();
```

## 📈 Performa

- Indexed columns untuk query optimization
- Eloquent lazy loading prevention
- Pagination untuk data besar
- Database transactions untuk data integrity

## 🐛 Troubleshooting

### Error: SQLSTATE[HY000] [2002] Connection refused
```bash
# Pastikan MySQL running
sudo systemctl start mysql
# atau di Laragon: Start All
```

### Error: Class not found
```bash
composer dump-autoload
```

### Error: Route not found
```bash
php artisan route:clear
php artisan route:cache
```

## 📝 Catatan Penting

1. **Password Default**: Semua user demo menggunakan password sederhana untuk testing. Di production, gunakan password yang kuat.
2. **MD5 Hash**: Password menggunakan MD5 untuk compatibility dengan database legacy. Untuk production baru, gunakan bcrypt/argon2.
3. **Trigger Database**: Tagihan di-generate otomatis saat input penggunaan via trigger MySQL.
4. **Denda**: Sistem hitung denda 2% per bulan untuk keterlambatan.

## 🔄 Update & Maintenance

```bash
# Update composer dependencies
composer update

# Clear all caches
php artisan optimize:clear

# Re-cache routes & config
php artisan optimize
```

## 👨‍💻 Developer

Dikembangkan untuk Sertifikasi Kompetensi (SERKOM) 2026

## 📄 License

Open source - MIT License

---

**🎉 Aplikasi siap digunakan!**

Akses: http://localhost:8000  
Login dengan credentials di atas untuk mulai menggunakan aplikasi.
