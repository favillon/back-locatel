<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    public function test_get_data_user_login(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->get('/api/profile');
        //dd($response);
        $response   ->assertJsonCount(4, 'data')
                    ->assertJsonStructure([
                        'data' => [
                            'name',
                            'email',
                            'identification',
                            'account' 
                        ]
                    ])
                    ->assertStatus(Response::HTTP_OK);
    }
}
