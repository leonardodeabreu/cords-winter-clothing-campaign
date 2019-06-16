<?php

namespace App\Api\Auth\Requests;

use App\Base\Requests\BaseRequest;
use App\Base\Validations\Rules\Lowercase;

class LoginRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => [
                'required',
                'exists:users',
                'string',
                'email',
                'max:255',
                new Lowercase,
            ],
            'password' => 'required|min:8'
        ];
    }
}
