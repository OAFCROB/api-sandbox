<?php

namespace App\UseCases\Users;

use App\Exceptions\UserNotFoundException;
use App\Http\Resources\UserCollection;
use App\User as UserModel;

class ListUsers
{
    /**
     * @var UserModel
     */
    private $user;

    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }

    /**
     * @throws UserNotFoundException
     */
    public function execute(): UserCollection
    {
        return new UserCollection($this->user->orderBy('name', 'asc')->get());
    }
}