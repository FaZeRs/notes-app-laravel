<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function details(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $accessToken = $request->user()->token();
        DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->update([
            'revoked' => true,
        ]);
        $accessToken->revoke();

        return response()->json([
            'success' => 'You have successfully logged out'
        ], 200);
    }
}