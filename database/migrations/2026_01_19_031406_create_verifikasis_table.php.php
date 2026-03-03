<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('verifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporans')->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->enum('status', ['diterima', 'ditolak']);
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasis');
    }
};
