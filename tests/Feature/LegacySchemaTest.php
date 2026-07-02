<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LegacySchemaTest extends TestCase
{
    public function test_legacy_tables_are_available(): void
    {
        $tables = DB::connection()->select('SHOW TABLES');
        $tableNames = array_map(function ($table) {
            return current((array) $table);
        }, $tables);

        $required = ['siswa', 'kelas', 'tahun_ajaran', 'absensi', 'pelanggaran', 'kebersihan_kelas'];

        foreach ($required as $table) {
            $this->assertContains($table, $tableNames);
        }
    }
}
