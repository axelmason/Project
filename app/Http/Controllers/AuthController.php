<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerPage()
    {
        return view('auth.register');
    }

    public function register(Request $r)
    {
        AuthService::register($r);
    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $r)
    {
        AuthService::login($r);
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('index'));
    }
}
