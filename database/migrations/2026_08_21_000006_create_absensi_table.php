<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran');
            $table->date('tanggal');
            $table->enum('status', ['H', 'I', 'S', 'A'])->default('H');
            $table->string('keterangan', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['siswa_id', 'tanggal'], 'unique_absensi');
            $table->index(['tahun_ajaran_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
