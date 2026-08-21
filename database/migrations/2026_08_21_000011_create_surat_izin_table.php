<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_izin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran');
            $table->enum('jenis_izin', ['pulang', 'biasa']);
            $table->date('tanggal');
            $table->time('jam_berangkat')->nullable();
            $table->enum('alasan_pulang', ['sakit', 'keluarga', 'lomba', 'lainnya'])->nullable();
            $table->text('alasan_biasa')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['siswa_id', 'tanggal']);
            $table->index(['tahun_ajaran_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_izin');
    }
};
