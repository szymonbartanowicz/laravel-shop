<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\RegistrationRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getRegister()
    {
        return view('Auth.register');
    }

    public function register(UserService $service, RegistrationRequest $request)
    {
        $validated = $request->validated();
        $service->register($validated);
        return redirect()->route('products.index');
    }

    public function getLogin()
    {
        return view('Auth.login');
    }

    public function login(UserService $service, Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($service->login($credentials)) {
            return redirect()->route('products.index');
        }
        return back()->withErrors(['message' => 'Check Your credentials']);
    }

    public function logout(UserService $service)
    {
        $service->logout();
        return redirect()->route('products.index');
    }
}
