<?php

namespace App\Repositories\Interfaces;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IBaseRepository
{
    /**
     * Get all items
     *
     * @param  string $columns specific columns to select
     * @param  string $orderBy column to sort by
     * @param  string $sort sort direction
     */
    public function getAll(string $columns = null, string $orderBy = 'created_at', string $sort = 'desc', array $whereConditions = []);

    /**
     * Get paged items
     *
     * @param  integer $paged Items per page
     * @param  string $orderBy Column to sort by
     * @param  string $sort Sort direction
     */
    public function getPaginated(int $paged = 15, string $orderBy = 'created_at', string $sort = 'desc');

    /**
     * Items for select options
     *
     * @param  string $data column to display in the option
     * @param  string $key column to be used as the value in option
     * @param  string $orderBy column to sort by
     * @param  string $sort sort direction
     * @return array           array with key value pairs
     */
    public function getForSelect($data, $key = 'id', $orderBy = 'created_at', $sort = 'desc');

    /**
     * Get item by its id
     *
     * @param  mixed $id
     */
    public function getById($id);

    /**
     * Get instance of model by column
     *
     * @param  mixed $term search term
     * @param  string $column column to search
     */
    public function getItemByColumn($term, $column = 'slug');

    /**
     * Get instance of model by column
     *
     * @param  mixed $term search term
     * @param  string $column column to search
     */
    public function getCollectionByColumn(string $term, string $column = 'slug', int $limit = 0);

    /**
     * Get item by id or column
     *
     * @param  mixed $term id or term
     * @param  string $column column to search
     */
    public function getActively($term, $column = 'slug');


    /**
     * Create new using mass assignment
     *
     * @param array $data
     */
    public function create(array $data);

    /**
     * Update or crate a record and return the entity
     *
     * @param array $identifiers columns to search for
     * @param array $data
     */
    public function updateOrCreate(array $identifiers, array $data);

    /**
     * Delete a record by it's ID.
     *
     * @param $id
     * @return bool
     */
    public function delete($id);
    public function insert(array $data): bool;
}
