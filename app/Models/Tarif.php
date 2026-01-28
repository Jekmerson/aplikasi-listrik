<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $table = 'tarif';
    protected $primaryKey = 'id_tarif';
    public $timestamps = false;

    protected $fillable = [
        'nama_tarif',
        'tarif_per_kwh',
        'biaya_beban',
        'berlaku_dari',
        'berlaku_sampai',
        'keterangan'
    ];

    protected $casts = [
        'tarif_per_kwh' => 'decimal:2',
        'biaya_beban' => 'decimal:2',
        'berlaku_dari' => 'date',
        'berlaku_sampai' => 'date',
    ];

    /**
     * Relasi ke DayaListrik
     */
    public function dayaListrik()
    {
        return $this->hasMany(DayaListrik::class, 'id_tarif', 'id_tarif');
    }
}
