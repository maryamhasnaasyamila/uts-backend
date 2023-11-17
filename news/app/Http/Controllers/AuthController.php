<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
     public function register(Request $request)
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8']
        ]);
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $data = [
            "message" => "Register Success",
            "user" => $user
        ];

        return response()->json($data, 201);
    }
    public function login(Request $request)
    {
        $input = $request->validate([
            'email' => 'required|email',
            'password' => 'string|required'
        ]);

        if (Auth::attempt($input)) {
            $token = Auth::user()->createToken('auth_token');

            $data = [
                'message' => 'User is logged in successfully',
                'token' => $token->plainTextToken
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Email or password is incorrect',
            ];

            return response()->json($data, 401);
        }
    }
}
