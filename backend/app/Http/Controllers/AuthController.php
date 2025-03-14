<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid credentials'
            ], 401);
        }

        if (!Auth::attempt($request->only(['username', 'password']))) {
            return response()->json([
                'message' => 'invalid login'
            ], 401);
        }

        $user = User::where('username', $request->username)->first();

        return response()->json([
            'token' => $user->createToken('api-token', [$user->role])->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'logout success'
        ]);
    }
}
