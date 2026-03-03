<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_id',
        'petugas_id',
        'tindakan',
        'foto_sebelum',
        'foto_sesudah',
        'tanggal_perbaikan',
        'status',
    ];

    protected $casts = [
        'tanggal_perbaikan' => 'date',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}