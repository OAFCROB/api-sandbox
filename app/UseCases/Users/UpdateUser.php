<?php

namespace App\UseCases\Users;

use App\Exceptions\UserNotFoundException;
use App\Http\Requests\Api\Users\UpdateUserRequest;
use App\Http\Resources\User as UserResource;
use App\User as UserModel;
use Illuminate\Support\Facades\Hash;

class UpdateUser
{
    /**
     * @var array
     */
    private $request;

    public function __construct(UpdateUserRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @throws UserNotFoundException
     */
    public function execute(): UserResource
    {
        $user = UserModel::find($this->request->user_id);

        if (!$user) {
            throw new UserNotFoundException;
        }

        $user->fill([
            'name' => $this->request->name,
            'email' => $this->request->email,
            'password' => Hash::make($this->request->password),
        ])->save();

        return new UserResource($user);
    }
}