<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService{

   protected function jsonResponse($status, $status_code, $message,$data=null, $token = null, $user = null, $expires_in = null, $token_type = null){
        return response()->json([
            'status' => $status,
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data,
            'token' => $token,
            'user' => $user,
            'expires_in' => $expires_in,
            'token_type' => $token_type

        ], $status_code);
    }

    public function register(RegisterRequest $request)
    {
        try {
            $validated = $request->validated();

            $validated['password'] = Hash::make($request->password);

            $user = User::create($validated);

            $accessToken = $user->createToken('authToken')->accessToken;

            return $this->jsonResponse('success', 201, 'User registered successfully', null, $accessToken, $user, 3600, 'Bearer');
        } catch (\Exception $e) {
            return $this -> jsonResponse('error', 500, $e->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
    
            if (!auth()->attempt($credentials)) {
                return $this->jsonResponse('error', 401, 'Unauthorized');
            }
    
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
    
            return $this->jsonResponse('success', 200, 'User logged in successfully', null, $accessToken, auth()->user(), 3600, 'Bearer');
        } catch (\Exception $e) {
            return $this->jsonResponse('error', 500, $e->getMessage());
        }
    }
    

    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->token()->delete();
        $newToken = $user->createToken('authToken')->accessToken;
        return $this -> jsonResponse('success', 200, 'Token refreshed', null, $newToken, null, 3600, 'Bearer');
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this -> jsonResponse('success', 200, 'Successfully logged out');
    }

    public function profile()
    {
        $profile = Auth::user();
        return $this -> jsonResponse('success', 200, 'User profile retrieved', $profile);
    }
}