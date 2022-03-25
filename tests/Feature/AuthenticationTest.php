<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginMustEnterEmailAndPassword()
    {
        $this->json('POST', 'api/auth/login')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }

    public function testLoginSuccessfull()
    {
        $loginData = ['email' => 'user1@gmail.com', 'password' => 'password'];

        $this->json('POST', 'api/auth/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "access_token",
                "token_type",
                "expires_in",
                "user" => [
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
            ],
            ]);

        $this->assertAuthenticated();
    }

    public function testLoginFailed()
    {
        $loginData = ['email' => 'user1@gmail.com', 'password' => 'password1'];

        $this->json('POST', 'api/auth/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "success" => false,
                "message" => "Your Email or password is wrong",
            ]);
    }
}
