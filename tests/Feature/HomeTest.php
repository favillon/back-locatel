<?php

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_validation_home_up(): void
    {
        $response = $this->get('/');

        $response->assertStatus(Response::HTTP_OK);
    }
}
