<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pelanggan',
        'nama_pelanggan',
        'alamat',
        'no_telepon',
        'email',
        'id_daya_listrik',
        'id_user',
        'tanggal_registrasi',
        'status'
    ];

    protected $casts = [
        'tanggal_registrasi' => 'date',
    ];

    /**
     * Relasi ke DayaListrik
     */
    public function dayaListrik()
    {
        return $this->belongsTo(DayaListrik::class, 'id_daya_listrik', 'id_daya_listrik');
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke Penggunaan
     */
    public function penggunaan()
    {
        return $this->hasMany(Penggunaan::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Relasi ke Tagihan
     */
    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Generate ID Pelanggan otomatis
     */
    public static function generateIdPelanggan()
    {
        $lastPelanggan = self::orderBy('id_pelanggan', 'desc')->first();
        
        if (!$lastPelanggan) {
            return 'PEL001';
        }
        
        $lastNumber = (int) substr($lastPelanggan->id_pelanggan, 3);
        $newNumber = $lastNumber + 1;
        
        return 'PEL' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
