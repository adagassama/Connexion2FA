<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    public function testSqlInjectionLogin()
    {
        // Create Test User
        $user = User::factory()->create([
            'name' => 'User Test',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Attempt to connect with an SQL injection
        $response = $this->postJson('/login',[
            'email' => 'test@example.com',
            'password' => "' OR '1'='1",
        ]);

        // Vérification that the connection attempt fails
        $response->assertStatus(404);
    }
}
