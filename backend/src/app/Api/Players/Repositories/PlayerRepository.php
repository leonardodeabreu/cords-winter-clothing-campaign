<?php

namespace App\Api\Players\Repositories;

use App\Api\Players\Interfaces\PlayerRepositoryInterface;
use App\Api\Players\Models\PlayerModel;
use App\Api\Players\Dto\PlayerDto;
use App\Base\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PlayerRepository extends BaseRepository implements PlayerRepositoryInterface
{
    protected $model = PlayerModel::class;

    protected $with = ['team'];

    /**
     * @param PlayerDto $playerDto
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function findWhere(PlayerDto $playerDto)
    {
        $query = $this
            ->newQuery()
            ->where(function ($query) use ($playerDto) {

                $rfid = $playerDto->getRfid();
                if (!is_null($rfid)) {
                    $query->where('rfid', $rfid);
                }

                $name = $playerDto->getName();
                if (!is_null($name)) {
                    $query->where('name', 'ilike', "%{$name}%");
                }

                $email = $playerDto->getEmail();
                if (!is_null($email)) {
                    $query->where('email', 'ilike', "%{$email}%");
                }

                $team = $playerDto->getTeam();
                if (!is_null($team)) {
                    $query->whereHas('team', function ($q) use ($team) {
                        $q->where('name', $team);
                    });
                }
            });

        return $this->doQuery($query, $playerDto->all());
    }

    /**
     * @param string $rfid
     *
     * @return PlayerModel|null
     */
    public function findByRfid(string $rfid): ?Model
    {
        return $this->findBy('rfid', $rfid);
    }

    /**
     * @param array  $data
     * @param string $rfid
     *
     * @return bool
     * @throws \Exception
     */
    public function updateByRfid(array $data, string $rfid): bool
    {
        $player = $this->findByRfid($rfid);

        return parent::update($data, $player->id);
    }
}
