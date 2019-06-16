<?php

namespace App\Api\Team\Resources;

use App\Base\Resources\BaseResource;

class TeamShowResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $team = $this->resource->first();

        return [
            'position' => $team->position ?? $team['position'],
            'name'     => $team->name ?? $team['name'],
            'kilos'    => $team->kilos ?? $team['kilos'],
        ];
    }
}
