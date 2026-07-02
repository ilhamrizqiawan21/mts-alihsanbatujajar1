<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Database\Seeder;

class MtsAlIhsanSeeder extends Seeder
{
    public function run(): void
    {
        $tahun = TahunAjaran::create([
            'tahun' => '2025/2026',
            'semester' => '2',
            'is_aktif' => true,
        ]);

        $kelas = Kelas::create([
            'nama_kelas' => 'VII-A',
            'wali_kelas' => 'Astri Yuliasari, S.Pd.',
        ]);

        $siswa = Siswa::create([
            'nis' => '7101',
            'nama' => 'Alifia Nur Faizah',
            'kelas_id' => $kelas->id,
            'jenis_kelamin' => 'P',
            'status' => true,
        ]);

        Absensi::create([
            'siswa_id' => $siswa->id,
            'tahun_ajaran_id' => $tahun->id,
            'tanggal' => now()->toDateString(),
            'status' => 'H',
            'keterangan' => 'Masuk',
        ]);

        $jenisPelanggaran = \DB::table('jenis_pelanggaran')->insertGetId([
            'nama' => 'Tidak Membawa Juz Amma',
            'poin' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Pelanggaran::create([
            'siswa_id' => $siswa->id,
            'tahun_ajaran_id' => $tahun->id,
            'jenis_pelanggaran_id' => $jenisPelanggaran,
            'tanggal' => now()->toDateString(),
            'keterangan' => 'Contoh data awal',
        ]);

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
