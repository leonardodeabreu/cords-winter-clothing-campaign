<?php

namespace App\Api\Team\Controllers;

use App\Api\Team\Dto\TeamDto;
use App\Api\Team\Interfaces\TeamRepositoryInterface;
use App\Api\Team\Requests\TeamIndexRequest;
use App\Api\Team\Requests\TeamStoreRequest;
use App\Api\Team\Requests\TeamUpdateRequest;
use App\Api\Team\Resources\TeamResource;
use App\Api\Team\Resources\TeamShowResource;
use App\Base\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @Resource("Team", uri="/Team")
 */
class TeamController extends Controller
{
    /**
     * @var TeamRepositoryInterface
     */
    protected $repository;

    /**
     * TeamController constructor.
     *
     * @param TeamRepositoryInterface $repository
     */
    public function __construct(TeamRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param TeamIndexRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(TeamIndexRequest $request): AnonymousResourceCollection
    {
        return TeamResource::collection($this->repository->findWhere(
            TeamDto::fromArray($request->only(TeamIndexRequest::getKeys()))
        ));
    }

    /**
     * @param TeamStoreRequest $request
     *
     * @return TeamResource
     */
    public function store(TeamStoreRequest $request): TeamResource
    {
        try {
            return new TeamResource($this->repository->create($request->only(TeamStoreRequest::getKeys())));
        } catch (Exception $e) {
            return abort($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param int $id
     *
     * @return TeamShowResource
     */
    public function show(int $id): TeamShowResource
    {
        try {
            return new TeamShowResource($this->repository->findByIdWithKilos($id));
        } catch (Exception $e) {
            return abort($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param TeamUpdateRequest $request
     * @param int               $id
     *
     * @return JsonResponse
     */
    public function update(TeamUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $this->repository->update($request->only(TeamUpdateRequest::getKeys()), $id);

            return $this->responseMessage(ResponseEnum::UPDATED_SUCCESSFULLY);
        } catch (Exception $e) {
            return abort($e->getCode(), $e->getMessage());
        }
    }
}
