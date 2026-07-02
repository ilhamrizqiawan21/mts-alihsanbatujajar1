<?php

namespace Tests\Feature;

use Tests\TestCase;

class ModuleControllersTest extends TestCase
{
    public function test_siswa_index_route_returns_success(): void
    {
        $response = $this->get('/siswa');

        $response->assertStatus(200);
    }
}
