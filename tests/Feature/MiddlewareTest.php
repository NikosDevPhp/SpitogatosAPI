<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class MiddlewareTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * Assert custom middleware headers (must be removed if middleware is removed)
     */
    public function testMiddlewareHeaders()
    {
        $response = $this->json('POST', '/api/search');
        $response->assertHeader('Access-Control-Allow-Origin');
        $response->assertHeader('Access-Control-Allow-Methods');

    }
}
