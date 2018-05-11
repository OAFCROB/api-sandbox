<?php

namespace App\UseCases\Users;

use App\Http\Requests\Api\Users\CreateUserRequest;
use App\Http\Resources\User as UserResource;
use App\User as UserModel;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    /**
     * @var array
     */
    private $request;

    public function __construct(CreateUserRequest $request)
    {
        $this->request = $request;
    }

    public function execute(): UserResource
    {
        $user = UserModel::create([
            'name' => $this->request->name,
            'email' => $this->request->email,
            'password' => Hash::make($this->request->password)
        ]);

        return new UserResource($user);
    }
}