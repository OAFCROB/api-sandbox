<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Resources\UserCollection;
use App\UseCases\Users\ListUsers;
use App\User as UserModel;

class ListUsersAction extends BaseController
{
    public function __invoke(UserModel $user): UserCollection
    {
        return (new ListUsers($user))->execute();

    }
}
