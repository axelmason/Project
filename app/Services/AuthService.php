<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public static function register(Request $r)
    {
        $validate = $r->validate([
            'email' => 'required|email|unique:users',
            'login' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.required' => 'Введите Email.',
            'login.required' => 'Введите логин.',
            'password.required' => 'Введите пароль.',
            'password.min' => 'Минимальная длина пароля 6 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
            'email.unique' => 'Пользователь с такой почтой уже зарегистрирован.',
            'login.unique' => 'Пользователь с таким логином уже зарегистрирован.',
        ]);

        if($validate) {
            $create = User::create($validate);
            if($create) {
                $auth = Auth::attempt($validate);
                if($auth) {
                    return to_route('index')->with('success', 'Добро пожаловать!');
                }
            }
        }
    }

    public static function login(Request $r)
    {
        $auth = Auth::attempt(['login' => $r->login, 'password' => $r->password]);
        if($auth) {
            return to_route('index')->with('success', 'Добро пожаловать!');
        }
    }
}
