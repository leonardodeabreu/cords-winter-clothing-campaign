<?php

namespace App\Api\Donation\Models;

use App\Api\Team\Models\TeamModel;
use App\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonationModel extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'donation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'id',
            'kilos',
            'team_id',
        ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates
        = [
            'deleted_at',
        ];

    /**
     * Get the team record associated with the Donation.
     *
     * @return HasOne
     */
    public function team(): HasOne
    {
        return $this->hasOne(TeamModel::class, 'id', 'team_id');
    }
}
