<?php

namespace App\Api\User\Dto;

use App\Api\User\Requests\UserIndexRequest;
use App\Base\Dto\BaseDto;

class UserDto extends BaseDto
{
    /**
     * @var array
     */
    protected $items
        = [
            'name',
            'email',
        ];

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * UserDto constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->rules = (new UserIndexRequest())->rules();
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
}
