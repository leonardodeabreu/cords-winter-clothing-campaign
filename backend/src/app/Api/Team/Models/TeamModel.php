<?php

namespace App\Api\Team\Models;

use App\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamModel extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'id',
            'name',
            'coach_1',
            'coach_2',
            'attachment',
        ];
}
