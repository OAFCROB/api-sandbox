<?php

namespace App\Http\Controllers\Api\Users;

use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller as BaseController;
use App\UseCases\Users\DeleteUser;
use Illuminate\Http\Request;

class DeleteUserAction extends BaseController
{
    public function __invoke(Request $request)
    {
        try {
            return (new DeleteUser($request->user_id))->execute();
        } catch (UserNotFoundException $e) {
            return response()->json(
                [
                    'error' => [
                        'user' => sprintf('User [%d] not found.', $request->user_id)
                    ]
                ],
                404);
        }

        return response()->json(
            [
                'data' => [
                    'deleted' => $user->delete()
                ]
            ],
            200
        );
    }
}
