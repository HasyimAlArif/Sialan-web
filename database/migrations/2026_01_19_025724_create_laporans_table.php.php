<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();

            // DATA PELAPOR
            $table->string('nama_pelapor');
            $table->string('no_hp');

            // DATA LAPORAN
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('foto')->nullable();

            // LOKASI
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('alamat_lokasi');

            // STATUS (SATU KALI SAJA)
            $table->enum('status', ['menunggu', 'diverifikasi', 'ditolak', 'ditugaskan', 'proses', 'selesai', 'acc'])
                  ->default('menunggu');

            // RELASI
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();

            $table->foreignId('petugas_id')
                ->nullable()
                ->constrained('petugas')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
