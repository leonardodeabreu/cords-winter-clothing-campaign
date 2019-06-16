<?php

namespace App\Api\User\Requests;

use App\Base\Requests\BaseRequest;

class UserIndexRequest extends BaseRequest
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
            'limit'    => 'nullable|integer',
            'paginate' => 'nullable|boolean|max:1',
            'name'     => 'nullable|string|max:255',
            'email'    => 'nullable|string|max:255',
            'active'   => 'nullable|boolean',
        ];
    }
}
