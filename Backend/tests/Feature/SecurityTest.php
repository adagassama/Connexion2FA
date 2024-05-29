<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    public function testSqlInjectionRegister()
    {
        // Attempt to register with SQL injection in the email

        $response = $this->postJson('/register',[
            'name' => 'Test User',
            'email' => "' OR '1'='1",
            'password' => Hash::make('password123'),
        ]);

        // Verification that inscription attempt fails

        $response->assertStatus(404);
    }

    public function testSqlInjectionLogin()
    {
        $randomEmail = 'user'.mt_rand(1,999).'@example.com';
        // Create Test User
        $user = User::factory()->create([
            'name' => 'User Test',
            'email' => $randomEmail,
            'password' => Hash::make('password123'),
        ]);

        // Attempt to connect with an SQL injection
        $response = $this->postJson('/login',[
            'email' => $randomEmail,
            'password' => "' OR '1'='1",
        ]);

        // Verification that the connection attempt fails
        $response->assertStatus(404);
    }
}
