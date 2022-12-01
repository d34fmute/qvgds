<?php

namespace Tests\Feature;



use Illuminate\Support\Facades\Session;
use QVGDS\Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->getJson('/api/games');

        $response->assertStatus(200);
        $response->assertContent("[]");
    }
}
