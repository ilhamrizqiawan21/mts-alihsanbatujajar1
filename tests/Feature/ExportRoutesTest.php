<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExportRoutesTest extends TestCase
{
    public function test_pelanggaran_export_routes_return_files(): void
    {
        $pdfResponse = $this->withSession(['user_id' => 1])->get('/pelanggaran/export-pdf');
        $pdfResponse->assertOk();
        $pdfResponse->assertHeader('content-type', 'application/pdf');

        $xlsxResponse = $this->withSession(['user_id' => 1])->get('/pelanggaran/export-xlsx');
        $xlsxResponse->assertOk();
        $xlsxResponse->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}
