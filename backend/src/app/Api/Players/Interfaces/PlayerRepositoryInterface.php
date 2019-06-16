<?php

namespace App\Api\Players\Interfaces;

use App\Api\Players\Dto\PlayerDto;
use App\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface PlayerRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param PlayerDto $playersDto
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function findWhere(PlayerDto $playersDto);

    /**
     * @param array  $data
     * @param string $rfid
     *
     * @return bool
     */
    public function updateByRfid(array $data, string $rfid): bool;

    /**
     * @param string $rfid
     *
     * @return Model|null
     */
    public function findByRfid(string $rfid): ?Model;
}
