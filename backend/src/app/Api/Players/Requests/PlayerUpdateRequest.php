<?php

namespace App\Api\Players\Requests;

use App\Base\Requests\BaseRequest;

class PlayerUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rfid'    => 'required|string|max:100',
            'email'   => 'nullable|string|max:100',
            'name'    => 'required|string|max:255',
            'team_id' => 'nullable|integer|exists:teams,id',
        ];
    }
}
