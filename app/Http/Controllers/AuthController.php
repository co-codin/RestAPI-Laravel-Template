<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        $response = Http::post(config('services.auth.url') . '/api/auth/login', $request->all());

        dd(
            $response->json()
        );
    }

    public function logout()
    {

    }

    public function user()
    {

    }
}
