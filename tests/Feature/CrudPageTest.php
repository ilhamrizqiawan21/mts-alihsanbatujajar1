<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Siswa;
use Tests\TestCase;

class CrudPageTest extends TestCase
{
    public function test_siswa_detail_and_edit_pages_render(): void
    {
        $kelas = Kelas::query()->firstOrCreate(['nama_kelas' => 'VII-A']);
        $siswa = Siswa::query()->firstOrCreate(
            ['nis' => '1001'],
            [
                'nama' => 'Ahmad',
                'kelas_id' => $kelas->id,
                'jenis_kelamin' => 'L',
                'status' => true,
            ]
        );

        $detailResponse = $this->get(route('siswa.show', $siswa));
        $detailResponse->assertStatus(200);

        $editResponse = $this->get(route('siswa.edit', $siswa));
        $editResponse->assertStatus(200);
    }

    public function test_kelas_detail_and_edit_pages_render(): void
    {
        $kelas = Kelas::create(['nama_kelas' => 'VIII-B', 'wali_kelas' => 'Bu Siti']);

        $detailResponse = $this->get(route('kelas.show', $kelas));
        $detailResponse->assertStatus(200);

        $editResponse = $this->get(route('kelas.edit', $kelas));
        $editResponse->assertStatus(200);
    }
}
