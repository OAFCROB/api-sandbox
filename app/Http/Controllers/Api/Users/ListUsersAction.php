<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller as BaseController;

class ListUsersAction extends BaseController
{
    public function __invoke()
    {
        return response()->json([
            'data' => [
                'users' => [
                    // @todo - list user models
                ]
            ]
        ]);
    }
}
