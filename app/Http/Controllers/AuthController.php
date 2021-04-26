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

        if ($response->ok()) {
            session()->put('access_token', $response['token']);
            return response()->json([], 200);
        } else {
            return response()->json(['Unauthenticated user.'], 404);
        }
    }

    public function logout()
    {
        $response = Http::withToken(session()->get('access_token'))->post(config('services.auth.url') . '/api/auth/logout');

        if ($response->ok()) {
            session()->remove('access_token');
            return response()->json(['Logged out.'], 200);
        } else {
            return response()->json([], 401);
        }
    }

    public function user()
    {
        return auth('api')->user();
    }
}
