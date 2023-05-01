<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $request->validate( [
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::query()->create($data);
        $token = $user->createToken('authToken')->plainTextToken;
        //event(new Registered($user));
        return $this->successResponse(['user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required|string'
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
            return $this->errorResponse('Credenciales incorrectas', 401);
        }

        $user = User::query()->where('email', $request->email)->firstOrFail();
        $token = auth()->user()->createToken('authToken')->plainTextToken;
        return $this->successResponse(['user' => $user, 'token' => $token], 200);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->tokens()->delete();
        return $this->successResponse(['message' => 'Cerró sesión correctamente'], 200);
    }
}
