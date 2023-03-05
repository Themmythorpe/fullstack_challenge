<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class WeatherTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetUsersReturnsData(): void
    {
        User::factory(20)->create();

        // Select a random user
        $user = User::inRandomOrder()->first();

        // Make a request to the getUsers endpoint
        $response = $this->get('/');

        // Assert that the response has a success status code
        $response->assertStatus(200);

        // Assert that the response contains the test user's data
        $response->assertJsonFragment([
            'name' => $user->name,
            'email' => $user->email,
            'latitude' => $user->latitude,
            'longitude' => $user->longitude,
        ]);
    }

    public function testGetWeatherReturnsData()
    {
        User::factory(20)->create();

        // Select a random user
        $randomUser = User::inRandomOrder()->first();

        // Call the getWeather method for the test user
        $response = $this->get("/weather/{$randomUser->id}");

        // Check that the response is successful and contains the expected weather data
        $response->assertOk();
        $response->assertJsonStructure([
            'coord',
            'weather',
            'base',
            'main',
            'visibility',
            'wind',
            'clouds',
            'dt',
            'sys',
            'timezone',
            'id',
            'name',
            'cod',
        ]);
    }
}
