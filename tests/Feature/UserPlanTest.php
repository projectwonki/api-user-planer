<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserPlanTest extends TestCase
{
    public function testUserPlanListingWithoutAuthorization()
    {
        //truncate data user
        $truncate_user_plan = Plan::truncate();

        $this->json('GET', 'api/user/plan')
            ->assertStatus(401);
    }

    public function testUserPlanListingWithAuthorization()
    {
        $headers = [];

        $email_user = 'user1@gmail.com';

        if (!is_null($email_user)) {

            $token = auth()->guard('api')->login(User::whereEmail($email_user)->first());

            $headers['Authorization'] = 'Bearer ' . $token;

        }

        $params = [];

        $this->json('GET', 'api/user/plan', $params, $headers)->assertStatus(200);

    }

    public function testUserPlanDetailWithoutAuthorization()
    {
        $this->json('GET', 'api/user/plan/1')
            ->assertStatus(401);
    }

    public function testUserPlanDetailWithAuthorization()
    {
        $headers = [];

        $email_user = 'user1@gmail.com';

        if (!is_null($email_user)) {

            $token = auth()->guard('api')->login(User::whereEmail($email_user)->first());

            $headers['Authorization'] = 'Bearer ' . $token;

        }

        $params = [];

        $this->json('GET', 'api/user/plan/1', $params, $headers)->assertStatus(200);
    }

    public function testUserPlanStoreWithoutAuthorization()
    {
        $this->json('POST', 'api/user/plan')
            ->assertStatus(401);
    }

    public function testUserPlanStoreWithAuthorization()
    {
        $headers = [];

        $email_user = 'user1@gmail.com';

        if (!is_null($email_user)) {

            $token = auth()->guard('api')->login(User::whereEmail($email_user)->first());

            $headers['Authorization'] = 'Bearer ' . $token;

        }

        $params = [
            'title' => 'testing Plan 1', 
            'origin' => 'Medan', 
            'destination' => 'Solo', 
            'type' => 'one-day', 
            'start_date' => '2022-04-02', 
            'end_date' => '2022-04-03', 
            'description' => 'testing create Plan 1', 
        ];

        $this->json('POST', 'api/user/plan', $params, $headers)->assertStatus(200);
    }

    public function testUserPlanUpdateWithoutAuthorization()
    {
        $this->json('PUT', 'api/user/plan/1')
            ->assertStatus(401);
    }

    public function testUserPlanUpdateWithAuthorization()
    {
        $headers = [];

        $email_user = 'user1@gmail.com';

        if (!is_null($email_user)) {

            $token = auth()->guard('api')->login(User::whereEmail($email_user)->first());

            $headers['Authorization'] = 'Bearer ' . $token;

        }

        $params = [
            'title' => '(update) testing Plan 1', 
            'origin' => 'Bandung', 
            'destination' => 'Surabaya', 
            'type' => 'time-range', 
            'start_date' => '2022-04-10', 
            'end_date' => '2022-04-12', 
            'description' => 'testing update Plan 1', 
        ];

        $this->putJson('api/user/plan/1', $params, $headers)->assertStatus(200);
    }

    public function testUserPlanDeleteWithoutAuthorization()
    {
        $this->json('DELETE', 'api/user/plan/1')
            ->assertStatus(401);
    }

    public function testUserPlanDeleteWithAuthorization()
    {
        $headers = [];

        $email_user = 'user1@gmail.com';

        if (!is_null($email_user)) {

            $token = auth()->guard('api')->login(User::whereEmail($email_user)->first());

            $headers['Authorization'] = 'Bearer ' . $token;

        }

        $params = [];

        $this->deleteJson('api/user/plan/1', $params, $headers)->assertStatus(200);
    }
}
