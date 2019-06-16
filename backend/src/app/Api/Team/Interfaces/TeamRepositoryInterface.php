<?php

namespace App\Api\Team\Interfaces;

use App\Api\Team\Dto\TeamDto;
use App\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface TeamRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param TeamDto $teamDto
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function findWhere(TeamDto $teamDto);

    /**
     * @return \Illuminate\Support\Collection
     */
    public function findPlayersByTeam(): \Illuminate\Support\Collection;

    /**
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function findByIdWithKilos(int $id): ?\Illuminate\Support\Collection;
}
