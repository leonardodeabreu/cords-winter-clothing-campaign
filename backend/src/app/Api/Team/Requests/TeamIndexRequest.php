<?php

namespace App\Api\Team\Requests;

use App\Base\Requests\BaseRequest;

class TeamIndexRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'       => 'nullable|integer',
            'name'     => 'nullable|string|max:100',
            'coach_1'  => 'nullable|string|max:100',
            'coach_2'  => 'nullable|string|max:100',
            'limit'    => 'nullable|integer',
            'paginate' => 'nullable|boolean|max:1',
            'page'     => 'nullable|integer',
        ];
    }
}
