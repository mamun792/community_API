<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class RegisterController extends Controller
{
   public function register(RegisterRequest $request)
   {
       try {
           $validated = $request->validated();

           $validated['password'] = bcrypt($request->password);

           $user = User::create($validated);

           $accessToken = $user->createToken('authToken')->accessToken;

           return response([
               'message' => 'Successfully registered',
               'status_code' => 200,
               'token_type' => 'Bearer',
               'expires_in' => 3600,
               'token' => $accessToken,
               'user' => $user
           ]);
       } catch (\Exception $e) {
           return response([
               'status' => 'error',
               'status_code' => 500,
               'message' => $e->getMessage()
           ], 500);
       }
   }



}
