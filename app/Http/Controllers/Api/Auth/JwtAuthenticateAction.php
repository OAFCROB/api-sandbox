<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtAuthenticateAction extends BaseController
{
    public function __invoke(Request $request)
    {
        try {
            if (! $token = auth()->attempt($request->only('email', 'password'))) {
                return response()->json(
                    [
                        'error' => [
                            'authentication' => 'Unauthorized.'
                        ]
                    ],
                    401
                );
            }

            return response()->json(
                [
                    'data' => [
                        'token' => $token,
                        'token_type' => 'bearer',
                        'expires_in' => auth()->factory()->getTTL() * 60
                    ]
                ],
                200
            );

        } catch (JWTException $e) {
            return response()->json(
                [
                    'error' => [
                        'authentication' => 'Unable to generate token at this time, please try again later.'
                    ]
                ],
                500
            );
        }
    }
}
