<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

use App\Models\User;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
       
        $credentials = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $credentials);
        
        $response->assertJsonStructure([
            'token',
        ])->assertStatus(Response::HTTP_OK);
    }

    public function test_user_can_register(): void
    {         
        $userData = [
            'name' => 'Test User',
            'email' => 'test@exampaale.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);
        //dd($response);
        $response->assertJsonStructure([
            'token',
        ])->assertStatus(Response::HTTP_CREATED);
    }

    public function test_user_can_logout(): void
    {         
        Sanctum::actingAs(User::factory()->create());

        $response = $this->get('/api/logout');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    
    }
}
