<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\LoginRequest;


class AuthenticationController extends Controller
{

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function login(LoginRequest $request)
    {
        return $this->userService->login($request);
    }

    public function refresh(Request $request)
    {
        $this->userService->refresh($request);
    }

    public function logout(Request $request)
    {
        $this->userService->logout($request);
    }

    public function profile()
    {
        return $this->userService->profile();
    }
}
