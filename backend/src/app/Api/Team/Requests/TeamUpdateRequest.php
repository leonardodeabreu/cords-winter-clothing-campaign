<?php

namespace App\Api\Team\Requests;

use App\Base\Requests\BaseRequest;

class TeamUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => 'required|string|max:255',
            'coach_1'    => 'required|string|max:100',
            'coach_2'    => 'required|string|max:100',
            'attachment' => 'nullable|string',
        ];
    }
}
