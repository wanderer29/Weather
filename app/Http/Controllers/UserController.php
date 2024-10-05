<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class UserController extends Controller
{
    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::create([
            'login' => $data['login'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $tmp = Auth::check();
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Registration successful');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::where('login', $data['login'])->first();

        if(Auth::attempt($data)) {
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

    public function showWelcome(): RedirectResponse|View
    {
        return view('welcome_page');
    }

    public function showLogin(): RedirectResponse|View
    {
        return view('authorization_page');
    }

    public function showRegistration(): RedirectResponse|View
    {
        return view('registration_page');
    }

}
