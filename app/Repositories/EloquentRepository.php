<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $_model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $model = app()->make($this->getModel());

        if (!$model instanceof Model) throw new Exception('Model must be instance of Illuminate\Database\Eloquent\Model');

        $this->_model = $model;
    }

    /**
     * Cast eloquent to query builder, use in first query like $this->builder()->where()->get()
     *
     * @return mixed
     */
    public function builder()
    {
        $this->_model = $this->_model->newQuery();

        return $this;
    }

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        $result = $this->_model->all();
        // reset the model after get all
        $this->setModel();

        return $result;
    }

    /**
     * Select columns to get
     *
     * @param array $colums
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(array $columns = ['*'])
    {
        $result = $this->_model->get($columns);
        // reset the model after get all
        $this->setModel();

        return $result;
    }

    /**
     * Execute the query and get the first result.
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function first(array $columns = ['*'])
    {
        $result = $this->_model->first($columns);
        // reset the model after get all
        $this->setModel();

        return $result;
    }

    /**
     * Find a model by its primary key.
     * @param $id
     * @return Model|Collection|null
     */
    public function find($id)
    {
        $result = $this->_model->find($id);
        // reset the model after find
        $this->setModel();

        return $result;
    }

    /**
     * Find a model by its primary key
     * @param $id, $columns
     * @throws ModelNotFoundException
     * @return Model|Collection
     */
    public function findOrFail($id, array $columns = ['*'])
    {
        $result = $this->_model->findOrFail($id, $columns);
        // reset the model after find
        $this->setModel();

        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->_model->create($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);

        if ($result) {
            $result->update($attributes);

            return $result;
        }

        return false;
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);

        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    /**
     * Lock
     *
     * @param $id
     * @return bool
     */
    public function lock($id)
    {
        $result = $this->find($id);

        if ($result) {
            if ($result->active == 1) {
                $result->active = 0;
            } else {
                $result->active = 1;
            }

            $result->save();

            return true;
        }

        return false;
    }

    /**
     * Where
     *
     * @param $column, $value, $option = null
     * @return mixed
     */
    public function where($column, $value = null, $option = null)
    {
        $this->_model = $this->_model->where($column, $value, $option);

        return $this;
    }

    /**
     * Or Where
     *
     * @param $column, $value, $option = null
     * @return mixed
     */
    public function orWhere($column, $value = null, $option = null)
    {
        $this->_model = $this->_model->orWhere($column, $value, $option);

        return $this;
    }

    /**
     * Where in
     *
     * @param $column, $array
     * @return mixed
     */
    public function whereIn($column, $array = [])
    {
        $this->_model = $this->_model->whereIn($column, $array);

        return $this;
    }

    /**
     * Or where in
     *
     * @param $column, $array
     * @return mixed
     */
    public function orWhereIn($column, $array)
    {
        $array = is_array($array) ? $array : [$array];

        $this->_model = $this->_model->orWhereIn($column, $array);

        return $this;
    }

    /**
     * Where null
     *
     * @param string column
     * @param string boolean
     * @param bool not
     * @return mixed
     */
    public function whereNull($column, $boolean = 'and', $not = false)
    {
        $this->_model = $this->_model->whereNull($column, $boolean, $not);

        return $this;
    }

    /**
     * Or where null
     *
     * @param string column
     * @return mixed
     */
    public function orWhereNull($column)
    {
        $this->_model = $this->_model->orWhereNull($column);

        return $this;
    }

    /**
     * Check result is exists
     *
     * @return boolean
     */
    public function exists()
    {
        $result = $this->_model->exists();
        // reset the model after check
        $this->setModel();

        return $result;
    }

    /**
     * Inner join table
     * @param string table
     * @param string first
     * @param string operator
     * @param string second
     * @return mixed
     */
    public function join($table, $first, $operator = null, $second = null)
    {
        $this->_model = $this->_model->join($table, $first, $operator, $second);

        return $this;
    }

    /**
     * Left join table
     * @param string table
     * @param string first
     * @param string operator
     * @param string second
     * @return mixed
     */
    public function leftJoin($table, $first, $operator = null, $second = null)
    {
        $this->_model = $this->_model->leftJoin($table, $first, $operator, $second);

        return $this;
    }

    /**
     * Right join table
     * @param string table
     * @param string first
     * @param string operator
     * @param string second
     * @return mixed
     */
    public function rightJoin($table, $first, $operator = null, $second = null)
    {
        $this->_model = $this->_model->rightJoin($table, $first, $operator, $second);

        return $this;
    }

    /**
     * Pagination
     * @param int limit
     * @param array columns
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($limit, $columns = ['*'])
    {
        $model = $this->_model->paginate($limit, $columns);
        $this->setModel();

        return $model;
    }

    /**
     * Group
     * @param array groups
     * @return mixed
     */
    public function groupBy($groups)
    {
        $groups = is_array($groups) ? $groups : [$groups];
        $this->_model = $this->_model->groupBy($groups);

        return $this;
    }

    /**
     * Count
     * @param string columns
     * @return int
     */
    public function count($columns = '*')
    {
        $count = $this->_model->count($columns);
        $this->setModel();

        return $count;
    }

    /**
     * Select columns
     * @param array columns
     * @return mixed
     */
    public function select($columns = ['*'])
    {
        $this->_model = $this->_model->select($columns);

        return $this;
    }

    /**
     * Select distinct record
     * @return mixed
     */
    public function distinct()
    {
        $this->_model = $this->_model->distinct();

        return $this;
    }

    /**
     * Order by
     * @param string column
     * @param string direction
     * @return mixed
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->_model = $this->_model->orderBy($column, $direction);

        return $this;
    }

    /**
     * Debug function, print DB query
     *
     * @return string
     */
    public function toSql()
    {
        return $this->_model->toSql();
    }

    /**
     * Insert multi record
     * @param array data
     * @return bool
     */
    public function insert($data)
    {
        return $this->_model->insert($data);
    }

    /**
     * Update multi record
     * @param array ids
     * @param array data
     * @param string column
     * @return bool
     */
    public function multiUpdate($ids, $data = [], $column = null)
    {
        $ids = is_array($ids) ? $ids : [$ids];

        if ($column) {
            return $this->_model->whereIn($column, $ids)->update($data);
        }

        return $this->_model->whereIn('id', $ids)->update($data);
    }
}
