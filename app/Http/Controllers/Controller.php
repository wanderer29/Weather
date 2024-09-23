<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

abstract class Controller
{
    public function isAuthenticated() : bool
    {
        $userIdFromSession = session('userId');
        $userIdFromCookie = Cookie::get('userId');

        return $userIdFromSession && ($userIdFromCookie === $userIdFromSession);
    }
}
