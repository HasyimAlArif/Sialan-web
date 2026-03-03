<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_id',
        'petugas_id',
        'tanggal_tugas',
        'alamat_lokasi',
        'status',
    ];

    protected $casts = [
        'tanggal_tugas' => 'date',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
    public function perbaikan()
{
    return $this->hasOne(Perbaikan::class, 'laporan_id', 'laporan_id');
}
}