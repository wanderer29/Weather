<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class UserController extends Controller
{
    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $this->createUser($data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Registration successful');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $this->findUser($data);

        //If Authorization success
        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Login successful');
        }

        return redirect()->route('login')->with('error', 'Invalid login or password');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout successful');
    }

    private function createUser(array $data): User
    {
        return User::create([
            'login' => $data['login'],
            'password' => Hash::make($data['password']),
        ]);
    }

    private function findUser(array $data): User
    {
        return User::where('login', $data['login'])->first();
    }

}
