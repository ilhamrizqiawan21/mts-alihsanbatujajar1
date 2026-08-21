<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kebersihan_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran');
            $table->date('tanggal');
            $table->unsignedTinyInteger('nilai_lantai')->default(0);
            $table->unsignedTinyInteger('nilai_sampah')->default(0);
            $table->unsignedTinyInteger('nilai_rak')->default(0);
            $table->unsignedTinyInteger('nilai_penataan')->default(0);
            $table->unsignedTinyInteger('nilai_total')->virtualAs('nilai_lantai + nilai_sampah + nilai_rak + nilai_penataan');
            $table->string('keterangan', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['kelas_id', 'tanggal']);
            $table->index(['tahun_ajaran_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kebersihan_kelas');
    }
};
