<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\RegisterRequest;



class RegisterController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

   public function register(RegisterRequest $request)
   {
       return $this->userService->register($request);
   }



}
