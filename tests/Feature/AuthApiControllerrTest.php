<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class AuthApiControllerrTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registration()
    {
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'access_token', 'token_type']);
    }

    public function test_user_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'accessToken', 'token_type', 'user']);
    }

    public function test_user_logout()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Has cerrado tu session correctamente']);
    }
}
