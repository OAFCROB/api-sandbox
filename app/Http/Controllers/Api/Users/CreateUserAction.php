<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\Api\Users\CreateUserRequest;
use App\UseCases\Users\CreateUser;

class CreateUserAction extends BaseController
{
    public function __invoke(CreateUserRequest $request)
    {
        return (new CreateUser($request))->execute();
    }
}
