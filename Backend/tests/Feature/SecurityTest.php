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
    //use RefreshDatabase;
    public function testSqlInjectionRegister()
    {
        // Attempt to register with SQL injection in the email

        $response = $this->postJson('/api/register',[
            'name' => 'Test User Register',
            'email' => "' OR '1'='1",
            'password' => Hash::make('password123'),
        ]);

        // Verification that inscription attempt fails

        $response->assertStatus(422);
    }

    public function testSqlInjectionLogin()
    {
        $randomEmail = 'user'.mt_rand(1,999).'@example.com';
        // Create Test User
        $user = User::factory()->create([
            'name' => 'User Test Login',
            'email' => $randomEmail,
            'password' => Hash::make('password123'),
        ]);

        // Attempt to connect with an SQL injection
        $response = $this->postJson('/api/login',[
            'email' => $randomEmail,
            'password' => "' OR '1'='1",
        ]);

        // Verification that the connection attempt fails
        $response->assertStatus(401);
    }
}
