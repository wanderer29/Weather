<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
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
