<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';

    protected $fillable = [
        'id_penggunaan',
        'id_pelanggan',
        'total_tagihan',
        'tanggal_tagihan',
        'jatuh_tempo',
        'status_bayar',
        'denda'
    ];

    protected $casts = [
        'total_tagihan' => 'decimal:2',
        'denda' => 'decimal:2',
        'tanggal_tagihan' => 'datetime',
        'jatuh_tempo' => 'date',
    ];

    /**
     * Relasi ke Penggunaan
     */
    public function penggunaan()
    {
        return $this->belongsTo(Penggunaan::class, 'id_penggunaan', 'id_penggunaan');
    }

    /**
     * Relasi ke Pelanggan
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Relasi ke Pembayaran
     */
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_tagihan', 'id_tagihan');
    }

    /**
     * Scope untuk tagihan belum bayar
     */
    public function scopeBelumBayar($query)
    {
        return $query->where('status_bayar', 'Belum Bayar');
    }

    /**
     * Scope untuk tagihan sudah bayar
     */
    public function scopeSudahBayar($query)
    {
        return $query->where('status_bayar', 'Sudah Bayar');
    }

    /**
     * Scope untuk tagihan terlambat
     */
    public function scopeTerlambat($query)
    {
        return $query->where('status_bayar', 'Terlambat');
    }

    /**
     * Check apakah tagihan sudah lewat jatuh tempo
     */
    public function getIsLewatJatuhTempoAttribute()
    {
        return now()->greaterThan($this->jatuh_tempo) && $this->status_bayar == 'Belum Bayar';
    }

    /**
     * Hitung total yang harus dibayar (tagihan + denda)
     */
    public function getTotalBayarAttribute()
    {
        return $this->total_tagihan + $this->denda;
    }
}
