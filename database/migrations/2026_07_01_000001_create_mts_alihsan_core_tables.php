<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahun_ajaran', function (Blueprint $table) {
            $table->id();
            $table->string('tahun', 9);
            $table->enum('semester', ['1', '2']);
            $table->boolean('is_aktif')->default(false);
            $table->timestamps();
            $table->index(['tahun', 'semester']);
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas', 20);
            $table->string('wali_kelas', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 20)->unique();
            $table->string('nama', 100);
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp_ortu', 20)->nullable();
            $table->string('foto', 255)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->index(['kelas_id', 'status']);
        });

        Schema::create('jenis_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->integer('poin')->default(1);
            $table->timestamps();
        });

        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran');
            $table->date('tanggal');
            $table->enum('status', ['H', 'I', 'S', 'A'])->default('H');
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
            $table->unique(['siswa_id', 'tanggal'], 'unique_absensi');
            $table->index(['tahun_ajaran_id', 'tanggal']);
        });

        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran');
            $table->foreignId('jenis_pelanggaran_id')->constrained('jenis_pelanggaran');
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->index(['siswa_id', 'tanggal']);
            $table->index(['tahun_ajaran_id', 'tanggal']);
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'guru', 'kepala_sekolah', 'siswa'])->default('admin');
            $table->boolean('status')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('pelanggaran');
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('jenis_pelanggaran');
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('tahun_ajaran');
    }
};
