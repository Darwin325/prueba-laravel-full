<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Services\Contracts\IUserService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class UserService implements IUserService
{
    use ApiResponser;

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:55',
            'last_name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $data['role_id'] = Role::STUDENT;
        $user = User::query()->create($data);
        $token = $user->createToken('authToken')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token
        ];
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
        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }
}
