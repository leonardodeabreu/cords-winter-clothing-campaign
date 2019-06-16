<?php

namespace App\Api\Players\Controllers;

use App\Api\Players\Dto\PlayerDto;
use App\Api\Players\Interfaces\PlayerRepositoryInterface;
use App\Api\Players\Repositories\PlayerRepository;
use App\Api\Players\Requests\PlayerIndexRequest;
use App\Api\Players\Requests\PlayerShowRequest;
use App\Api\Players\Requests\PlayerStoreRequest;
use App\Api\Players\Requests\PlayerUpdateRequest;
use App\Api\Players\Resources\PlayerResource;
use App\Api\Players\Services\PlayerService;
use App\Base\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Api\Players\Imports\PlayerImport;

/**
 * @Resource("Player", uri="/Player")
 */
class PlayerController extends Controller
{
    /**
     * @var PlayerRepositoryInterface
     */
    protected $repository;

    /**
     * PlayerController constructor.
     *
     * @param PlayerRepository $repository
     */
    public function __construct(PlayerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param PlayerIndexRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(PlayerIndexRequest $request): AnonymousResourceCollection
    {
        return PlayerResource::collection($this->repository->findWhere(
            PlayerDto::fromArray($request->only(PlayerIndexRequest::getKeys()))
        ));
    }

    /**
     * @param PlayerStoreRequest $request
     *
     * @return PlayerResource
     */
    public function store(PlayerStoreRequest $request): PlayerResource
    {
        try {
            return new PlayerResource($this->repository->create($request->only(PlayerStoreRequest::getKeys())));
        } catch (Exception $e) {
            return abort($e->getCode(), trans(ResponseEnum::FAILED_REGISTER_PLAYER));
        }
    }

    /**
     * @param PlayerShowRequest $request
     *
     * @return PlayerResource
     */
    public function show(PlayerShowRequest $request): PlayerResource
    {
        $rfid = $request->get('rfid');
        try {
            (new PlayerService($this->repository))->draftTeam($this->repository->findByRfid($rfid));

            return new PlayerResource($this->repository->findByRfid($rfid));
        } catch (Exception $e) {
            return abort($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param PlayerUpdateRequest $request
     * @param string              $rfid
     *
     * @return JsonResponse
     */
    public function update(PlayerUpdateRequest $request, string $rfid): JsonResponse
    {
        try {
            $this->repository->updateByRfid($request->only(PlayerUpdateRequest::getKeys()), $rfid);

            return $this->responseMessage(ResponseEnum::UPDATED_SUCCESSFULLY);
        } catch (Exception $e) {
            return abort($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @return RedirectResponse
     */
    public function import(): RedirectResponse
    {
        $path = base_path() . '/database/seeds/files/usuarios-catraca-190329.xlsx';
        try {
            Excel::import(new PlayerImport, $path);

            return redirect('/')->with('success', 'All good!');
        } catch (Exception $e) {
            return abort($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param string $rfid
     *
     * @return Response
     */
    public function delete(string $rfid): Response
    {
        $player = $this->repository->findByRfid($rfid);
        try {
            if ($this->repository->delete($player->id)) {
                return $this->response->noContent();
            }
        } catch (Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }
}
