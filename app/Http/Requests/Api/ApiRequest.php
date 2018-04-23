<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ApiRequest extends FormRequest
{
    public function authorize()
    {
        // @todo - Implement JWT authentication.
        return true;
    }

    public function expectsJson()
    {
        return true;
    }
}
