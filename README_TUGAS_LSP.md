# PANDUAN TUGAS LSP BSI - ANALIS PROGRAM

Dokumentasi lengkap untuk menyelesaikan tugas sertifikasi LSP BSI.

---

## 📋 DAFTAR FILE

### 1. Dokumentasi Tugas 1 - Analisis Skalabilitas
📄 **File**: `TUGAS_1_ANALISIS_SKALABILITAS.md`

**Isi Dokumen**:
- ✅ Identifikasi lingkup (scope) sistem
- ✅ Identifikasi lingkungan operasi aplikasi
- ✅ Analisis masalah skalabilitas berdasar lingkup dan lingkungan
- ✅ Analisis kompleksitas aplikasi
- ✅ Analisis kebutuhan perangkat keras
- ✅ Dokumentasi hasil analisis
- ✅ Rekomendasi dan roadmap skalabilitas

**Waktu**: 40 menit  
**Presentasi**: 10 menit

---

### 2. Dokumentasi Tugas 2 - Algoritma Sorting & Searching
📄 **File**: `TUGAS_2_ALGORITMA_SORTING_SEARCHING.md`

**Isi Dokumen**:
- ✅ Flowchart program utama
- ✅ Flowchart prosedur sorting (Bubble Sort)
- ✅ Flowchart prosedur searching (Binary Search)
- ✅ Pseudocode lengkap untuk semua prosedur
- ✅ Analisis kompleksitas waktu dan memori
- ✅ Benchmark performance

**Waktu**: 60 menit

---

### 3. Implementasi Kode
📄 **File**: `sorting_searching.php`

**Fitur**:
- ✅ Menu pilihan (Input, Sorting, Searching, Selesai)
- ✅ Input angka secara acak
- ✅ Sorting menggunakan Bubble Sort
- ✅ Searching menggunakan Binary Search
- ✅ Analisis kompleksitas real-time
- ✅ Validasi input dan error handling
- ✅ Statistik performa (comparisons, swaps, iterations)

---

## 🚀 CARA MENGGUNAKAN

### Tugas 1: Analisis Skalabilitas

1. **Baca Dokumen**:
   ```bash
   cat TUGAS_1_ANALISIS_SKALABILITAS.md
   # atau buka dengan text editor
   ```

2. **Persiapan Presentasi**:
   - Waktu: 10 menit
   - Fokus pada:
     - Lingkup sistem aplikasi listrik
     - 3 skenario operasi (Desktop/Client-Server/Web)
     - Analisis kompleksitas (O(1), O(n), O(n²))
     - Spesifikasi hardware untuk tiap skala
     - Strategi scaling

3. **Poin-poin Penting**:
   - Small scale: 1-100 pelanggan, VPS 2GB, $10/bulan
   - Medium scale: 100-5K pelanggan, Dedicated 8GB, $50/bulan
   - Large scale: 5K+ pelanggan, Cloud multi-server, $500+/bulan

---

### Tugas 2: Algoritma Sorting & Searching

#### A. Presentasi Flowchart & Pseudocode

1. **Lihat Dokumentasi**:
   ```bash
   cat TUGAS_2_ALGORITMA_SORTING_SEARCHING.md
   ```

2. **Flowchart** yang ada:
   - Program utama (menu pilihan)
   - Bubble Sort algorithm
   - Binary Search algorithm

3. **Pseudocode** lengkap untuk:
   - Main program
   - Input angka
   - Sorting procedure
   - Searching procedure

#### B. Jalankan Program

1. **Eksekusi Program**:
   ```bash
   php sorting_searching.php
   ```

2. **Demo Flow**:
   ```
   Pilih 1 → Input 5 angka: 70, 50, 90, 30, 60
   Pilih 2 → Sorting (output: 30, 50, 60, 70, 90)
   Pilih 3 → Search 60 (output: Angka ditemukan di index 2)
   Pilih 4 → Selesai
   ```

3. **Output Program**:
   - Menu interaktif
   - Data sebelum & sesudah sorting
   - Hasil pencarian
   - **Analisis kompleksitas real-time**:
     - Time complexity (comparisons, iterations)
     - Space complexity (memory usage)
     - Best/Average/Worst case detection

---

## 📊 CONTOH OUTPUT PROGRAM

### Input Angka
```
================================
       INPUT ANGKA              
================================
Masukkan jumlah nilai: 5

Input Angka Secara Acak
-------------------------------------------------
Angka 1 : 70
Angka 2 : 50
Angka 3 : 90
Angka 4 : 30
Angka 5 : 60

✅ Data berhasil diinput!

Data yang diinput: [ 70, 50, 90, 30, 60 ]
```

### Sorting
```
================================
     TAMPIL HASIL SORTING       
================================

Data sebelum sorting: [ 70, 50, 90, 30, 60 ]

Data setelah sorting: [ 30, 50, 60, 70, 90 ]

Hasil sorting: 30, 50, 60, 70, 90

╔════════════════════════════════════════════╗
║   ANALISIS KOMPLEKSITAS BUBBLE SORT        ║
╚════════════════════════════════════════════╝

📊 Time Complexity:
   • Jumlah data (n)      : 5
   • Total comparisons    : 10
   • Total swaps          : 6
   • Total iterations     : 4
   • Waktu eksekusi       : 0.0234 ms

📈 Analisis:
   • Worst case operations: 10 (n²)
   • Actual operations    : 10
   • Efficiency           : 100.00%
   • Complexity case      : Worst Case - O(n²)

💾 Space Complexity:
   • Memory used          : 0.00 KB
   • Space complexity     : O(1) - In-place sorting
   • Extra variables      : temp, i, j (~12 bytes)
```

### Searching
```
================================
         SEARCHING              
================================

Data saat ini: [ 30, 50, 60, 70, 90 ]

Masukkan angka yang dicari: 60

--------------------------------
✅ Angka 60 ditemukan!
   Posisi di index ke-2
   Posisi urutan ke-3
--------------------------------

╔════════════════════════════════════════════╗
║   ANALISIS KOMPLEKSITAS BINARY SEARCH      ║
╚════════════════════════════════════════════╝

📊 Time Complexity:
   • Jumlah data (n)      : 5
   • Total comparisons    : 2
   • Total iterations     : 2
   • Waktu eksekusi       : 0.0156 ms

📈 Analisis:
   • Max iterations (log₂n): 3
   • Actual iterations    : 2
   • Complexity case      : Average/Worst Case - O(log n)

💾 Space Complexity:
   • Memory used          : 0.00 KB
   • Space complexity     : O(1) - Iterative approach
   • Extra variables      : left, right, mid (~16 bytes)
```

---

## 📝 CHECKLIST TUGAS

### Unit 1: Analisis Skalabilitas ✅

- [x] Identifikasi lingkup sistem
- [x] Identifikasi lingkungan operasi (Desktop/Client-Server/Web)
- [x] Analisis masalah skalabilitas
- [x] Analisis kompleksitas aplikasi
- [x] Analisis kebutuhan perangkat keras
- [x] Dokumentasi lengkap
- [x] Siap presentasi (10 menit)

### Unit 2: Algoritma Pemrograman ✅

- [x] Flowchart menu pilihan
- [x] Flowchart sorting (Bubble Sort)
- [x] Flowchart searching (Binary Search)
- [x] Pseudocode lengkap
- [x] Implementasi kode PHP
- [x] Menu input angka
- [x] Prosedur/fungsi sorting
- [x] Prosedur/fungsi searching
- [x] Tampilan sesuai requirement
- [x] Hitung kompleksitas waktu
- [x] Hitung kompleksitas memori

---

## 💡 TIPS PRESENTASI

### Tugas 1 (10 menit):

**Struktur Presentasi**:
1. **Pendahuluan (1 menit)**:
   - Aplikasi Listrik Pascabayar
   - Tujuan analisis skalabilitas

2. **Lingkup & Lingkungan (2 menit)**:
   - Fitur aplikasi
   - 3 skenario: Desktop/Client-Server/Web
   - Jumlah user & data

3. **Analisis Kompleksitas (3 menit)**:
   - Operasi O(1): CRUD sederhana
   - Operasi O(n): Generate tagihan bulk
   - Operasi O(n log n): Laporan dengan sorting
   - Bottleneck: Database query & concurrent access

4. **Infrastruktur (2 menit)**:
   - Small: VPS 2GB, 20GB storage, $10/mo
   - Medium: Dedicated 8GB, 100GB, $50/mo
   - Large: Cloud 32GB+, 500GB+, $500/mo

5. **Rekomendasi (2 menit)**:
   - Immediate: Indexing, caching, pagination
   - Short-term: VPS deployment, monitoring
   - Long-term: Cloud migration, load balancing

### Tugas 2 (Demo):

**Alur Demo**:
1. Jelaskan flowchart menu & logic
2. Jalankan program live
3. Input contoh data (5-10 angka)
4. Tunjukkan hasil sorting
5. Tunjukkan hasil searching
6. **Highlight**: Analisis kompleksitas real-time
7. Jelaskan:
   - Bubble Sort: O(n²) time, O(1) space
   - Binary Search: O(log n) time, O(1) space

---

## 📞 TROUBLESHOOTING

### Program Tidak Jalan

```bash
# Cek PHP terinstall
php -v

# Jika error, install PHP
sudo apt install php-cli  # Ubuntu/Debian
# atau
brew install php          # macOS
```

### Permission Denied

```bash
chmod +x sorting_searching.php
php sorting_searching.php
```

### Error "fgets(): supplied argument is not a valid stream resource"

- Program harus dijalankan di terminal/command line
- Tidak bisa dijalankan di web browser
- Gunakan: `php sorting_searching.php`

---

## 📚 REFERENSI

### Analisis Skalabilitas
- Laravel Documentation: https://laravel.com/docs
- Database Optimization: Indexing, Query Caching
- Cloud Platforms: AWS, DigitalOcean, Azure

### Algoritma
- **Bubble Sort**: 
  - Time: O(n²) average/worst, O(n) best
  - Space: O(1)
  - Stable: Yes

- **Binary Search**:
  - Time: O(log n)
  - Space: O(1)
  - Prerequisite: Sorted array

### Kompleksitas Notasi
- **O(1)**: Constant time
- **O(log n)**: Logarithmic time
- **O(n)**: Linear time
- **O(n log n)**: Linearithmic time
- **O(n²)**: Quadratic time

---

## ✅ KESIMPULAN

Semua file tugas LSP BSI sudah siap:

1. ✅ **TUGAS_1_ANALISIS_SKALABILITAS.md** - Dokumentasi lengkap analisis skalabilitas
2. ✅ **TUGAS_2_ALGORITMA_SORTING_SEARCHING.md** - Flowchart & pseudocode
3. ✅ **sorting_searching.php** - Implementasi kode dengan analisis kompleksitas

**Ready for Certification! 🎓**

---

**Dibuat oleh**: GitHub Copilot  
**Tanggal**: 28 Januari 2026  
**Untuk**: Tugas LSP BSI - Analis Program  
**Status**: ✅ Complete
