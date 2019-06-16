<?php

namespace App\Api\Players\Dto;

use App\Api\Players\Requests\PlayerIndexRequest;
use App\Base\Dto\BaseDto;

class PlayerDto extends BaseDto
{
    /**
     * @var array
     */
    protected $items
        = [
            'rfid',
            'name',
            'email',
            'team',
        ];

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * RoleDto constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->rules = (new PlayerIndexRequest())->rules();
    }

    /**
     * @return null|int
     */
    public function getRfid(): ?int
    {
        return array_get($this->items, 'rfid', null);
    }

    /**
     * @param string $rfid
     */
    public function setRfid(string $rfid): void
    {
        $this->items['rfid'] = $this->filterValue('rfid', $rfid);
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return array_get($this->items, 'name', null);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->items['name'] = $this->filterValue('name', $name);
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return array_get($this->items, 'email', null);
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->items['email'] = $this->filterValue('email', $email);
    }

    /**
     * @return null|string
     */
    public function getTeam(): ?string
    {
        return array_get($this->items, 'team', null);
    }

    /**
     * @param string $team
     */
    public function setTeam(string $team): void
    {
        $this->items['team'] = $this->filterValue('team', $team);
    }
}
