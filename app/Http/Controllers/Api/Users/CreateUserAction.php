<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\Api\Users\CreateUserRequest;
use App\Http\Resources\User as UserResource;
use App\User as UserModel;

class CreateUserAction extends BaseController
{
    public function __invoke(CreateUserRequest $request)
    {
        $user = new UserModel($request->all());
        $user->save();
        return new UserResource($user);
    }
}
