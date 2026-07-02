<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteAccessTest extends TestCase
{
    public function test_guest_visiting_home_is_redirected_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }
}
