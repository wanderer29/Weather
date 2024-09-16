<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;


class UserController extends Controller
{
    public function register(Request $request) : RedirectResponse
    {
        $data = $request->validate([
            'login' => 'string',
            'password' => 'string'
        ]);

        $user = User::create([
            'login' => $data['login'],
            'password' => Hash::make($data['password']),
        ]);

        session(['user_id' => $user->id]);

        Cookie::queue('user_id', $user->id, 10080); //10080 min = 1 week

        return redirect()->route('home')->with('success', 'Registration successful');
    }

    public function login()
    {

    }

}
