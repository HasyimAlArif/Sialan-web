<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('perbaikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporans')->cascadeOnDelete();
            $table->foreignId('petugas_id')->constrained('petugas')->cascadeOnDelete();
            $table->text('tindakan');
            $table->string('foto_sebelum')->nullable();
            $table->string('foto_sesudah')->nullable();
            $table->date('tanggal_perbaikan');
            $table->enum('status', ['proses', 'selesai','acc'])->default('proses');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perbaikans');
    }
};
