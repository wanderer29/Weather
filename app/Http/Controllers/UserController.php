<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register()
    {
        $data = request()->validate([
            'login' => 'string',
            'password' => 'string',
        ]);

        $user = new User();
        $user->login = $data['login'];
        $user->password = Hash::make($data['password']);
        $user->save();



        return redirect()->route('home')->cookie('user_id', $user->id, 60 * 24 * 3);
    }

    public function login()
    {

    }

}
