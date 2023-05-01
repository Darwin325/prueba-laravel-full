<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IUserService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponser;

    public function __construct(private readonly IUserService $userService)
    {
    }

    public function register(Request $request)
    {
        $user = $this->userService->register($request);
        return $this->successResponse($user, 201);
    }

    public function login(Request $request)
    {
        $user = $this->userService->login($request);
        return $this->successresponse($user, 200);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->tokens()->delete();
        return $this->successResponse(['message' => 'Cerró sesión correctamente'], 200);
    }
}
