<?php

namespace App\Api\Donation\Interfaces;

use App\Api\Donation\Dto\DonationDto;
use App\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DonationRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param DonationDto $donationDto
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function findWhere(DonationDto $donationDto);

    /**
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function findAllKilos();

    /**
     * @return \Illuminate\Support\Collection
     */
    public function findAllKilosByTeam(): \Illuminate\Support\Collection;
}
