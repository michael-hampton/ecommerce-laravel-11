<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IBaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class BaseRepository implements IBaseRepository
{
    public function __construct(protected Model $model)
    {
    }

    /**
     * Get all items
     *
     * @param string $columns specific columns to select
     * @param string $orderBy column to sort by
     * @param string $sort sort direction
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(string $columns = null, string $orderBy = 'created_at', string $sort = 'desc', array $searchParams = [])
    {
        return $this->applyFilters($searchParams)
            //->with($this->requiredRelationships)
            ->orderBy($orderBy, $sort)
            ->get()
        ;
    }

    protected function getQuery(): Builder
    {
        $query = $this->model->query();

        $query->when(!empty($this->with), function (Builder $query) {
            $query->with($this->with);
        });

        return $query;
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        return $this->getQuery();
    }

    /**
     * Get paged items
     *
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     * @param $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginated(int $paged = 15, string $orderBy = 'created_at', string $sort = 'desc', $search = [])
    {
//        dd($this->applyFilters($search)
//            //->with($this->requiredRelationships)
//            ->orderBy($orderBy, $sort)->toSql());

        return  $this->applyFilters($search)
            //->with($this->requiredRelationships)
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * Choose what relationships to return with query.
     *
     * @param mixed $relationships
     * @return $this
     */
    public function with($relationships)
    {
        $this->requiredRelationships = [];

        if ($relationships == 'all') {
            $this->requiredRelationships = $this->relationships;
        } elseif (is_array($relationships)) {
            $this->requiredRelationships = array_filter($relationships, function ($value) {
                return in_array($value, $this->relationships);
            });
        } elseif (is_string($relationships)) {
            array_push($this->requiredRelationships, $relationships);
        }

        return $this;
    }

    /**
     * Perform the repository query.
     *
     * @param $callback
     * @return mixed
     */
    protected function doQuery($callback)
    {
        $previousMethod = debug_backtrace(null, 2)[1];
        $methodName = $previousMethod['function'];
        $arguments = $previousMethod['args'];

        $result = $this->doBeforeQuery($callback, $methodName, $arguments);

        return $this->doAfterQuery($result, $methodName, $arguments);
    }

    /**
     * Items for select options
     *
     * @param string $data column to display in the option
     * @param string $key column to be used as the value in option
     * @param string $orderBy column to sort by
     * @param string $sort sort direction
     * @return array           array with key value pairs
     */
    public function getForSelect($data, $key = 'id', $orderBy = 'created_at', $sort = 'desc')
    {
        $query = function () use ($data, $key, $orderBy, $sort) {
            return $this->model
                ->with($this->requiredRelationships)
                ->orderBy($orderBy, $sort)
                ->lists($data, $key)
                ->all()
            ;
        };

        return $this->doQuery($query);
    }

    /**
     * Get instance of model by column
     *
     * @param mixed $term search term
     * @param string $column column to search
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollectionByColumn(string $term, string $column = 'slug', int $limit = 0)
    {
        $query = $this->model
            //->with($this->requiredRelationships)
            ->where($column, '=', $term)
        ;

        if ($limit > 0) {
            $query->take($limit);
        }

        return $query->get();
    }

    /**
     * Get item by id or column
     *
     * @param mixed $term id or term
     * @param string $column column to search
     * @return Model
     */
    public function getActively($term, $column = 'slug')
    {
        if (is_numeric($term)) {
            return $this->getById($term);
        }

        return $this->getItemByColumn($term, $column);
    }

    /**
     * Get item by its id
     *
     * @param integer $id
     * @return Model
     */
    public function getById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Get instance of model by column
     *
     * @param mixed $term search term
     * @param string $column column to search
     * @return Model
     */
    public function getItemByColumn($term, $column = 'slug')
    {
        return $this->model
            //->with($this->requiredRelationships)
            ->where($column, '=', $term)
            ->first()
        ;
    }

    /**
     * Update or crate a record and return the entity
     *
     * @param array $identifiers columns to search for
     * @param array $data
     * @return mixed
     */
    public function updateOrCreate(array $identifiers, array $data)
    {
        $existing = $this->model->where(array_only($data, $identifiers))->first();

        if ($existing) {
            $existing->update($data);

            return $existing;
        }

        return $this->create($data);
    }

    /**
     * Update a record using the primary key.
     *
     * @param $id mixed primary key
     * @param $data array
     */
    public function update($id, array $data)
    {
        return $this->model->where($this->model->getKeyName(), $id)->update($data);
    }

    /**
     * Create new using mass assignment
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Delete a record by the primary key.
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->model->where($this->model->getKeyName(), $id)->delete();
    }

    /**
     *  Apply any modifiers to the query.
     *
     * @param $callback
     * @param $methodName
     * @param $arguments
     * @return mixed
     */
//    private function doBeforeQuery($callback, $methodName, $arguments)
//    {
//        $traits = $this->getUsedTraits();
//
//        if (in_array(CacheResults::class, $traits) && $this->caching && $this->isCacheableMethod($methodName)) {
//            return $this->processCacheRequest($callback, $methodName, $arguments);
//        }
//
//        return $callback();
//    }

    /**
     * Handle the query result.
     *
     * @param $result
     * @param $methodName
     * @param $arguments
     * @return mixed
     */
//    private function doAfterQuery($result, $methodName, $arguments)
//    {
//        $traits = $this->getUsedTraits();
//
//        if (in_array(CacheResults::class, $traits)) {
//            // Reset caching to enabled in case it has just been disabled.
//            $this->caching = true;
//        }
//
//        if (in_array(ThrowsHttpExceptions::class, $traits)) {
//
//            if ($this->shouldThrowHttpException($result, $methodName)) {
//                $this->throwNotFoundHttpException($methodName, $arguments);
//            }
//
//            $this->exceptionsDisabled = false;
//        }
//
//        return $result;
//    }

    /**
     * @return int
     */
    protected function getCacheTtl()
    {
        return $this->cacheTtl;
    }

    /**
     * @return $this
     */
//    protected function setUses()
//    {
//        $this->uses = array_flip(class_uses_recursive(get_class($this)));
//
//        return $this;
//    }
//
//    /**
//     * @return array
//     */
//    protected function getUsedTraits()
//    {
//        return $this->uses;
//    }
}
