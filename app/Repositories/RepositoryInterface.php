<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Cast eloquent to query builder, use in first query like $this->builder()->where()->get()
     *
     * @return mixed
     */
    public function builder();

    /**
     * Get all
     * @return mixed
     */
    public function getAll();

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Select columns to get
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(array $colums = ['*']);

    /**
     * Execute the query and get the first result.
     * @param $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function first(array $columns = ['*']);

    /**
     * Find a model by its primary key or throw an exception.
     * @param $id, $columns
     * @return Model|Collection
     */
    public function findOrFail($id, array $columns = ['*']);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Lock
     * @param $id
     * @return mixed
     */
    public function lock($id);

    /**
     * Where condition
     * @param  $column, $value, $option = null
     * @return mixed
     */
    public  function where($column, $value, $option = null);

    /**
     * orWhere
     *
     * @param $column, $value, $option = null
     * @return mixed
     */
    public function orWhere($column, $value, $option = null);

    /**
     * Where in
     *
     * @param $column, $array
     * @return mixed
     */
    public function whereIn($column, $array = []);

    /**
     * Check result is exists
     *
     * @return boolean
     */
    public function exists();

    /**
     * Inner join table
     * @param Type var table
     * @param Type var first
     * @param Type var operator
     * @param Type var second
     * @return mixed
     */
    public function join($table, $first, $operator = null, $second = null);

    /**
     * Left join table
     * @param Type var table
     * @param Type var first
     * @param Type var operator
     * @param Type var second
     * @return mixed
     */
    public function leftJoin($table, $first, $operator = null, $second = null);

    /**
     * Right join table
     * @param Type var table
     * @param Type var first
     * @param Type var operator
     * @param Type var second
     * @return mixed
     */
    public function rightJoin($table, $first, $operator = null, $second = null);

    /**
     * Pagination
     * @param Type int limit
     * @param Type array columns
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($limit, $columns = ['*']);

    /**
     * Group
     * @param Type array groups
     * @return mixed
     */
    public function groupBy($groups);

    /**
     * Count
     * @param Type var columns
     * @return int
     */
    public function count($columns = '*');

    /**
     * Select columns
     * @param Type array columns
     * @return mixed
     */
    public function select($columns = ['*']);

    /**
     * Select distinct record
     * @return mixed
     */
    public function distinct();

    /**
     * Order by
     *
     * @return mixed
     */
    public function orderBy($column, $direction = 'asc');
}
