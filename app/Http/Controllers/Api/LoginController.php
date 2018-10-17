<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param  LoginRequest $request
     * @return \App\Models\User
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data)) {
            $user = $request->user();
            $token = $user->createToken('My Token')->accessToken;

            return response()->json([
                'access_token' => $token,
                'token_type'   => 'bearer',
            ]);
        }

        return response()->json([
            'error' => trans('auth.failed')
        ], 401);
    }
}
