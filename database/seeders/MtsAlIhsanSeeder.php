<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MtsAlIhsanSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $this->seedTahunAjaran();
            $this->seedKelas();
            $this->seedUsers();
            $this->seedSiswa();
            $this->seedJenisPelanggaran();
            $this->seedTingkatPrestasi();
            $this->seedOperationalData();
        });
    }

    private function seedTahunAjaran(): void
    {
        DB::table('tahun_ajaran')->update(['is_aktif' => false]);

        foreach ([
            ['tahun' => '2024/2025', 'semester' => '2', 'is_aktif' => false],
            ['tahun' => '2025/2026', 'semester' => '2', 'is_aktif' => true],
        ] as $year) {
            DB::table('tahun_ajaran')->updateOrInsert(
                ['tahun' => $year['tahun'], 'semester' => $year['semester']],
                ['is_aktif' => $year['is_aktif']]
            );
        }
    }

    private function seedKelas(): void
    {
        foreach ([
            ['VII-A', 'Astri Yuliasari, S.Pd.'],
            ['VII-B', 'Deni Kurniawan, S.Pd.'],
            ['VIII-A', 'Siti Aminah, S.Pd.'],
            ['VIII-B', 'Rizky Maulana, S.Pd.'],
            ['IX-A', 'Nia Kurniati, S.Pd.'],
            ['IX-B', 'Agus Setiawan, S.Pd.'],
        ] as [$nama, $wali]) {
            DB::table('kelas')->updateOrInsert(
                ['nama_kelas' => $nama],
                ['wali_kelas' => $wali]
            );
        }
    }

    private function seedUsers(): void
    {
        foreach ([
            ['Administrator', 'admin', 'admin'],
            ['Guru BK', 'guru', 'guru'],
        ] as [$nama, $username, $role]) {
            DB::table('users')->updateOrInsert(
                ['username' => $username],
                [
                    'nama' => $nama,
                    'password' => Hash::make('password'),
                    'role' => $role,
                    'status' => true,
                ]
            );
        }
    }

    private function seedSiswa(): void
    {
        $kelas = DB::table('kelas')->pluck('id', 'nama_kelas');

        $students = [
            ['7101', 'ALIFIA NUR FAIZAH', 'VII-A', 'P'],
            ['7102', 'AHMAD FAUZI', 'VII-A', 'L'],
            ['7103', 'NADIA PUTRI', 'VII-A', 'P'],
            ['7104', 'RIZAL HIDAYAT', 'VII-B', 'L'],
            ['7105', 'SALSABILA NUR AINI', 'VII-B', 'P'],
            ['8101', 'MUHAMMAD RAFI', 'VIII-A', 'L'],
            ['8102', 'NURUL AULIA', 'VIII-A', 'P'],
            ['8103', 'FARHAN MAULANA', 'VIII-B', 'L'],
            ['8104', 'AISYAH RAMADANI', 'VIII-B', 'P'],
            ['9101', 'DANI SAPUTRA', 'IX-A', 'L'],
            ['9102', 'SALMA AZZAHRA', 'IX-A', 'P'],
            ['9103', 'ILHAM NURFALAH', 'IX-B', 'L'],
        ];

        foreach ($students as [$nis, $nama, $namaKelas, $jk]) {
            DB::table('siswa')->updateOrInsert(
                ['nis' => $nis],
                [
                    'nama' => $nama,
                    'kelas_id' => $kelas[$namaKelas],
                    'jenis_kelamin' => $jk,
                    'status' => true,
                ]
            );
        }
    }

    private function seedJenisPelanggaran(): void
    {
        foreach ([
            ['Tidak Membawa Alat Sholat', 5],
            ['Tidak Membawa Juz Amma', 5],
            ['Terlambat Masuk Sekolah', 3],
            ['Tidak Memakai Atribut Lengkap', 3],
            ['Tidak Menjaga Kebersihan', 2],
        ] as [$nama, $poin]) {
            DB::table('jenis_pelanggaran')->updateOrInsert(
                ['nama' => $nama],
                ['poin' => $poin]
            );
        }
    }

    private function seedTingkatPrestasi(): void
    {
        foreach (['Sekolah', 'Kecamatan', 'Kabupaten', 'Provinsi', 'Nasional'] as $nama) {
            DB::table('tingkat_prestasi')->updateOrInsert(['nama' => $nama], []);
        }
    }

    private function seedOperationalData(): void
    {
        $tahunAjaranId = DB::table('tahun_ajaran')
            ->where('tahun', '2025/2026')
            ->where('semester', '2')
            ->value('id');
        $siswa = DB::table('siswa')->pluck('id', 'nis');
        $kelas = DB::table('kelas')->pluck('id', 'nama_kelas');
        $jenis = DB::table('jenis_pelanggaran')->pluck('id', 'nama');
        $tingkat = DB::table('tingkat_prestasi')->pluck('id', 'nama');

        foreach ([
            ['7101', '2026-05-04', 'H'],
            ['7102', '2026-05-04', 'I'],
            ['8101', '2026-05-04', 'H'],
            ['9101', '2026-05-04', 'S'],
        ] as [$nis, $tanggal, $status]) {
            DB::table('absensi')->updateOrInsert(
                ['siswa_id' => $siswa[$nis], 'tanggal' => $tanggal],
                ['tahun_ajaran_id' => $tahunAjaranId, 'status' => $status, 'keterangan' => null]
            );
        }

        DB::table('pelanggaran')->updateOrInsert(
            [
                'siswa_id' => $siswa['7102'],
                'tahun_ajaran_id' => $tahunAjaranId,
                'jenis_pelanggaran_id' => $jenis['Tidak Membawa Juz Amma'],
                'tanggal' => '2026-05-05',
            ],
            ['keterangan' => 'Dicatat oleh guru piket.']
        );

        DB::table('keterlambatan')->updateOrInsert(
            ['siswa_id' => $siswa['8101'], 'tanggal' => '2026-05-06'],
            [
                'tahun_ajaran_id' => $tahunAjaranId,
                'jam_datang' => '07:18:00',
                'alasan' => 'Kendala kendaraan',
                'keterangan' => null,
            ]
        );

        DB::table('surat_izin')->updateOrInsert(
            ['siswa_id' => $siswa['9101'], 'tanggal' => '2026-05-07', 'jenis_izin' => 'biasa'],
            [
                'tahun_ajaran_id' => $tahunAjaranId,
                'jam_berangkat' => null,
                'alasan_pulang' => null,
                'alasan_biasa' => 'Mengikuti kegiatan keluarga.',
                'keterangan' => null,
            ]
        );

        DB::table('kebersihan_kelas')->updateOrInsert(
            ['kelas_id' => $kelas['VII-A'], 'tahun_ajaran_id' => $tahunAjaranId, 'tanggal' => '2026-05-08'],
            [
                'nilai_lantai' => 5,
                'nilai_sampah' => 4,
                'nilai_rak' => 5,
                'nilai_penataan' => 4,
                'nilai_total' => 18,
                'keterangan' => 'Kondisi kelas baik.',
            ]
        );

        DB::table('prestasi')->updateOrInsert(
            ['siswa_id' => $siswa['7103'], 'nama_prestasi' => 'Juara Tahfidz Juz Amma', 'tanggal' => '2026-05-10'],
            [
                'tahun_ajaran_id' => $tahunAjaranId,
                'tingkat_prestasi_id' => $tingkat['Kecamatan'],
                'juara' => 'Juara 2',
                'penyelenggara' => 'Kecamatan Batujajar',
                'foto' => null,
                'keterangan' => 'Lomba tahfidz tingkat kecamatan.',
            ]
        );
    }
}
