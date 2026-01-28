<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayaListrik extends Model
{
    protected $table = 'daya_listrik';
    protected $primaryKey = 'id_daya_listrik';
    public $timestamps = false;

    protected $fillable = [
        'daya_watt',
        'id_tarif',
        'keterangan'
    ];

    /**
     * Relasi ke Tarif
     */
    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'id_tarif', 'id_tarif');
    }

    /**
     * Relasi ke Pelanggan
     */
    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'id_daya_listrik', 'id_daya_listrik');
    }
}
