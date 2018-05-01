<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\Api\Users\UpdateUserRequest;
use App\Http\Resources\User as UserResource;
use App\User as UserModel;

class UpdateUserAction extends BaseController
{
    public function __invoke(UpdateUserRequest $request)
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

        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ])->save();

        return new UserResource($user);
    }
}
