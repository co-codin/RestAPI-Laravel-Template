<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect Details.
            Please try again']);
        }

        $token = auth()->user()->createToken('API Token')->plainTextToken;

        return response(['user' => auth()->user(), 'token' => $token]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response([], 200);
    }

    public function user()
    {
        return response()->json(auth()->user());
    }
}
