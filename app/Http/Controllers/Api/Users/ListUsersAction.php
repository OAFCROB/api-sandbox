<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller as BaseController;
use App\User as UserModel;

class ListUsersAction extends BaseController
{
    public function __invoke(UserModel $user)
    {
        $users = $user->orderBy('name', 'asc')->get();

        return response()->json([
            'data' => [
                'users' => $users->transform(function ($user) {
                    return [
                        'name' => $user->name,
                        'email' => $user->email,
                    ];
                })
            ]
        ]);
    }
}
