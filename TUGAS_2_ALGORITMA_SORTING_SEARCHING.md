# IMPLEMENTASI ALGORITMA PEMROGRAMAN
## Sorting dan Searching

---

**Unit Kompetensi**: J.620100.022.02 - Mengimplementasikan Algoritma Pemrograman  
**Tugas**: Flowchart dan Pseudocode untuk Sorting & Searching  
**Tanggal**: 28 Januari 2026

---

## DAFTAR ISI

1. [Flowchart Program Utama](#1-flowchart-program-utama)
2. [Flowchart Prosedur Sorting](#2-flowchart-prosedur-sorting)
3. [Flowchart Prosedur Searching](#3-flowchart-prosedur-searching)
4. [Pseudocode Lengkap](#4-pseudocode-lengkap)
5. [Analisis Kompleksitas](#5-analisis-kompleksitas)
6. [Implementasi Code](#6-implementasi-code)

---

## 1. FLOWCHART PROGRAM UTAMA

```
                    ┌─────────┐
                    │  START  │
                    └────┬────┘
                         │
                         ▼
              ┌──────────────────────┐
              │ Inisialisasi Array   │
              │ data[] = kosong      │
              │ n = 0                │
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
                         ▼
               ┌──────────────────┐
               │ Input pilihan    │
               └────────┬─────────┘
                        │
         ┌──────────────┼──────────────┬─────────┐
         │              │              │         │
         ▼              ▼              ▼         ▼
    pilihan=1      pilihan=2      pilihan=3  pilihan=4
         │              │              │         │
         ▼              ▼              ▼         ▼
   ┌─────────┐   ┌──────────┐   ┌──────────┐  ┌─────┐
   │  Input  │   │ Sorting  │   │Searching │  │ END │
   │  Angka  │   │          │   │          │  └─────┘
   └────┬────┘   └────┬─────┘   └────┬─────┘
        │             │              │
        │    ┌────────▼──────────┐   │
        │    │ Cek: n > 0 ?      │   │
        │    └────┬──────┬───────┘   │
        │         │ Ya   │ Tidak     │
        │         │      │           │
        │         ▼      ▼           │
        │    ┌─────┐ ┌────────────┐ │
        │    │Call │ │ Tampilkan  │ │
        │    │Sort │ │"Data masih"│ │
        │    │     │ │"  kosong"  │ │
        │    └──┬──┘ └──────┬─────┘ │
        │       │           │        │
        │       │    ┌──────▼────────┐
        │       │    │Cek: n > 0 &&  │
        │       │    │   sorted?     │
        │       │    └───┬─────┬─────┘
        │       │        │ Ya  │ Tidak
        │       │        │     │
        │       │        ▼     ▼
        │       │    ┌─────┐ ┌────────────┐
        │       │    │Call │ │ Tampilkan  │
        │       │    │Search│ │"Sort dulu" │
        │       │    └──┬──┘ └──────┬─────┘
        │       │       │           │
        └───────┴───────┴───────────┘
                        │
                        ▼
                 ┌──────────────┐
                 │ Kembali ke   │
                 │   Menu       │
                 └──────────────┘
```

---

## 2. FLOWCHART PROSEDUR SORTING

### A. Flowchart Bubble Sort (Ascending)

```
                    ┌──────────────┐
                    │  PROCEDURE   │
                    │  bubbleSort  │
                    │  (data[], n) │
                    └──────┬───────┘
                           │
                           ▼
                    ┌──────────────┐
                    │ i = 0        │
                    └──────┬───────┘
                           │
                  ┌────────▼────────┐
                  │  i < n - 1 ?    │
                  └────┬────────┬───┘
                  Tidak│        │Ya
                       │        │
                       │        ▼
                       │  ┌─────────────┐
                       │  │ j = 0       │
                       │  └──────┬──────┘
                       │         │
                       │  ┌──────▼────────────┐
                       │  │ j < n - i - 1 ?   │
                       │  └──┬───────────┬────┘
                       │ Tidak│          │Ya
                       │     │           │
                       │     │           ▼
                       │     │   ┌────────────────────┐
                       │     │   │data[j] > data[j+1]?│
                       │     │   └──┬──────────┬──────┘
                       │     │  Tidak│         │Ya
                       │     │      │          │
                       │     │      │          ▼
                       │     │      │   ┌─────────────┐
                       │     │      │   │ temp=data[j]│
                       │     │      │   │data[j]=data │
                       │     │      │   │  [j+1]      │
                       │     │      │   │data[j+1]=   │
                       │     │      │   │   temp      │
                       │     │      │   │ (SWAP)      │
                       │     │      │   └──────┬──────┘
                       │     │      │          │
                       │     │      └──────────┘
                       │     │             │
                       │     │      ┌──────▼─────┐
                       │     │      │ j = j + 1  │
                       │     │      └──────┬─────┘
                       │     │             │
                       │     └─────────────┘
                       │             │
                       │      ┌──────▼─────┐
                       │      │ i = i + 1  │
                       │      └──────┬─────┘
                       │             │
                       └─────────────┘
                              │
                              ▼
                       ┌─────────────┐
                       │   RETURN    │
                       │sorted data[]│
                       └─────────────┘
```

---

## 3. FLOWCHART PROSEDUR SEARCHING

### A. Flowchart Binary Search

```
                    ┌──────────────┐
                    │  PROCEDURE   │
                    │ binarySearch │
                    │(data[],n,key)│
                    └──────┬───────┘
                           │
                           ▼
                    ┌──────────────┐
                    │ left = 0     │
                    │ right = n-1  │
                    │ found = FALSE│
                    └──────┬───────┘
                           │
                  ┌────────▼──────────┐
                  │ left <= right &&  │
                  │  found == FALSE ? │
                  └────┬──────────┬───┘
                  Tidak│          │Ya
                       │          │
                       │          ▼
                       │   ┌──────────────────┐
                       │   │ mid = (left +    │
                       │   │    right) / 2    │
                       │   └────────┬─────────┘
                       │            │
                       │     ┌──────▼─────────┐
                       │     │ data[mid]==key?│
                       │     └──┬───┬──────┬──┘
                       │        │   │      │
                       │      Ya│   │      │Tidak
                       │        │   │      │
                       │        ▼   │      │
                       │   ┌─────────┐     │
                       │   │found=TRUE     │
                       │   │index=mid│     │
                       │   └────┬────┘     │
                       │        │          │
                       │        │   ┌──────▼─────────┐
                       │        │   │ key < data[mid]│
                       │        │   └──┬──────────┬──┘
                       │        │   Ya │          │Tidak
                       │        │      │          │
                       │        │      ▼          ▼
                       │        │ ┌─────────┐ ┌──────────┐
                       │        │ │right=   │ │left =    │
                       │        │ │mid - 1  │ │ mid + 1  │
                       │        │ └────┬────┘ └────┬─────┘
                       │        │      │           │
                       │        └──────┴───────────┘
                       │               │
                       └───────────────┘
                              │
                     ┌────────▼────────┐
                     │  found == TRUE? │
                     └────┬────────┬───┘
                       Ya │        │Tidak
                          │        │
                          ▼        ▼
                   ┌──────────┐ ┌──────────┐
                   │ RETURN   │ │ RETURN   │
                   │ "Angka   │ │ "Angka   │
                   │ditemukan"│ │ tidak    │
                   │"di index"│ │ditemukan"│
                   │   mid    │ │          │
                   └──────────┘ └──────────┘
```

---

## 4. PSEUDOCODE LENGKAP

### A. Program Utama

```
PROGRAM SortingSearching

// Deklarasi variabel global
DECLARE data[] AS INTEGER ARRAY (max 100)
DECLARE n AS INTEGER = 0
DECLARE isSorted AS BOOLEAN = FALSE

// Program utama
BEGIN
    REPEAT
        // Tampilkan menu
        PRINT "================================"
        PRINT "       MENU PILIHAN             "
        PRINT "================================"
        PRINT "1. Input angka"
        PRINT "2. Sorting"
        PRINT "3. Searching"
        PRINT "4. Selesai"
        PRINT "================================"
        PRINT "Masukkan pilihan [1/2/3/4]: "
        INPUT pilihan
        
        // Proses menu
        CASE pilihan OF
            1: CALL inputAngka()
            2: CALL sorting()
            3: CALL searching()
            4: PRINT "Program selesai. Terima kasih!"
               EXIT
            DEFAULT: PRINT "Pilihan tidak valid!"
        END CASE
        
        PRINT ""  // Baris kosong
        
    UNTIL pilihan == 4
    
END
```

### B. Prosedur Input Angka

```
PROCEDURE inputAngka()
BEGIN
    PRINT "================================"
    PRINT "       INPUT ANGKA              "
    PRINT "================================"
    
    PRINT "Masukkan jumlah nilai: "
    INPUT n
    
    // Validasi input
    IF n <= 0 OR n > 100 THEN
        PRINT "Jumlah harus antara 1-100!"
        RETURN
    END IF
    
    PRINT "Input Angka Secara Acak"
    PRINT "--------------------------------"
    
    // Input data
    FOR i = 0 TO n - 1 DO
        PRINT "Angka ", (i + 1), ": "
        INPUT data[i]
    END FOR
    
    isSorted = FALSE  // Reset status sorted
    
    PRINT "Data berhasil diinput!"
    
END PROCEDURE
```

### C. Prosedur Sorting (Bubble Sort)

```
PROCEDURE sorting()
BEGIN
    // Validasi data
    IF n == 0 THEN
        PRINT "Data masih kosong!"
        PRINT "Silakan input angka terlebih dahulu."
        RETURN
    END IF
    
    PRINT "================================"
    PRINT "     TAMPIL HASIL SORTING       "
    PRINT "================================"
    
    PRINT "Data sebelum sorting: "
    CALL tampilkanArray(data, n)
    
    // Bubble Sort Algorithm (Ascending)
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
    
    isSorted = TRUE  // Set status sorted
    
    PRINT "Data setelah sorting: "
    CALL tampilkanArray(data, n)
    
    PRINT "Hasil sorting: "
    FOR i = 0 TO n - 1 DO
        PRINT data[i]
        IF i < n - 1 THEN
            PRINT ", "
        END IF
    END FOR
    PRINT ""
    
END PROCEDURE
```

### D. Prosedur Searching (Binary Search)

```
PROCEDURE searching()
BEGIN
    // Validasi data
    IF n == 0 THEN
        PRINT "Data masih kosong!"
        PRINT "Silakan input angka terlebih dahulu."
        RETURN
    END IF
    
    // Validasi sudah di-sort
    IF NOT isSorted THEN
        PRINT "Data belum di-sorting!"
        PRINT "Silakan lakukan sorting terlebih dahulu."
        RETURN
    END IF
    
    PRINT "================================"
    PRINT "         SEARCHING              "
    PRINT "================================"
    
    PRINT "Masukkan angka yang dicari: "
    INPUT key
    
    // Binary Search Algorithm
    left = 0
    right = n - 1
    found = FALSE
    index = -1
    
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
    
    // Tampilkan hasil
    PRINT "--------------------------------"
    IF found THEN
        PRINT "Angka ", key, " ditemukan!"
        PRINT "Posisi di index ke-", index
        PRINT "Posisi urutan ke-", (index + 1)
    ELSE
        PRINT "Angka ", key, " tidak ditemukan!"
    END IF
    PRINT "--------------------------------"
    
END PROCEDURE
```

### E. Prosedur Tampilkan Array

```
PROCEDURE tampilkanArray(arr[], size)
BEGIN
    PRINT "[ "
    FOR i = 0 TO size - 1 DO
        PRINT arr[i]
        IF i < size - 1 THEN
            PRINT ", "
        END IF
    END FOR
    PRINT " ]"
END PROCEDURE
```

---

## 5. ANALISIS KOMPLEKSITAS

### A. Kompleksitas Bubble Sort

#### 1. Time Complexity (Waktu)

**Best Case**: O(n)
- Terjadi ketika data sudah terurut
- Hanya perlu 1 pass untuk memverifikasi
- Dengan optimasi early exit

**Average Case**: O(n²)
- Data dalam kondisi acak
- Memerlukan banyak perbandingan dan swap
- Iterasi: n × (n-1) / 2

**Worst Case**: O(n²)
- Data terurut terbalik (descending)
- Maksimum swap dan perbandingan
- Iterasi penuh: n × (n-1) / 2

**Perhitungan Detail**:
```
Outer loop: n - 1 iterasi
Inner loop: (n - i - 1) iterasi untuk setiap i

Total operasi:
= (n-1) + (n-2) + (n-3) + ... + 1
= (n-1) × n / 2
= (n² - n) / 2
= O(n²)
```

**Contoh dengan n = 5**:
```
Pass 1: 4 perbandingan
Pass 2: 3 perbandingan
Pass 3: 2 perbandingan
Pass 4: 1 perbandingan
Total: 10 perbandingan = 5 × 4 / 2
```

#### 2. Space Complexity (Memori)

**Space Complexity**: O(1)
- Hanya menggunakan 1 variabel temporary untuk swap
- Tidak ada struktur data tambahan
- In-place sorting

**Memory Usage**:
```
- Array data[n]: n × 4 bytes (integer)
- Variable temp: 4 bytes
- Variable i, j: 2 × 4 bytes
- Total extra: ~12 bytes
```

**Contoh n = 100**:
```
Array: 100 × 4 = 400 bytes
Extra: 12 bytes
Total: 412 bytes ≈ 0.4 KB
```

---

### B. Kompleksitas Binary Search

#### 1. Time Complexity (Waktu)

**Best Case**: O(1)
- Elemen yang dicari berada di tengah
- 1 perbandingan langsung ketemu

**Average Case**: O(log n)
- Elemen berada di posisi acak
- Membagi area pencarian menjadi 2 setiap iterasi

**Worst Case**: O(log n)
- Elemen di ujung atau tidak ada
- Maksimum iterasi: log₂(n)

**Perhitungan Detail**:
```
Setiap iterasi membagi range menjadi 2
Iterasi 1: n elemen
Iterasi 2: n/2 elemen
Iterasi 3: n/4 elemen
...
Iterasi k: n/(2^k) elemen = 1

Solving: n/(2^k) = 1
        2^k = n
        k = log₂(n)

Time Complexity: O(log₂ n)
```

**Contoh**:
```
n = 100 elemen
Maximum iterations = log₂(100) ≈ 7 iterasi

n = 1,000 elemen
Maximum iterations = log₂(1000) ≈ 10 iterasi

n = 1,000,000 elemen
Maximum iterations = log₂(1000000) ≈ 20 iterasi
```

#### 2. Space Complexity (Memori)

**Space Complexity**: O(1)
- Hanya menggunakan variabel left, right, mid
- Tidak ada rekursi atau struktur tambahan
- Iterative approach

**Memory Usage**:
```
- Variable left: 4 bytes
- Variable right: 4 bytes
- Variable mid: 4 bytes
- Variable found: 1 byte
- Variable key: 4 bytes
- Total: ~17 bytes
```

---

### C. Perbandingan Algoritma

| Algoritma | Time (Best) | Time (Avg) | Time (Worst) | Space | Stable? |
|-----------|-------------|------------|--------------|-------|---------|
| **Bubble Sort** | O(n) | O(n²) | O(n²) | O(1) | Yes |
| **Binary Search** | O(1) | O(log n) | O(log n) | O(1) | - |

---

### D. Benchmark Performance

#### Bubble Sort Performance

| Data Size (n) | Comparisons | Swaps (Worst) | Time (ms) |
|---------------|-------------|---------------|-----------|
| 10 | 45 | 45 | <1 |
| 100 | 4,950 | 4,950 | 5-10 |
| 1,000 | 499,500 | 499,500 | 500-1000 |
| 10,000 | 49,995,000 | 49,995,000 | 50,000+ |

#### Binary Search Performance

| Data Size (n) | Max Iterations | Time (µs) |
|---------------|----------------|-----------|
| 10 | 4 | <1 |
| 100 | 7 | <1 |
| 1,000 | 10 | <1 |
| 10,000 | 14 | <1 |
| 100,000 | 17 | <1 |
| 1,000,000 | 20 | 1-2 |

---

### E. Analisis Kasus Praktis

**Skenario: n = 100 angka acak**

**Input Angka**:
- Time: O(n) = 100 operasi input
- Space: 100 × 4 bytes = 400 bytes
- Waktu eksekusi: ~1-2 detik (termasuk user input)

**Sorting (Bubble Sort)**:
- Time: O(n²) = 10,000 operasi worst case
- Comparisons: ~4,950
- Swaps: ~2,475 (average)
- Space: 12 bytes tambahan
- Waktu eksekusi: ~5-10 ms

**Searching (Binary Search)**:
- Time: O(log n) = log₂(100) ≈ 7 iterasi
- Comparisons: maksimal 7
- Space: 17 bytes
- Waktu eksekusi: <1 ms

**Total Memory Usage**:
```
Array data: 400 bytes
Program variables: ~50 bytes
Total: ~450 bytes ≈ 0.44 KB
```

---

### F. Optimasi yang Dapat Dilakukan

#### 1. Bubble Sort Optimasi

**Optimasi 1: Early Exit**
```
IF no swap occurred in a pass THEN
    Array is sorted
    EXIT loop
END IF
```
- Best case menjadi O(n)
- Deteksi array yang sudah sorted

**Optimasi 2: Reduce Range**
```
Track last swap position
Next pass only check up to last swap
```
- Reduce unnecessary comparisons

#### 2. Alternative Algorithms

**Quick Sort**:
- Time: O(n log n) average
- Better untuk data besar
- Space: O(log n) untuk rekursi

**Merge Sort**:
- Time: O(n log n) guaranteed
- Stable sorting
- Space: O(n) untuk temporary array

**Linear Search (Alternative)**:
- Time: O(n)
- Tidak perlu data sorted
- Lebih sederhana untuk data kecil

---

## 6. KESIMPULAN

### Ringkasan Kompleksitas

| Operasi | Algoritma | Time Complexity | Space Complexity |
|---------|-----------|-----------------|------------------|
| **Input** | Sequential Input | O(n) | O(n) |
| **Sorting** | Bubble Sort | O(n²) | O(1) |
| **Searching** | Binary Search | O(log n) | O(1) |

### Keunggulan & Kekurangan

**Bubble Sort**:
- ✅ Sederhana dan mudah dipahami
- ✅ In-place sorting (space efficient)
- ✅ Stable sort
- ❌ Lambat untuk data besar (O(n²))
- ❌ Tidak efisien untuk data yang hampir sorted

**Binary Search**:
- ✅ Sangat cepat (O(log n))
- ✅ Efisien untuk data besar
- ✅ Space efficient
- ❌ Memerlukan data yang sudah sorted
- ❌ Tidak bisa digunakan untuk unsorted data

### Rekomendasi

1. **Untuk n < 100**: Bubble Sort acceptable
2. **Untuk n > 100**: Gunakan Quick Sort / Merge Sort
3. **Searching**: Selalu gunakan Binary Search untuk sorted data
4. **Memory Critical**: Algoritma yang dipilih sudah optimal (O(1) space)

---

**Prepared by**: [Nama Asesi]  
**Date**: 28 Januari 2026  
**Version**: 1.0  
**Status**: Ready for Implementation
