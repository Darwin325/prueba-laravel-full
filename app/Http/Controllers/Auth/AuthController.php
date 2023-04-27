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
        try {
            $validatedData = Validator::make($request->all(), [
                'name' => 'required|max:55',
                'email' => 'email|required|unique:users',
                'password' => 'required|confirmed'
            ]);

            if ($validatedData->fails()) {
                return $this->errorResponse($validatedData->errors(), 422);
            }

            $data = $validatedData->getData();
            $data['password'] = bcrypt($data['password']);
            $user = User::query()->create($data);
            $token = $user->createToken('authToken')->plainTextToken;
            //event(new Registered($user));
            return $this->successResponse(['user' => $user, 'token' => $token], 201);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating the user', 500);
        }
    }

    public function login(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required|string'
        ]);

        if ($validatedData->fails()) {
            return $this->errorResponse($validatedData->errors(), 422);
        }
        try {
            if (!auth()->attempt($request->only('email', 'password'))) {
                return $this->errorResponse('Credenciales incorrectas', 401);
            }

            $user = User::query()->where('email', $request->email)->firstOrFail();
            $token = auth()->user()->createToken('authToken')->plainTextToken;
            return $this->successResponse(['user' => $user, 'token' => $token], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al hacer el login', 500);
        }
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        try {
            auth()->user()->tokens()->delete();
            return $this->successResponse(['message' => 'Cerró sesión correctamente'], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Hay un erro al intentar cerrar sesión', 500);
        }
    }
}
