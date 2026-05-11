<?php

namespace App\Http\Controllers\Api;

use App\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return ApiHelper::response(false,401,'Invalid credentials');
        }

        $request->session()->regenerate();

        return ApiHelper::response(message: 'ok');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken(); // regenerate CSRF token

        return response()->json(['message' => 'ok']);
    }
}
