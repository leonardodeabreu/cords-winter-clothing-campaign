<?php

namespace App\Api\Donation\Requests;

use App\Base\Requests\BaseRequest;

class DonationIndexRequest extends BaseRequest
{
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
            'kilos'    => 'nullable|numeric',
            'team_id'  => 'nullable|integer|exists:teams,id',
        ];
    }
}
