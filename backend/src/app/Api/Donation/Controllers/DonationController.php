<?php

namespace App\Api\Donation\Controllers;

use App\Api\Donation\Dto\DonationDto;
use App\Api\Donation\Interfaces\DonationRepositoryInterface;
use App\Api\Donation\Requests\DonationIndexRequest;
use App\Api\Donation\Requests\DonationStoreRequest;
use App\Api\Donation\Requests\DonationUpdateRequest;
use App\Api\Donation\Resources\DonationAllKilosByTeamResource;
use App\Api\Donation\Resources\DonationAllKilosResource;
use App\Api\Donation\Resources\DonationResource;
use App\Base\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @Resource("Donation", uri="/Donation")
 */
class DonationController extends Controller
{
    /**
     * @var DonationRepositoryInterface
     */
    protected $repository;

    /**
     * DonationController constructor.
     *
     * @param DonationRepositoryInterface $repository
     */
    public function __construct(DonationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param DonationIndexRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(DonationIndexRequest $request): AnonymousResourceCollection
    {
        return DonationResource::collection($this->repository->findWhere(DonationDto::fromArray($request->all())));
    }

    /**
     * @param DonationStoreRequest $request
     *
     * @return DonationResource
     */
    public function store(DonationStoreRequest $request): DonationResource
    {
        try {
            return new DonationResource($this->repository->create($request->only(DonationStoreRequest::getKeys())));
        } catch (Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param int $id
     *
     * @return DonationResource
     */
    public function show(int $id): DonationResource
    {
        try {
            return new DonationResource($this->repository->findByID($id));
        } catch (Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @return DonationAllKilosResource
     */
    public function allKilos(): DonationAllKilosResource
    {
        try {
            return new DonationAllKilosResource($this->repository->findAllKilos());
        } catch (Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function byTeam(): AnonymousResourceCollection
    {
        try {
            return DonationAllKilosByTeamResource::collection($this->repository->findAllKilosByTeam());
        } catch (Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param DonationUpdateRequest $request
     * @param int                   $id
     *
     * @return JsonResponse
     */
    public function update(DonationUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $this->repository->update($request->only(DonationUpdateRequest::getKeys()), $id);

            return $this->responseMessage(ResponseEnum::UPDATED_SUCCESSFULLY);
        } catch (Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }
}
