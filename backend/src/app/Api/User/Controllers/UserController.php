<?php

namespace App\Api\User\Controllers;

use App\Api\User\Dto\UserDto;
use App\Api\User\Interfaces\UserRepositoryInterface;
use App\Api\User\Requests\UserIndexRequest;
use App\Api\User\Resources\UserResource;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @Resource("User", uri="/user")
 */
class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $repository;

    /**
     * UserController constructor.
     *
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UserIndexRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(UserIndexRequest $request): AnonymousResourceCollection
    {
        return UserResource::collection($this->repository->findWhere(UserDto::fromArray($request->all())));
    }

    /**
     * @param int $id
     *
     * @return UserResource
     */
    public function show(int $id): UserResource
    {
        try {
            return new UserResource($this->repository->findByID($id));
        } catch (Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }
}
