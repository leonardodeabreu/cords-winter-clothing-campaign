<?php

namespace App\Api\Players\Requests;

use App\Base\Requests\BaseRequest;

class PlayerIndexRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rfid'     => 'nullable|string',
            'name'     => 'nullable|string|max:100',
            'email'    => 'nullable|string|max:100',
            'team'     => 'nullable|string|max:100',
            'limit'    => 'nullable|integer',
            'paginate' => 'nullable|boolean|max:1',
            'page'     => 'nullable|integer',
        ];
    }
}
