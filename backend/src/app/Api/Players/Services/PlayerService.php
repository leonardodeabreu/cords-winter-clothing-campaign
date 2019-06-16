<?php

namespace App\Api\Players\Services;

use App\Api\Players\Models\PlayerModel;
use App\Api\Players\Repositories\PlayerRepository;
use App\Api\Team\Repositories\TeamRepository;
use Illuminate\Support\Collection;

class PlayerService
{
    const TEAMS = [1, 2, 3, 4, 5, 6];

    /** @var PlayerRepository $repository */
    protected $repository;

    /**
     * PlayerService constructor.
     *
     * @param PlayerRepository $repository
     */
    public function __construct(PlayerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param PlayerModel $player
     *
     * @throws \Exception
     */
    public function draftTeam(PlayerModel $player): void
    {
        if ($this->checkIfContainsTeam($player->team_id)) {
            return;
        }

        $teams   = (new TeamRepository())->findPlayersByTeam();
        $teams   = $this->sortByQty($teams);
        $indexes = $this->checkIndexContainsAllTeams($teams);

        if (count($indexes) < 1) {
            $this->updatePlayer($player->rfid, $teams->first()->team_id);

            return;
        }

        $this->updatePlayer($player->rfid, $this->selectIndexTeam($indexes));
    }

    /**
     * @param array $indexes
     *
     * @return int
     */
    private function selectIndexTeam(array $indexes): int
    {
        foreach ($indexes as $index => $value) {
            return $value;
        }
    }

    /**
     * @param Collection $teams
     *
     * @return Collection
     */
    private function sortByQty(Collection $teams): Collection
    {
        return $teams->sort(function ($target, $reference) {
            if ($target->qty === $reference->qty) {
                return 0;
            }

            return $target->qty < $reference->qty ? -1 : 1;
        });
    }

    /**
     * @param int|null $teamId
     *
     * @return bool
     */
    private function checkIfContainsTeam(?int $teamId): bool
    {
        return !is_null($teamId);
    }

    /**
     * @param Collection $teams
     *
     * @return array
     */
    private function checkIndexContainsAllTeams(Collection $teams): array
    {
        $indexes = [];
        foreach ($teams as $index => $value) {
            array_push($indexes, $value->team_id);
        }

        return array_diff(self::TEAMS, $indexes);
    }

    /**
     * @param int $playerRfid
     * @param int $teamId
     *
     * @return bool
     * @throws \Exception
     */
    private function updatePlayer(int $playerRfid, int $teamId): bool
    {
        $data = ['team_id' => $teamId];

        return $this->repository->updateByRfid($data, $playerRfid);
    }
}
