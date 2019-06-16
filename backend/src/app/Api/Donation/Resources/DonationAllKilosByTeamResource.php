<?php

namespace App\Api\Donation\Resources;

use App\Base\Resources\BaseResource;

class DonationAllKilosByTeamResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'position' => $this->position,
            'name'     => $this->name,
            'kilos'    => $this->kilos,
        ];
    }
}
