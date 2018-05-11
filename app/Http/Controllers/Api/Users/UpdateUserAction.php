<?php

namespace App\Http\Controllers\Api\Users;

use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\Api\Users\UpdateUserRequest;
use App\UseCases\Users\UpdateUser;

class UpdateUserAction extends BaseController
{
    public function __invoke(UpdateUserRequest $request)
    {
        try {
            return (new UpdateUser($request))->execute();
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
