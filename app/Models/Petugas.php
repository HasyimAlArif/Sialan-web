<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Petugas extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'wilayah',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function penugasans()
    {
        return $this->hasMany(Penugasan::class);
    }

    public function perbaikans()
    {
        return $this->hasMany(Perbaikan::class);
    }
}