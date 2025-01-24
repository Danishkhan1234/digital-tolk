<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    /**
     * @param LoginRequest $request
     * 
     * @return JsonResponse
     */

    public function login(LoginRequest $request): JsonResponse
    {
        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'status' => false,
                'message' => 'Email & Password does not match with our record.',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'data' => [
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user'  => $user
            ]
        ], 200);

    }

  
}
