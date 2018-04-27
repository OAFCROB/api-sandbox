<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\Api\ApiRequest;

class UpdateUserRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }
}
