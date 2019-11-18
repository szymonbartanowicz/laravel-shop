<?php

namespace Tests\Unit;


use App\Models\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Services\UserService;
use Illuminate\Support\Arr;


class UserServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $data = make('App\User');
        $service = new UserService();
        $result = $service->register($data);

        $user = User::find($result['id'])->toArray();
        $userToTest = Arr::except($user, ['email_verified_at']);
        foreach ($userToTest as $key => $value) {
            $this->assertArrayHasKey($key, $result);
            $this->assertEquals($value, $result[$key]);
        }
    }

    public function test_registered_is_logged_in()
    {
        $data = make('App\User');
        $service = new UserService();
        $result = $service->register($data);
        $this->assertEquals(auth()->id(), $result['id']);
    }

    public function test_user_can_login()
    {
        $service = new UserService();
        if (auth()->check()) {
            $service->logOut();
        }
        $service = new UserService();
        $user = User::orderBy('id', 'desc')->first()->toArray();
        $data = ['email' => $user['email'], 'password' => 'secret'];
        $loggedIn = $service->login($data);
        $this->assertEquals(auth()->id(), $loggedIn['id']);
    }

    public function test_user_has_customer()
    {
        $user = User::find(1);
        $customer = $user->customer;
        $this->assertEquals($customer->user_id, $user->id);
    }
}
