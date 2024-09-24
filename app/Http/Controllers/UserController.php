<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;


class UserController extends Controller
{
    public function register(Request $request): RedirectResponse
    {
        if ($this->isAuthenticated()) {
            return $this->redirectUserToHome();
        }

        $data = $request->validate([
            'login' => 'required|string|unique:users,login',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'login' => $data['login'],
            'password' => Hash::make($data['password']),
        ]);

        session(['user_id' => $user->id]);

        Cookie::queue('user_id', $user->id, 10080); //10080 min = 1 week

        return redirect()->route('home')->with('success', 'Registration successful');
    }

    public function login(Request $request): RedirectResponse
    {
        if ($this->isAuthenticated()) {
            return $this->redirectUserToHome();
        }

        $data = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('login', $data['login'])->first();

        if ($user && Hash::check($data['password'], $user->password)) {
            session(['user_id' => $user->id]);

            Cookie::queue('user_id', $user->id, 10080); //10080min = 1 week

            return redirect()->route('home')->with('success', 'Login successful');
        } else {
            return redirect()->route('login.index')->with('error', 'Invalid login or password');
        }
    }

    public function logout(): RedirectResponse
    {
        Session::forget('user_id');
        Cookie::queue(Cookie::forget('user_id'));

        return redirect()->route('home')->with('success', 'Logout successful');
    }

    public function showWelcome(): RedirectResponse|View
    {
        if ($this->isAuthenticated()) {
            return $this->redirectUserToHome();
        }

        return view('welcome');
    }

    public function showLogin(): RedirectResponse|View
    {
        if ($this->isAuthenticated()) {
            return $this->redirectUserToHome();
        }

        return view('authorization_page');
    }

    public function showRegistration(): RedirectResponse|View
    {
        if ($this->isAuthenticated()) {
            return $this->redirectUserToHome();
        }

        return view('registration_page');
    }

    public function isAuthenticated(): bool
    {
        return (bool)session('user_id');
    }

    public function redirectUserToHome(): RedirectResponse|null
    {
        if ($this->isAuthenticated()) {
            return redirect()->route('home');
        }
        return null;
    }

}
