<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ApiTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * Empty required data route
     */
    public function testSearchRouteWithEmptyData()
    {
        $response = $this->json('POST', '/api/search');
        $response->assertStatus(400);
    }

    /**
     * All required data with not possible availability to generate empty response
     */
    public function testSearchRouteForEmptyResponse()
    {
        // if we used lexify in availability there is a chance the test fails sometime
        $response = $this->post('/api/search', ['availability' => 'somethingUgly', 'location' => $this->faker->lexify('?????')]);

        $response->assertStatus(200);
        $response->assertExactJson(['data' => []]);
    }

    /**
     * Empty location specific response
     */
    public function testSearchRouteWithEmptyRequiredLocation()
    {
        $response = $this->post('/api/search', ['availability' => 'somethingUgly']);

        $response->assertStatus(400);
        $response->assertSee('The location field is required.');
    }

    /**
     * Empty availability specific response
     */
    public function testSearchRouteWithEmptyRequiredAvailability()
    {
        $response = $this->post('/api/search', ['location' => 'somethingUgly']);

        $response->assertStatus(400);
        $response->assertSee('The availability field is required.');
    }

    public function testSearchRouteWithInvalidMinPrice()
    {
        $response = $this->post('/api/search', [
            'location' => $this->faker->lexify('?????'),
            'availability' => $this->faker->lexify('?????'),
            'min_price' => $this->faker->lexify('????')
        ]);

        $response->assertStatus(400);
        $response->assertSee('The min price must be a number.');
    }

    public function testSearchRouteWithInvalidMaxPrice()
    {
        $response = $this->post('/api/search', [
            'location' => $this->faker->lexify('?????'),
            'availability' => $this->faker->lexify('?????'),
            'max_price' => $this->faker->lexify('????')
        ]);

        $response->assertStatus(400);
        $response->assertSee('The max price must be a number.');
    }

    public function testSearchRouteWithInvalidMinSquareMeters()
    {
        $response = $this->post('/api/search', [
            'location' => $this->faker->lexify('?????'),
            'availability' => $this->faker->lexify('?????'),
            'min_square_meters' => $this->faker->lexify('????')
        ]);

        $response->assertStatus(400);
        $response->assertSee('The min square meters must be a number.');
    }

    public function testSearchRouteWithInvalidMaxSquareMeters()
    {
        $response = $this->post('/api/search', [
            'location' => $this->faker->lexify('?????'),
            'availability' => $this->faker->lexify('?????'),
            'max_square_meters' => $this->faker->lexify('????')
        ]);

        $response->assertStatus(400);
        $response->assertSee('The max square meters must be a number.');
    }

}

