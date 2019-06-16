<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface BaseRepositoryInterface
{
    /**
     * @param null|array $appends
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function findAll(?array $appends = []);

    /**
     * @param int       $id
     * @param array     $columns
     * @param bool|null $fail
     *
     * @return Model|null
     */
    public function findByID(int $id, array $columns = ['*'], ?bool $fail = true): ?Model;

    /**
     * @param string $attribute
     * @param        $value
     * @param array  $columns
     *
     * @return Model|null
     */
    public function findBy(string $attribute, $value, array $columns = ['*']): ?Model;

    /**
     * @param array $data
     * @param bool  $loadRelationships
     *
     * @return Model
     */
    public function create(array $data, bool $loadRelationships = true): Model;

    /**
     * @param array $data
     *
     * @return Model
     */
    public function firstOrCreate(array $data): Model;

    /**
     * @param array $data
     * @param int   $id
     *
     * @return bool
     */
    public function update(array $data, int $id): bool;

    /**
     * @param int $id
     *
     * @return bool|null
     */
    public function delete(int $id): ?bool;

    /**
     * @param array $with
     *
     * @return $this
     */
    public function with(array $with = []);

    /**
     * @param array $columns
     *
     * @return null|Model
     */
    public function first(array $columns = ['*']): ?Model;

    /**
     * @param string $attribute
     * @param        $value
     *
     * @return bool
     */
    public function existsBy(string $attribute, $value): bool;

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
    public function where($column, $operator = null, $value = null, $boolean = 'and'): Builder;

    /**
     * Add a basic where in clause to the query.
     *
     * @param       $column
     * @param array $value
     *
     * @return Builder
     */
    public function whereIn($column, $value = []): Builder;

    /**
     * @return int
     */
    public function count(): int;

    /**
     * @param array $data
     *
     * @return array
     */
    public function getFillableData(array $data): array;
}
