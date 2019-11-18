<?php


namespace App\Services;


use App\User;
use Illuminate\Support\Facades\Auth;


class UserService
{
    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function register($data)
    {
        try {
            $user = User::create($data);
        } catch (\Exception $e) {
            throw new $e;
        }
        Auth::login($user);
        return $user;
    }

    public function login($data)
    {
        if (Auth::attempt($data)) {
            $user = Auth::user();
            return $user;
        }
    }

    public function logout()
    {
        Auth::logout();
    }
}