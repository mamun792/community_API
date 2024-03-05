<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Http\Requests\LoginRequest;


class AuthenticationController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {

           
            $validated = $request->validated();

            $credentials = request(['email', 'password']);

            if (!auth()->attempt($credentials)) {
                return response(['message' => 'Unauthorized'], 401);
            }

            $accessToken = auth()->user()->createToken('authToken')->accessToken;

            return response([
                'message' => 'Successfully logged in',
                'status_code' => 200, 
                'token_type' => 'Bearer', 
                'expires_in' => 3600,
                'token' => $accessToken,
                'user' => auth()->user() 
                
            ]);
        } catch (\Exception $e) {
            return response([
                'status' => 'error',
                'status_code' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->token()->delete();
        $newToken = $user->createToken('authToken')->accessToken;
        return response([
            'status' => 'success',
            'status_code' => 200,
            'token_type' => 'Bearer',
            'expires_in' => 3600,
            'message' => 'Token refreshed',
            'token' => $newToken
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Successfully logged out'
            
        ], 200);
    }

    public function profile(Request $request)
    {
        try {
            $user = $request->user();
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'message' => 'User profile',
                'user' => $user
            ], 200);
        }
         catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'status_code' => 500,
                'message' => 'An unexpected error occurred.'
            ], 500);
        }
    }
}
