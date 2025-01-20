<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['token']);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_login_fails_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'error@gmail.com',
            'password' => '1234567',
        ]);

        $response->assertStatus(401)
            ->assertJson(['error' => 'Credenciales inválidas.']);
    }
}
