<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\Api\ApiRequest;

class CreateUserRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255',], // @todo - 'email', 'unique:users'
            'password' => ['required', 'string', 'min:6',], // @todo - confirmed
        ];
    }
}
