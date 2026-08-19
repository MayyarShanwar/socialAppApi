<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate(['name' => 'required', 'email' => 'required|email|unique:users', 'password' => 'required|min:6']);
        $user = User::create($validated);
        $access_token = auth('api')->setTTL(60)->login($user);
        return response()->json(['success' => 'true', 'data' => $user, 'token' => $access_token], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => "Unauthorized,Invalid email or password"
            ]);
        }
        $user->forceFill(['last_login_at' => now()])->save();
        $user = User::where('email', $request->email)->first();
        $access_token = auth('api')->setTTL(60)->login($user);
        return response()->json([
            'success' => true,
            'data' => $user,
            'token' => $access_token
        ]);
    }

    public function refresh()
    {
        try {
            $new_access_token = auth('api')->refresh();
            return response()->json([
                'success' => true,
                'token' => $new_access_token
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'The token has expired, please login again'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'messgae' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
