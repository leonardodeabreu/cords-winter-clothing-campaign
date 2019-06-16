<?php

namespace App\Api\Players\Resources;

use App\Api\Team\Resources\TeamResource;
use App\Base\Resources\BaseResource;

class PlayerResource extends BaseResource
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
        return [
            'id'    => $this->id,
            'rfid'  => $this->rfid,
            'name'  => $this->name,
            'email' => $this->email,
            'team'  => new TeamResource($this->team),
        ];
    }
}
