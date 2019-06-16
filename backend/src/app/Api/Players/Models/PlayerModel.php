<?php

namespace App\Api\Players\Models;

use App\Api\Team\Models\TeamModel;
use App\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerModel extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'id',
            'rfid',
            'email',
            'name',
            'team_id',
        ];

    /**
     * Get the team record associated with the protocol.
     *
     * @return HasOne
     */
    public function team(): HasOne
    {
        return $this->hasOne(TeamModel::class, 'id', 'team_id');
    }
}
