<?php

namespace App\Api\Players\Requests;

use App\Base\Requests\BaseRequest;

class PlayerShowRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rfid' => 'required|string|exists:players,rfid',
        ];
    }
}
