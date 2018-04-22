<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Resources\User as UserResource;
use App\User as UserModel;
use Illuminate\Http\Request;

class CreateUserAction extends BaseController
{
    public function __invoke(Request $request)
    {
        $user = new UserModel($request->all());
        $user->save();
        return new UserResource($user);
    }
}
