<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'email',
        'id_level',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relasi ke Level
     */
    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'id_level');
    }

    /**
     * Relasi ke Pelanggan
     */
    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id_user', 'id_user');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->level->nama_level === 'Admin';
    }

    /**
     * Check if user is operator
     */
    public function isOperator()
    {
        return $this->level->nama_level === 'Operator';
    }

    /**
     * Check if user is pelanggan
     */
    public function isPelanggan()
    {
        return $this->level->nama_level === 'Pelanggan';
    }
}

