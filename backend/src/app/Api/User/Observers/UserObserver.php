<?php

namespace App\Api\User\Observers;

use App\Api\User\Models\UserModel;

class UserObserver
{
    /**
     * @param UserModel $user
     */
    public function creating(UserModel $user)
    {
        $user->password = config('app.key');
    }
}
