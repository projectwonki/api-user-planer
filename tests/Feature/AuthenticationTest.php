<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function testRegisterMustEnterEmailAndPassword()
    {
        $this->json('POST', 'api/auth/register')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    'name' => ["The name field is required."],
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }

    public function testRegisterSuccessfull()
    {
        $loginData = ['name' => 'user5', 'email' => 'user5@gmail.com', 'password' => 'password5'];

        $this->json('POST', 'api/auth/register', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                "message" => "Register Successfully",
            ]);
    }

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
        $loginData = ['email' => 'user1@gmail.com', 'password' => 'password1'];

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
        $loginData = ['email' => 'user1@gmail.com', 'password' => 'password'];

        $this->json('POST', 'api/auth/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "success" => false,
                "message" => "Your Email or password is wrong",
            ]);
    }
}
