<?php

namespace App\Base\Repositories;

use App\Base\Enums\ResponseEnum;
use App\Base\Interfaces\BaseRepositoryInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Log;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    protected $with = [];

    /**
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->model()
                    ->newQuery();
    }

    /**
     * @return \Illuminate\Foundation\Application|mixed
     */
    private final function model()
    {
        return app($this->model);
    }

    /**
     * @return array
     */
    public final function getFillable(): array
    {
        return $this->model()->getFillable();
    }

    /**
     * @param Builder|null $query
     * @param null|array   $appends
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    protected function doQuery(?Builder $query = null, ?array $appends = [])
    {
        if (is_null($query)) {
            $query = $this->newQuery();
        }

        if (!empty($appends['paginate'])) {
            return $query
                ->with($this->with)
                ->paginate(array_get($appends, 'limit', 15))
                ->appends($appends);
        }

        if (!empty($appends['limit'])) {
            $query->take($appends['limit']);
        }

        return $query->with($this->with)->get();
    }

    /**
     * @param null|array $appends
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function findAll(?array $appends = [])
    {
        return $this->doQuery(null, $appends);
    }

    /**
     * @param int       $id
     * @param array     $columns
     * @param bool|null $fail
     *
     * @return Model|null
     * @throws Exception
     */
    public function findByID(int $id, array $columns = ['*'], ?bool $fail = true): ?Model
    {
        if ($fail) {
            try {
                return $this->newQuery()
                            ->with($this->with)
                            ->findOrFail($id, $columns);
            } catch (ModelNotFoundException $e) {
                throw new Exception(trans(ResponseEnum::RESOURCE_NOT_FOUND), 404);
            }
        }

        return $this->newQuery()
                    ->with($this->with)
                    ->find($id, $columns);
    }

    /**
     * @param string $attribute
     * @param        $value
     * @param array  $columns
     *
     * @return Model|null
     */
    public function findBy(string $attribute, $value, array $columns = ['*']): ?Model
    {
        return $this->newQuery()
                    ->with($this->with)
                    ->where($attribute, '=', $value)
                    ->first($columns);
    }

    /**
     * @param array $data
     * @param bool  $loadRelationships
     *
     * @return Model
     * @throws Exception
     */
    public function create(array $data, bool $loadRelationships = true): Model
    {
        try {
            $fillableData = $this->getFillableData($data);

            $query = $this->newQuery()->create($fillableData);
            if ($loadRelationships) {
                $query->load($this->with);
            }

            return $query;
        } catch (QueryException $e) {
            Log::error("Code: {$e->getCode()} - Message: {$e->getMessage()}");
            throw new Exception(trans(ResponseEnum::FAILED_REGISTER), 500);
        }
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function firstOrCreate(array $data): Model
    {
        $query = $this->newQuery()->firstOrCreate($data);

        return $query->load($this->with);
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return bool
     * @throws Exception
     */
    public function update(array $data, int $id): bool
    {
        try {
            $fillableData = $this->getFillableData($data);

            return $this->findByID($id, ['*'])->update($fillableData);
        } catch (QueryException $e) {
            Log::error("Code: {$e->getCode()} - Message: {$e->getMessage()}");
            throw new Exception(trans(ResponseEnum::BAD_REQUEST), 400);
        }
    }

    /**
     * @param int $id
     *
     * @return bool|null
     * @throws Exception
     */
    public function delete(int $id): ?bool
    {
        return $this->findByID($id, ['id'], true)->delete();
    }

    /**
     * @param array $with
     *
     * @return $this
     */
    public function with(array $with = [])
    {
        $this->with = $with;

        return $this;
    }

    /**
     * @param array $columns
     *
     * @return null|Model
     */
    public function first(array $columns = ['*']): ?Model
    {
        $query = $this->newQuery()->first($columns);

        if ($query) {
            return $query->load($this->with);
        }

        return $query;
    }

    /**
     * @param string      $attribute
     * @param             $value
     * @param null|string $with
     *
     * @return bool
     */
    public function existsBy(string $attribute, $value, ?string $with = null): bool
    {
        $query = $this->newQuery();

        if (!empty($with)) {
            return $query->whereHas($with, function ($q) use ($attribute, $value) {
                $q->where($attribute, $value);
            })->exists();
        }

        return $query->where($attribute, '=', $value)->exists();
    }

    /**
     * Add a basic where clause to the query.
     *
     * @param  string|array|\Closure $column
     * @param  string                $operator
     * @param  mixed                 $value
     * @param  string                $boolean
     *
     * @return Builder
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and'): Builder
    {
        return $this->newQuery()->where($column, $operator, $value, $boolean);
    }

    /**
     * Add a basic where in clause to the query.
     *
     * @param  string $column
     * @param  array  $value
     *
     * @return Builder
     */
    public function whereIn($column, $value = []): Builder
    {
        return $this->newQuery()->whereIn($column, $value);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->newQuery()->count();
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function getFillableData(array $data): array
    {
        return Arr::only($data, $this->getFillable());
    }
}
