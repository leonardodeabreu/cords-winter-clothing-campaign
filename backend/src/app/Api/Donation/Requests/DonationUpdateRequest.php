<?php

namespace App\Api\Donation\Requests;

use App\Base\Requests\BaseRequest;

class DonationUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kilos'   => 'required|numeric|between:0,99.99',
            'team_id' => 'required|integer|exists:teams,id',
        ];
    }
}
