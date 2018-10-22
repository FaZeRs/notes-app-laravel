<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PassportTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_get_details()
    {
        $this->login();
        $response = $this->getJson('/api/details');
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'notes',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_logout()
    {
        $this->login();
        $response = $this->getJson('/api/logout');
        $response->assertSuccessful();
    }

    public function test_guest_cannot_see_details()
    {
        $response = $this->getJson('/api/details');
        $response->assertStatus(401);
    }
}