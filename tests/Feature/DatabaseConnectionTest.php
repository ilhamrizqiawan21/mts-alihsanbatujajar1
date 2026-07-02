<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    public function test_application_uses_the_legacy_mysql_database(): void
    {
        $this->assertSame('mysql', config('database.default'));
        $this->assertSame('mts_alihsan', DB::connection()->getDatabaseName());
    }
}
