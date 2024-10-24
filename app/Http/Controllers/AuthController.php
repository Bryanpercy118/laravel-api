<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        return $this->authService->register($request->all());
    }

    public function login(Request $request)
    {
        return $this->authService->login($request->only('email', 'password'));
    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function userProfile()
    {
        return response()->json($this->authService->userProfile());
    }

}
