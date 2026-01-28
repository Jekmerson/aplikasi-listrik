<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggunaan extends Model
{
    protected $table = 'penggunaan';
    protected $primaryKey = 'id_penggunaan';

    protected $fillable = [
        'id_pelanggan',
        'bulan',
        'tahun',
        'meter_awal',
        'meter_akhir',
        'tanggal_catat'
    ];

    protected $casts = [
        'tanggal_catat' => 'datetime',
    ];

    /**
     * Accessor untuk total_kwh (computed column)
     */
    public function getTotalKwhAttribute()
    {
        return $this->meter_akhir - $this->meter_awal;
    }

    /**
     * Relasi ke Pelanggan
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Relasi ke Tagihan
     */
    public function tagihan()
    {
        return $this->hasOne(Tagihan::class, 'id_penggunaan', 'id_penggunaan');
    }

    /**
     * Scope untuk filter berdasarkan periode
     */
    public function scopePeriode($query, $bulan, $tahun)
    {
        return $query->where('bulan', $bulan)->where('tahun', $tahun);
    }

    /**
     * Format periode untuk display
     */
    public function getPeriodeAttribute()
    {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        return $namaBulan[$this->bulan] . ' ' . $this->tahun;
    }
}
