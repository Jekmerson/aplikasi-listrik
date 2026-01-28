<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'level';
    protected $primaryKey = 'id_level';
    public $timestamps = false;

    protected $fillable = [
        'nama_level',
        'deskripsi'
    ];

    /**
     * Relasi ke User
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_level', 'id_level');
    }
}
