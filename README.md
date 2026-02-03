# Aplikasi Listrik Pascabayar

Sistem manajemen listrik pascabayar berbasis web menggunakan Laravel 12. Aplikasi ini memungkinkan PLN untuk mengelola data pelanggan, mencatat penggunaan listrik bulanan, generate tagihan otomatis, dan memproses pembayaran.

---

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Requirements](#-requirements)
- [Instalasi](#-instalasi)
- [Demo Credentials](#-demo-credentials)
- [Database Schema](#-database-schema)
- [Struktur Aplikasi](#-struktur-aplikasi)
- [Workflow Aplikasi](#-workflow-aplikasi)
- [Dokumentasi LSP BSI](#-dokumentasi-lsp-bsi)

---

## 🚀 Fitur Utama

### 1. Multi-Level User Access
- **Admin**: Akses penuh ke semua fitur sistem
- **Operator**: Mengelola data pelanggan, penggunaan, tagihan, dan pembayaran
- **Pelanggan**: Melihat informasi akun, penggunaan, dan tagihan sendiri

### 2. Manajemen Pelanggan
- ✅ CRUD data pelanggan
- ✅ Auto-generate ID pelanggan (PEL001, PEL002, ...)
- ✅ Manajemen daya listrik (450VA, 900VA, 1300VA, 2200VA, 3500VA)
- ✅ Status pelanggan (Aktif, Nonaktif, Suspend)
- ✅ Pembuatan akun user otomatis untuk pelanggan

### 3. Pencatatan Penggunaan Listrik
- ✅ Input meter awal dan meter akhir per bulan
- ✅ Auto-calculate total kWh
- ✅ Ambil meter akhir bulan lalu sebagai meter awal
- ✅ Validasi periode (tidak boleh duplikat)

### 4. Sistem Tagihan Otomatis
- ✅ Generate tagihan otomatis via database trigger
- ✅ Perhitungan berdasarkan tarif per kWh
- ✅ Sistem denda keterlambatan 2% per bulan
- ✅ Jatuh tempo 20 hari dari tanggal tagihan
- ✅ Status: Belum Bayar, Sudah Bayar, Terlambat

### 5. Pembayaran
- ✅ Multi metode pembayaran (Tunai, Transfer, EDC, QRIS)
- ✅ Update status tagihan otomatis setelah bayar
- ✅ Cetak struk pembayaran
- ✅ Validasi jumlah pembayaran

### 6. Dashboard & Laporan
- ✅ Dashboard dengan statistik real-time
- ✅ Grafik pendapatan bulanan
- ✅ Laporan penggunaan listrik
- ✅ Laporan pembayaran
- ✅ Laporan tunggakan
- ✅ Laporan pelanggan per daya

---

## 📋 Requirements

- PHP >= 8.2
- MySQL >= 8.0
- Composer
- Laravel 12
- Node.js & NPM (optional, untuk asset compilation)

---

## 🔧 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd aplikasi-listrik
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Environment
Salin file `.env.example` ke `.env` dan sesuaikan:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aplikasi_listrik_pascabayar
DB_USERNAME=root
DB_PASSWORD=root
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Setup Database (Pilih Salah Satu)

**Opsi A: Via Migration & Seeder (Recommended)**
```bash
php artisan migrate:fresh --seed
```
Ini akan membuat semua tabel, trigger, view, dan data sample otomatis.

**Opsi B: Via SQL Import (Manual)**
```bash
mysql -u root -proot < database_schema.sql
```

### 6. Run Application
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Akses aplikasi di: **http://localhost:8000**

---

## 👤 Demo Credentials

| Role | Username | Password |
|------|----------|----------|
| **Admin** | `admin` | `admin123` |
| **Operator** | `operator1` | `operator123` |
| **Pelanggan** | `PEL001` | `password123` |

---

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

---

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
│       ├── layouts/                        # Master layout
│       ├── auth/                           # Login views
│       ├── dashboard/                      # Dashboard views
│       ├── pelanggan/                      # CRUD Pelanggan views
│       ├── penggunaan/                     # Penggunaan views
│       ├── tagihan/                        # Tagihan views
│       ├── pembayaran/                     # Pembayaran views
│       └── laporan/                        # Laporan views
├── routes/
│   └── web.php                             # All routes
└── database_schema.sql                     # Complete DB with data
```

---

## 🎯 Workflow Aplikasi

### 1. Tambah Pelanggan Baru
1. Login sebagai Admin/Operator
2. Menu Pelanggan → Tambah Pelanggan
3. Isi data lengkap pelanggan
4. Pilih daya listrik
5. Optional: centang "Buat akun user" untuk akses pelanggan
6. Simpan → ID auto-generated (PEL001, PEL002, ...)

### 2. Input Penggunaan Bulanan
1. Menu Penggunaan → Input Penggunaan
2. Pilih pelanggan
3. Pilih bulan & tahun
4. Input meter awal (atau ambil dari bulan lalu)
5. Input meter akhir
6. Total kWh dihitung otomatis
7. Simpan → **Tagihan auto-generated via trigger**

### 3. Proses Pembayaran
1. Menu Pembayaran → Input Pembayaran
2. Pilih tagihan yang akan dibayar
3. Sistem auto-fill jumlah yang harus dibayar
4. Pilih metode pembayaran
5. Simpan → Status tagihan berubah "Sudah Bayar"

### 4. Lihat Laporan
- **Laporan Penggunaan**: Filter per bulan/tahun
- **Laporan Pembayaran**: Rekap pembayaran per periode
- **Laporan Tunggakan**: Daftar tagihan belum lunas
- **Laporan Pelanggan**: Data per kategori daya

---

## 📚 Dokumentasi LSP BSI

### Unit Kompetensi

| Kode | Unit Kompetensi | Waktu |
|------|-----------------|-------|
| J.620100.002.01 | Menganalisis Skalabilitas Perangkat Lunak | 40 menit + 10 menit presentasi |
| J.620100.022.02 | Mengimplementasikan Algoritma Pemrograman | 60 menit |

---

### Tugas 1: Analisis Skalabilitas

#### 1. Identifikasi Lingkup (Scope) Sistem

**Gambaran Umum**:
Aplikasi Listrik Pascabayar adalah sistem manajemen pembayaran listrik berbasis web yang memungkinkan PLN mengelola data pelanggan, pencatatan penggunaan listrik, generate tagihan otomatis, dan pemrosesan pembayaran.

**Aktor/Pengguna Sistem**:

| Level | Jumlah User | Hak Akses |
|-------|-------------|-----------|
| Admin | 1-5 | Full access ke seluruh sistem |
| Operator | 10-50 | Kelola pelanggan, tagihan, pembayaran |
| Pelanggan | 1,000-100,000+ | View data pribadi, tagihan, riwayat |

#### 2. Lingkungan Operasi

**Stack Teknologi**:
- Backend: PHP 8.2 + Laravel 12
- Frontend: Blade Template Engine, Bootstrap 5, JavaScript
- Database: MySQL 8.0
- Web Server: Apache/Nginx

**Arsitektur Sistem**:
```
┌─────────────────┐
│   Web Browser   │ ← Client (Pelanggan, Operator, Admin)
└────────┬────────┘
         │ HTTPS
┌────────▼────────┐
│   Web Server    │
│   + PHP 8.2     │
│   + Laravel 12  │
└────────┬────────┘
         │
┌────────▼────────┐
│  Database Server│
│   MySQL 8.0     │
└─────────────────┘
```

**Skenario Operasi**:

| Skenario | Skala | Karakteristik |
|----------|-------|---------------|
| Desktop (Small) | 1-100 pelanggan | Single server, LAN, 1-5 concurrent users |
| Client-Server (Medium) | 100-5,000 pelanggan | Dedicated server, 10-50 concurrent users |
| Web-based (Large) | 5,000-100,000+ pelanggan | Cloud, 100-1,000+ concurrent users |

#### 3. Analisis Masalah Skalabilitas

**Skalabilitas Data** (Estimasi 5 tahun):

| Tabel | Record/tahun | Total 5 tahun |
|-------|--------------|---------------|
| Pelanggan | 1,000 | 5,000 |
| Penggunaan | 12,000 | 60,000 |
| Tagihan | 12,000 | 60,000 |
| Pembayaran | 12,000 | 60,000 |
| **TOTAL** | 37,000 | **185,000 records** |

**Solusi**:
- Database indexing pada kolom pencarian
- Archiving data lama (>3 tahun)
- Database partitioning berdasarkan tahun

#### 4. Analisis Kompleksitas

| Operasi | Complexity | Karakteristik |
|---------|------------|---------------|
| CRUD Sederhana | O(1) | Login, view single record |
| Filtering/Sorting | O(n log n) | List dengan search & sort |
| Batch Processing | O(n) | Generate tagihan bulk |
| Reporting | O(n) | Laporan dengan aggregation |

#### 5. Kebutuhan Perangkat Keras

**Small Scale (1-100 Pelanggan)**:
| Komponen | Spesifikasi |
|----------|-------------|
| Processor | 2 vCPU / Core i3 |
| RAM | 2-4 GB |
| Storage | 20 GB SSD |
| Biaya | $5-10/bulan (VPS) |

**Medium Scale (100-5,000 Pelanggan)**:
| Komponen | Spesifikasi |
|----------|-------------|
| Processor | 4 vCPU / Core i5 |
| RAM | 8-16 GB |
| Storage | 100 GB SSD |
| Biaya | $40-80/bulan |

**Large Scale (5,000-100,000+ Pelanggan)**:
| Komponen | Spesifikasi |
|----------|-------------|
| App Server | 8 vCPU, 16-32 GB RAM (x2+) |
| DB Server | 8-16 vCPU, 32-64 GB RAM |
| Cache Server | 2-4 vCPU, 8-16 GB RAM |
| Biaya | $300-1,000+/bulan |

#### 6. Roadmap Skalabilitas

```
Year 0 (Now)          Year 1              Year 2              Year 3
│ 100 users          │ 1,000 users       │ 5,000 users       │ 20,000+ users
│ VPS 2GB            │ VPS 8GB           │ Dedicated 16GB    │ Cloud Multi-server
│ $10/mo             │ $40/mo            │ $150/mo           │ $500+/mo
│ Single Server  ────┼─→ Optimized   ────┼─→ Replica DB  ────┼─→ Load Balanced
```

---

### Tugas 2: Algoritma Sorting & Searching

#### 1. Flowchart Program Utama

```
                    ┌─────────┐
                    │  START  │
                    └────┬────┘
                         │
              ┌──────────▼───────────┐
              │ Inisialisasi Array   │
              │ data[] = kosong      │
              └──────────┬───────────┘
                         │
                ┌────────▼────────┐
                │ Tampilkan Menu: │
                │ 1. Input Angka  │
                │ 2. Sorting      │
                │ 3. Searching    │
                │ 4. Selesai      │
                └────────┬────────┘
                         │
         ┌───────────────┼───────────────┬─────────┐
         │               │               │         │
         ▼               ▼               ▼         ▼
    pilihan=1       pilihan=2       pilihan=3  pilihan=4
         │               │               │         │
         ▼               ▼               ▼         ▼
   ┌──────────┐   ┌──────────┐   ┌──────────┐  ┌─────┐
   │  Input   │   │ Sorting  │   │Searching │  │ END │
   │  Angka   │   │          │   │          │  └─────┘
   └────┬─────┘   └────┬─────┘   └────┬─────┘
        │              │              │
        └──────────────┴──────────────┘
                       │
                ┌──────▼───────┐
                │ Kembali ke   │
                │    Menu      │
                └──────────────┘
```

#### 2. Flowchart Bubble Sort (Ascending)

```
                    ┌──────────────┐
                    │  PROCEDURE   │
                    │  bubbleSort  │
                    │  (data[], n) │
                    └──────┬───────┘
                           │
                    ┌──────▼──────┐
                    │ i = 0       │
                    └──────┬──────┘
                           │
                  ┌────────▼────────┐
                  │  i < n - 1 ?    │
                  └───┬─────────┬───┘
                 Tidak│         │Ya
                      │         ▼
                      │   ┌───────────┐
                      │   │ j = 0     │
                      │   └─────┬─────┘
                      │         │
                      │  ┌──────▼──────────────┐
                      │  │ j < n - i - 1 ?     │
                      │  └───┬─────────────┬───┘
                      │ Tidak│             │Ya
                      │      │             ▼
                      │      │   ┌────────────────────┐
                      │      │   │data[j] > data[j+1]?│
                      │      │   └───┬───────────┬────┘
                      │      │   Tidak│          │Ya
                      │      │       │           ▼
                      │      │       │    ┌─────────────┐
                      │      │       │    │ SWAP        │
                      │      │       │    │ temp=data[j]│
                      │      │       │    │data[j]=     │
                      │      │       │    │  data[j+1]  │
                      │      │       │    │data[j+1]=   │
                      │      │       │    │   temp      │
                      │      │       │    └──────┬──────┘
                      │      │       └───────────┤
                      │      │            ┌──────▼─────┐
                      │      │            │ j = j + 1  │
                      │      │            └──────┬─────┘
                      │      └───────────────────┘
                      │               │
                      │        ┌──────▼─────┐
                      │        │ i = i + 1  │
                      │        └──────┬─────┘
                      │               │
                      └───────────────┘
                              │
                       ┌──────▼───────┐
                       │   RETURN     │
                       │ sorted data[]│
                       └──────────────┘
```

#### 3. Flowchart Binary Search

```
                    ┌──────────────┐
                    │  PROCEDURE   │
                    │ binarySearch │
                    │(data[],n,key)│
                    └──────┬───────┘
                           │
                    ┌──────▼──────────┐
                    │ left = 0        │
                    │ right = n-1     │
                    │ found = FALSE   │
                    └──────┬──────────┘
                           │
                  ┌────────▼──────────┐
                  │ left <= right &&  │
                  │  found == FALSE ? │
                  └───┬───────────┬───┘
                 Tidak│           │Ya
                      │           ▼
                      │   ┌───────────────────┐
                      │   │ mid = (left +     │
                      │   │    right) / 2     │
                      │   └─────────┬─────────┘
                      │             │
                      │      ┌──────▼─────────┐
                      │      │ data[mid]==key?│
                      │      └──┬───────┬─────┘
                      │       Ya│       │Tidak
                      │         ▼       │
                      │   ┌─────────┐   │
                      │   │found=TRUE   │
                      │   │index=mid│   │
                      │   └────┬────┘   │
                      │        │  ┌─────▼─────────┐
                      │        │  │key < data[mid]│
                      │        │  └──┬────────┬───┘
                      │        │  Ya │        │Tidak
                      │        │     ▼        ▼
                      │        │ ┌────────┐ ┌────────┐
                      │        │ │right=  │ │left =  │
                      │        │ │mid - 1 │ │mid + 1 │
                      │        │ └───┬────┘ └───┬────┘
                      │        └─────┴──────────┘
                      │              │
                      └──────────────┘
                             │
                    ┌────────▼────────┐
                    │  found == TRUE? │
                    └────┬────────┬───┘
                      Ya │        │Tidak
                         ▼        ▼
                  ┌──────────┐ ┌──────────┐
                  │ RETURN   │ │ RETURN   │
                  │"Ditemukan│ │ "Tidak   │
                  │ di index"│ │ditemukan"│
                  │   mid    │ │          │
                  └──────────┘ └──────────┘
```

#### 4. Pseudocode

**Program Utama**:
```
PROGRAM SortingSearching

DECLARE data[] AS INTEGER ARRAY (max 100)
DECLARE n AS INTEGER = 0
DECLARE isSorted AS BOOLEAN = FALSE

BEGIN
    REPEAT
        PRINT "1. Input angka"
        PRINT "2. Sorting"
        PRINT "3. Searching"
        PRINT "4. Selesai"
        INPUT pilihan
        
        CASE pilihan OF
            1: CALL inputAngka()
            2: CALL sorting()
            3: CALL searching()
            4: EXIT
        END CASE
    UNTIL pilihan == 4
END
```

**Bubble Sort**:
```
PROCEDURE bubbleSort(data[], n)
BEGIN
    FOR i = 0 TO n - 2 DO
        FOR j = 0 TO (n - i - 2) DO
            IF data[j] > data[j + 1] THEN
                // Swap
                temp = data[j]
                data[j] = data[j + 1]
                data[j + 1] = temp
            END IF
        END FOR
    END FOR
END PROCEDURE
```

**Binary Search**:
```
PROCEDURE binarySearch(data[], n, key)
BEGIN
    left = 0
    right = n - 1
    found = FALSE
    
    WHILE left <= right AND NOT found DO
        mid = (left + right) / 2
        
        IF data[mid] == key THEN
            found = TRUE
            index = mid
        ELSE IF key < data[mid] THEN
            right = mid - 1
        ELSE
            left = mid + 1
        END IF
    END WHILE
    
    IF found THEN
        RETURN "Ditemukan di index " + mid
    ELSE
        RETURN "Tidak ditemukan"
    END IF
END PROCEDURE
```

#### 5. Analisis Kompleksitas

**Bubble Sort**:

| Case | Time Complexity | Keterangan |
|------|-----------------|------------|
| Best | O(n) | Data sudah terurut |
| Average | O(n²) | Data acak |
| Worst | O(n²) | Data terbalik |
| Space | O(1) | In-place sorting |

**Binary Search**:

| Case | Time Complexity | Keterangan |
|------|-----------------|------------|
| Best | O(1) | Elemen di tengah |
| Average | O(log n) | Elemen di posisi acak |
| Worst | O(log n) | Elemen di ujung/tidak ada |
| Space | O(1) | Iterative approach |

**Perbandingan Performance**:

| Data Size (n) | Bubble Sort | Binary Search |
|---------------|-------------|---------------|
| 10 | 45 ops | 4 ops max |
| 100 | 4,950 ops | 7 ops max |
| 1,000 | 499,500 ops | 10 ops max |
| 10,000 | 49,995,000 ops | 14 ops max |

---

## 📄 License

MIT License

---

**Prepared by**: Aplikasi Listrik Team  
**Version**: 1.0  
**Last Updated**: 2026
