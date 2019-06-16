<?php

namespace App\Api\Team\Repositories;

use App\Api\Donation\Repositories\DonationRepository;
use App\Api\Team\Dto\TeamDto;
use App\Api\Team\Interfaces\TeamRepositoryInterface;
use App\Api\Team\Models\TeamModel;
use App\Base\Repositories\BaseRepository;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    protected $model = TeamModel::class;

    /**
     * @param TeamDto $teamDto
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function findWhere(TeamDto $teamDto)
    {
        $query = $this
            ->newQuery()
            ->where(function ($query) use ($teamDto) {

                $id = $teamDto->getId();
                if (!is_null($id)) {
                    $query->where('id', $id);
                }

                $name = $teamDto->getName();
                if (!is_null($name)) {
                    $query->where('name', 'ilike', "%{$name}%");
                }

                $coach1 = $teamDto->getCoach1();
                if (!is_null($coach1)) {
                    $query->where('coach_1', 'ilike', "%{$coach1}%");
                }

                $coach2 = $teamDto->getCoach2();
                if (!is_null($coach2)) {
                    $query->where('coach_2', 'ilike', "%{$coach2}%");
                }
            })
            ->orderBy('name');

        return $this->doQuery($query, $teamDto->all());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function findPlayersByTeam(): \Illuminate\Support\Collection
    {
        return DB::table('players')
                 ->join('teams', 'players.team_id', '=', 'teams.id')
                 ->select('players.team_id', DB::raw('count(players.team_id) as qty'))
                 ->groupBy('players.team_id')
                 ->get();
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null
     * @throws \Exception
     */
    public function findByIdWithKilos(int $id): ?\Illuminate\Support\Collection
    {
        $teamName = $this->findByID($id)->name;
        $array    = (new DonationRepository())->findAllKilosByTeam();

        $team = collect($array)->filter(function ($value) use ($teamName) {
            if ($value->name === $teamName) {
                return $value;
            }
        });

        if (count($team) === 0) {
            return collect([
                [
                    'position' => 0,
                    'name'     => $teamName,
                    'kilos'    => 0,
                ],
            ]);
        }

        return $team;
    }
}
