<?php

namespace App\Api\User\Interfaces;

use App\Api\User\Dto\UserDto;
use App\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param UserDto $userDto
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function findWhere(UserDto $userDto);
}
