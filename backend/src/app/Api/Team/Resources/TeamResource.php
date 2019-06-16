<?php

namespace App\Api\Team\Resources;

use App\Base\Resources\BaseResource;

class TeamResource extends BaseResource
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
            'id'         => $this->id,
            'name'       => $this->name,
            'coach_1'    => $this->coach_1,
            'coach_2'    => $this->coach_2,
            'attachment' => $this->attachment,
        ];
    }
}
