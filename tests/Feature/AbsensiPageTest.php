<?php

namespace Tests\Feature;

use Tests\TestCase;

class AbsensiPageTest extends TestCase
{
    public function test_absensi_page_renders_grid_interface(): void
    {
        $response = $this->withSession([
            'user_id' => 1,
            'user_name' => 'Admin',
        ])->get('/absensi?kelas_id=1&bulan=7');

        $response->assertStatus(200);
        $response->assertSee('Pilih Kelas');
        $response->assertSee('Bulk Action');
        $response->assertSee('Export PDF');
    }
}
