<?php


// use Illuminate\Foundation\Testing\RefreshDatabase;


class ExampleTest
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
