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


class UserController extends Controller
{
    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'login' => 'required|string|unique:users,login',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'login' => $data['login'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $tmp = Auth::check();
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Registration successful');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

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
