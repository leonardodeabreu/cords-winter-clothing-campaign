<?php

namespace App\Api\User\Repositories;

use App\Api\User\Dto\UserDto;
use App\Api\User\Interfaces\UserRepositoryInterface;
use App\Api\User\Models\UserModel;
use App\Base\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model = UserModel::class;

    /**
     * @param UserDto $userDto
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function findWhere(UserDto $userDto)
    {
        $query = $this->newQuery();

        $name = $userDto->getName();
        if (!is_null($name)) {
            $query->where('name', 'ilike', "%{$name}%");
        }

        $email = $userDto->getEmail();
        if (!is_null($email)) {
            $query->where('email', 'ilike', "%{$email}%");
        }

        $query->where('active', true)
              ->orderBy('id', 'desc');

        return $this->doQuery($query, ['paginate' => $userDto->getPaginate(), 'limit' => $userDto->getLimit()]);
    }
}
