<?php

namespace App\Http\Controllers\Api\Users;

use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller as BaseController;
use App\UseCases\Users\GetUser;
use Illuminate\Http\Request;

class GetUserAction extends BaseController
{
    public function __invoke(Request $request)
    {
        try {
            return (new GetUser($request->user_id))->execute();
        } catch (UserNotFoundException $e) {
            return response()->json(
                [
                    'error' => [
                        'user' => sprintf('User [%d] not found.', $request->user_id)
                    ]
                ],
                404);
        }

    }
}
