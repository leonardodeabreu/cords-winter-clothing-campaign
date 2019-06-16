<?php

namespace App\Api\Team\Dto;

use App\Api\Team\Requests\TeamIndexRequest;
use App\Base\Dto\BaseDto;

class TeamDto extends BaseDto
{
    /**
     * @var array
     */
    protected $items
        = [
            'id',
            'name',
            'coach_1',
            'coach_2',
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

        $this->rules = (new TeamIndexRequest())->rules();
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
    public function getCoach1(): ?string
    {
        return array_get($this->items, 'coach_1', null);
    }

    /**
     * @param string $coach1
     */
    public function setCoach1(string $coach1): void
    {
        $this->items['coach_1'] = $this->filterValue('coach_1', $coach1);
    }

    /**
     * @return null|string
     */
    public function getCoach2(): ?string
    {
        return array_get($this->items, 'coach_2', null);
    }

    /**
     * @param string $coach2
     */
    public function setCoach2(string $coach2): void
    {
        $this->items['coach_2'] = $this->filterValue('coach_2', $coach2);
    }
}
