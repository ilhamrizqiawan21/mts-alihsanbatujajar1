<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran');
            $table->string('nama_prestasi', 200);
            $table->foreignId('tingkat_prestasi_id')->constrained('tingkat_prestasi');
            $table->string('juara', 50)->nullable();
            $table->date('tanggal');
            $table->string('penyelenggara', 150)->nullable();
            $table->string('foto', 255)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['siswa_id', 'tanggal']);
            $table->index(['tahun_ajaran_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};
