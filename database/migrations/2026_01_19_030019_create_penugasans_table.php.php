<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penugasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporans')->cascadeOnDelete();
            $table->foreignId('petugas_id')->constrained('petugas')->cascadeOnDelete();
            $table->date('tanggal_tugas');
            $table->enum('status', ['ditugaskan', 'proses', 'selesai'])->default('ditugaskan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penugasans');
    }
};
