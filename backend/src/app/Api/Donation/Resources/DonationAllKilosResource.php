<?php

namespace App\Api\Donation\Resources;

use App\Base\Resources\BaseResource;

class DonationAllKilosResource extends BaseResource
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
            'kilos' => $this->resource->first()->kilos,
        ];
    }
}
