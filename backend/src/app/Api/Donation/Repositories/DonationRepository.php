<?php

namespace App\Api\Donation\Repositories;

use App\Api\Donation\Dto\DonationDto;
use App\Api\Donation\Interfaces\DonationRepositoryInterface;
use App\Api\Donation\Models\DonationModel;
use App\Api\Team\Repositories\TeamRepository;
use App\Base\Repositories\BaseRepository;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as supCollection;

class DonationRepository extends BaseRepository implements DonationRepositoryInterface
{
    protected $model = DonationModel::class;

    protected $with = ['team'];

    /**
     * @param DonationDto $donationDto
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function findWhere(DonationDto $donationDto)
    {
        $query = $this
            ->newQuery()
            ->where(function ($query) use ($donationDto) {

                $kilos = $donationDto->getKilos();
                if (!is_null($kilos)) {
                    $query->where('kilos', $kilos);
                }

                $team = $donationDto->getTeam();
                if (!is_null($team)) {
                    $query->whereHas('team', function ($q) use ($team) {
                        $q->where('name', $team);
                    });
                }
            });

        return $this->doQuery($query, $donationDto->all());
    }

    /**
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function findAllKilos()
    {
        $query = $this
            ->newQuery()
            ->select(DB::raw('sum(donation.kilos) as kilos'));

        return $this->doQuery($query);
    }

    /**
     * @return supCollection
     * @throws \Exception
     */
    public function findAllKilosByTeam(): supCollection
    {
        $teamsIds = [1, 2, 3, 4, 5, 6];
        $teams    = DB::table('donation')
                      ->join('teams', 'donation.team_id', '=', 'teams.id')
                      ->select('teams.name', 'teams.id', DB::raw('sum(donation.kilos) as kilos'),
                          DB::raw('ROW_NUMBER () OVER (ORDER BY sum(donation.kilos) desc) as position'))
                      ->groupBy('teams.id')
                      ->get();

        $missedTeams = $this->checkIndexContainsAllTeams($teams, $teamsIds);

        return $this->addInArrayMissedTeams($teams, $missedTeams);
    }

    /**
     * @param supCollection $teams
     * @param array         $missedTeams
     *
     * @return supCollection
     * @throws \Exception
     */
    private function addInArrayMissedTeams(supCollection $teams, array $missedTeams): supCollection
    {
        foreach ($missedTeams as $teamId) {
            $resource = (new TeamRepository())->findByID($teamId);

            $object           = new \stdClass();
            $object->id       = $resource->id;
            $object->position = 0;
            $object->name     = $resource->name;
            $object->kilos    = 0;

            $teams->push($object);
        }

        return $teams;
    }

    /**
     * @param supCollection $teams
     * @param array         $teamsIds
     *
     * @return array
     */
    private function checkIndexContainsAllTeams(supCollection $teams, array $teamsIds): array
    {
        $indexes = [];
        foreach ($teams as $index => $value) {
            array_push($indexes, $value->id);
        }

        return array_diff($teamsIds, $indexes);
    }
}
