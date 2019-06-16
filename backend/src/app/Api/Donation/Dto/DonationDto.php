<?php

namespace App\Api\Donation\Dto;

use App\Api\Donation\Requests\DonationIndexRequest;
use App\Base\Dto\BaseDto;

class DonationDto extends BaseDto
{
    /**
     * @var array
     */
    protected $items
        = [
            'id',
            'kilos',
            'team_id',
        ];

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * DonationDto constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->rules = (new DonationIndexRequest())->rules();
    }

    /**
     * @return null|int
     */
    public function getId(): ?int
    {
        return array_get($this->items, 'id', null);
    }

    /**
     * @return null|string
     */
    public function getKilos(): ?string
    {
        return array_get($this->items, 'kilos', null);
    }

    /**
     * @param string $kilos
     */
    public function setKilos(string $kilos): void
    {
        $this->items['kilos'] = $this->filterValue('kilos', $kilos);
    }

    /**
     * @return null|string
     */
    public function getTeam(): ?string
    {
        return array_get($this->items, 'team', null);
    }

    /**
     * @param bool $team
     */
    public function setTeam(bool $team): void
    {
        $this->items['team'] = $this->filterValue('team', $team);
    }
}
