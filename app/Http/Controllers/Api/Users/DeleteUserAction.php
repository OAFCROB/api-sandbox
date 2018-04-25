<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller as BaseController;
use App\User as UserModel;
use Illuminate\Http\Request;

class DeleteUserAction extends BaseController
{
    public function __invoke(Request $request)
    {
        $user = UserModel::find($request->user_id);

        if (!$user) {
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
