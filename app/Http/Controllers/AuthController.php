<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
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

    }

    public function user()
    {
//        return auth('custom-token')->user();
//        dd(
//            session()->get('access_token')
//        );
//        if ($token = session()->get('access_token')) {
//            $response = Http::withToken($token)->get(config('services.auth.url') . '/api/auth/user');
//
//            return $response->json();
//        } else {
//            return response()->json(['Unauthenticated user.'], 404);
//        }
    }
}
