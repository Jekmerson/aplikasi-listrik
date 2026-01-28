<?php
/**
 * IMPLEMENTASI ALGORITMA SORTING DAN SEARCHING
 * 
 * Unit Kompetensi: J.620100.022.02
 * Tugas: Mengimplementasikan Algoritma Pemrograman
 * 
 * Fitur:
 * 1. Input angka
 * 2. Sorting (Bubble Sort)
 * 3. Searching (Binary Search)
 * 4. Analisis kompleksitas waktu dan memori
 */

class SortingSearching {
    private $data = [];
    private $n = 0;
    private $isSorted = false;
    
    // Statistik untuk analisis kompleksitas
    private $comparisons = 0;
    private $swaps = 0;
    private $iterations = 0;
    
    /**
     * Menampilkan menu utama
     */
    public function tampilkanMenu() {
        echo "\n";
        echo "================================\n";
        echo "       MENU PILIHAN             \n";
        echo "================================\n";
        echo "1. Input angka\n";
        echo "2. Sorting\n";
        echo "3. Searching\n";
        echo "4. Selesai\n";
        echo "================================\n";
    }
    
    /**
     * Input angka dari user
     */
    public function inputAngka() {
        echo "\n";
        echo "================================\n";
        echo "       INPUT ANGKA              \n";
        echo "================================\n";
        
        echo "Masukkan jumlah nilai: ";
        $this->n = (int) trim(fgets(STDIN));
        
        // Validasi input
        if ($this->n <= 0 || $this->n > 100) {
            echo "❌ Jumlah harus antara 1-100!\n";
            return;
        }
        
        echo "\nInput Angka Secara Acak\n";
        echo "-------------------------------------------------\n";
        
        $this->data = [];
        for ($i = 0; $i < $this->n; $i++) {
            echo "Angka " . ($i + 1) . " : ";
            $this->data[$i] = (int) trim(fgets(STDIN));
        }
        
        $this->isSorted = false;
        echo "\n✅ Data berhasil diinput!\n";
        
        // Tampilkan data yang diinput
        echo "\nData yang diinput: ";
        $this->tampilkanArray($this->data);
        echo "\n";
    }
    
    /**
     * Sorting menggunakan Bubble Sort
     */
    public function sorting() {
        // Validasi data
        if ($this->n == 0) {
            echo "\n❌ Data masih kosong!\n";
            echo "Silakan input angka terlebih dahulu (pilih menu 1).\n";
            return;
        }
        
        echo "\n";
        echo "================================\n";
        echo "     TAMPIL HASIL SORTING       \n";
        echo "================================\n";
        
        echo "\nData sebelum sorting: ";
        $this->tampilkanArray($this->data);
        echo "\n";
        
        // Reset statistik
        $this->comparisons = 0;
        $this->swaps = 0;
        $this->iterations = 0;
        
        $startTime = microtime(true);
        $startMemory = memory_get_usage();
        
        // Bubble Sort Algorithm
        $this->bubbleSort();
        
        $endTime = microtime(true);
        $endMemory = memory_get_usage();
        
        $this->isSorted = true;
        
        echo "\nData setelah sorting: ";
        $this->tampilkanArray($this->data);
        echo "\n";
        
        echo "\nHasil sorting: ";
        for ($i = 0; $i < $this->n; $i++) {
            echo $this->data[$i];
            if ($i < $this->n - 1) {
                echo ", ";
            }
        }
        echo "\n";
        
        // Tampilkan analisis kompleksitas
        $this->tampilkanAnalisisSorting($startTime, $endTime, $startMemory, $endMemory);
    }
    
    /**
     * Implementasi Bubble Sort
     */
    private function bubbleSort() {
        for ($i = 0; $i < $this->n - 1; $i++) {
            $swapped = false;
            
            for ($j = 0; $j < $this->n - $i - 1; $j++) {
                $this->comparisons++;
                
                if ($this->data[$j] > $this->data[$j + 1]) {
                    // Swap
                    $temp = $this->data[$j];
                    $this->data[$j] = $this->data[$j + 1];
                    $this->data[$j + 1] = $temp;
                    
                    $this->swaps++;
                    $swapped = true;
                }
            }
            
            $this->iterations++;
            
            // Optimasi: jika tidak ada swap, array sudah terurut
            if (!$swapped) {
                break;
            }
        }
    }
    
    /**
     * Searching menggunakan Binary Search
     */
    public function searching() {
        // Validasi data
        if ($this->n == 0) {
            echo "\n❌ Data masih kosong!\n";
            echo "Silakan input angka terlebih dahulu (pilih menu 1).\n";
            return;
        }
        
        // Validasi sudah di-sort
        if (!$this->isSorted) {
            echo "\n❌ Data belum di-sorting!\n";
            echo "Silakan lakukan sorting terlebih dahulu (pilih menu 2).\n";
            return;
        }
        
        echo "\n";
        echo "================================\n";
        echo "         SEARCHING              \n";
        echo "================================\n";
        
        echo "\nData saat ini: ";
        $this->tampilkanArray($this->data);
        echo "\n";
        
        echo "\nMasukkan angka yang dicari: ";
        $key = (int) trim(fgets(STDIN));
        
        // Reset statistik
        $this->comparisons = 0;
        $this->iterations = 0;
        
        $startTime = microtime(true);
        $startMemory = memory_get_usage();
        
        // Binary Search Algorithm
        $result = $this->binarySearch($key);
        
        $endTime = microtime(true);
        $endMemory = memory_get_usage();
        
        // Tampilkan hasil
        echo "\n--------------------------------\n";
        if ($result['found']) {
            echo "✅ Angka " . $key . " ditemukan!\n";
            echo "   Posisi di index ke-" . $result['index'] . "\n";
            echo "   Posisi urutan ke-" . ($result['index'] + 1) . "\n";
        } else {
            echo "❌ Angka " . $key . " tidak ditemukan!\n";
        }
        echo "--------------------------------\n";
        
        // Tampilkan analisis kompleksitas
        $this->tampilkanAnalisisSearching($startTime, $endTime, $startMemory, $endMemory);
    }
    
    /**
     * Implementasi Binary Search
     */
    private function binarySearch($key) {
        $left = 0;
        $right = $this->n - 1;
        $found = false;
        $index = -1;
        
        while ($left <= $right && !$found) {
            $this->iterations++;
            
            $mid = (int) (($left + $right) / 2);
            $this->comparisons++;
            
            if ($this->data[$mid] == $key) {
                $found = true;
                $index = $mid;
            } else if ($key < $this->data[$mid]) {
                $this->comparisons++;
                $right = $mid - 1;
            } else {
                $left = $mid + 1;
            }
        }
        
        return [
            'found' => $found,
            'index' => $index
        ];
    }
    
    /**
     * Tampilkan array
     */
    private function tampilkanArray($arr) {
        echo "[";
        for ($i = 0; $i < count($arr); $i++) {
            echo " " . $arr[$i];
            if ($i < count($arr) - 1) {
                echo ",";
            }
        }
        echo " ]";
    }
    
    /**
     * Tampilkan analisis kompleksitas Sorting
     */
    private function tampilkanAnalisisSorting($startTime, $endTime, $startMemory, $endMemory) {
        $executionTime = ($endTime - $startTime) * 1000; // dalam milliseconds
        $memoryUsed = ($endMemory - $startMemory) / 1024; // dalam KB
        
        echo "\n";
        echo "╔════════════════════════════════════════════╗\n";
        echo "║   ANALISIS KOMPLEKSITAS BUBBLE SORT        ║\n";
        echo "╚════════════════════════════════════════════╝\n";
        
        echo "\n📊 Time Complexity:\n";
        echo "   • Jumlah data (n)      : " . $this->n . "\n";
        echo "   • Total comparisons    : " . $this->comparisons . "\n";
        echo "   • Total swaps          : " . $this->swaps . "\n";
        echo "   • Total iterations     : " . $this->iterations . "\n";
        echo "   • Waktu eksekusi       : " . number_format($executionTime, 4) . " ms\n";
        
        // Hitung kompleksitas teoritis
        $worstCaseOps = ($this->n * ($this->n - 1)) / 2;
        $efficiency = ($this->comparisons / $worstCaseOps) * 100;
        
        echo "\n📈 Analisis:\n";
        echo "   • Worst case operations: " . $worstCaseOps . " (n²)\n";
        echo "   • Actual operations    : " . $this->comparisons . "\n";
        echo "   • Efficiency           : " . number_format($efficiency, 2) . "%\n";
        
        // Tentukan case
        if ($this->comparisons <= $this->n) {
            $case = "Best Case - O(n)";
        } else if ($this->comparisons >= $worstCaseOps * 0.8) {
            $case = "Worst Case - O(n²)";
        } else {
            $case = "Average Case - O(n²)";
        }
        echo "   • Complexity case      : " . $case . "\n";
        
        echo "\n💾 Space Complexity:\n";
        echo "   • Memory used          : " . number_format($memoryUsed, 2) . " KB\n";
        echo "   • Space complexity     : O(1) - In-place sorting\n";
        echo "   • Extra variables      : temp, i, j (~12 bytes)\n";
        
        echo "\n";
    }
    
    /**
     * Tampilkan analisis kompleksitas Searching
     */
    private function tampilkanAnalisisSearching($startTime, $endTime, $startMemory, $endMemory) {
        $executionTime = ($endTime - $startTime) * 1000; // dalam milliseconds
        $memoryUsed = ($endMemory - $startMemory) / 1024; // dalam KB
        
        echo "\n";
        echo "╔════════════════════════════════════════════╗\n";
        echo "║   ANALISIS KOMPLEKSITAS BINARY SEARCH      ║\n";
        echo "╚════════════════════════════════════════════╝\n";
        
        echo "\n📊 Time Complexity:\n";
        echo "   • Jumlah data (n)      : " . $this->n . "\n";
        echo "   • Total comparisons    : " . $this->comparisons . "\n";
        echo "   • Total iterations     : " . $this->iterations . "\n";
        echo "   • Waktu eksekusi       : " . number_format($executionTime, 4) . " ms\n";
        
        // Hitung kompleksitas teoritis
        $maxIterations = (int) ceil(log($this->n, 2));
        
        echo "\n📈 Analisis:\n";
        echo "   • Max iterations (log₂n): " . $maxIterations . "\n";
        echo "   • Actual iterations    : " . $this->iterations . "\n";
        
        // Tentukan case
        if ($this->iterations == 1) {
            $case = "Best Case - O(1)";
        } else {
            $case = "Average/Worst Case - O(log n)";
        }
        echo "   • Complexity case      : " . $case . "\n";
        
        echo "\n💾 Space Complexity:\n";
        echo "   • Memory used          : " . number_format($memoryUsed, 2) . " KB\n";
        echo "   • Space complexity     : O(1) - Iterative approach\n";
        echo "   • Extra variables      : left, right, mid (~16 bytes)\n";
        
        echo "\n";
    }
    
    /**
     * Jalankan program utama
     */
    public function run() {
        echo "\n";
        echo "╔════════════════════════════════════════════╗\n";
        echo "║  PROGRAM SORTING DAN SEARCHING             ║\n";
        echo "║  Bubble Sort & Binary Search               ║\n";
        echo "╚════════════════════════════════════════════╝\n";
        
        do {
            $this->tampilkanMenu();
            
            echo "Masukkan pilihan [1/2/3/4] : ";
            $pilihan = (int) trim(fgets(STDIN));
            
            switch ($pilihan) {
                case 1:
                    $this->inputAngka();
                    break;
                case 2:
                    $this->sorting();
                    break;
                case 3:
                    $this->searching();
                    break;
                case 4:
                    echo "\n✅ Program selesai. Terima kasih!\n\n";
                    break;
                default:
                    echo "\n❌ Pilihan tidak valid! Silakan pilih 1-4.\n";
            }
            
        } while ($pilihan != 4);
    }
}

// Jalankan program
$program = new SortingSearching();
$program->run();
