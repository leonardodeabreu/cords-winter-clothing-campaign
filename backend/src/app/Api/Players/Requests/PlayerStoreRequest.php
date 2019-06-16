<?php

namespace App\Api\Players\Requests;

use App\Base\Requests\BaseRequest;
use App\Base\Validations\Rules\Lowercase;

class PlayerStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rfid'  => 'required|string|max:8',
            'name'  => 'required|string|max:255',
            'email' => [
                'nullable',
                'string',
                'email',
                'max:100',
                new Lowercase,
            ],
        ];
    }
}
