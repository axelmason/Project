<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class AuthService
{
    public static function register(RegisterRequest $r) : bool
    {
        $validate = $r->validated();
        $create = User::create($validate);
        if($create) {
            return Auth::attempt($validate);
        }
    }

    public static function login(Request $r) : bool
    {
        return Auth::attempt(['login' => $r->login, 'password' => $r->password]);
    }
}
