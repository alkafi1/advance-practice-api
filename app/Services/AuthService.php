<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register($data)
    {
        try {
            $data['password'] = Hash::make($data['password']);
            return User::create($data);
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    public function login($credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return ['user' => $user, 'token' => $token];
        }
        return null;
    }

    public function logout($user)
    {
        $user->tokens()->delete();
    }
}
