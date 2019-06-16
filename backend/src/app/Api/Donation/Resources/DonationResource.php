<?php

namespace App\Api\Donation\Resources;

use App\Api\Team\Resources\TeamResource;
use App\Base\Resources\BaseResource;

class DonationResource extends BaseResource
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
            'id'    => $this->id,
            'kilos' => $this->kilos,
            'team'  => new TeamResource($this->team),
        ];
    }
}
