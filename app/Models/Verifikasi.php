<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'laporan_id',
        'admin_id',
        'status',
        'catatan',
        'tanggal_verifikasi'
    ];

    protected $casts = [
        'tanggal_verifikasi' => 'datetime',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    // Tambahkan relasi ke admin
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}