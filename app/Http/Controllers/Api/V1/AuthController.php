<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request):JsonResponse
    {
        $validation = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'password' => 'required',
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::find(Auth::id()); // because the lsp kept buggin

            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Wrong credentials'], 401);
        }
    }

    public function register(Request $request):JsonResponse
    {
        $validation = Validator::make(
            $request->all(),
            [
                'username' => 'required|string|unique:users,username|max:255',
                'email' => 'nullable|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email ?? $request->username . '@cimaflix.com',
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function auth():JsonResponse
    {
        return response()->json(Auth::user(), 200);
    }
}
