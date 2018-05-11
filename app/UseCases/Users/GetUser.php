<?php

namespace App\UseCases\Users;

use App\Exceptions\UserNotFoundException;
use App\Http\Requests\Api\Users\UpdateUserRequest;
use App\Http\Resources\User as UserResource;
use App\User as UserModel;
use Illuminate\Support\Facades\Hash;

class GetUser
{
    /**
     * @var int
     */
    private $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @throws UserNotFoundException
     */
    public function execute(): UserResource
    {
        $user = UserModel::find($this->userId);

        if (!$user) {
            throw new UserNotFoundException;
        }
        
        return new UserResource($user);
    }
}