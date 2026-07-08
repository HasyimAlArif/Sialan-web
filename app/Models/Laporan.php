<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelapor',
        'no_hp',
        'judul',
        'deskripsi',
        'foto',
        'tampil_galeri',
        'latitude',
        'longitude',
        'alamat_lokasi',
        'status',
        'admin_id',
        'petugas_id',
    ];

    protected $casts = [
        'latitude'      => 'decimal:7',
        'longitude'     => 'decimal:7',
        'tampil_galeri' => 'boolean',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }

    public function verifikasi()
    {
        return $this->hasOne(Verifikasi::class);
    }

    public function penugasan()
    {
        return $this->hasOne(Penugasan::class);
    }
    public function perbaikan()
{
    return $this->hasOne(Perbaikan::class);
}
}