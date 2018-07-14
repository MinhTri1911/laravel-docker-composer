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
     * @access public
     * @return mixed
     */
    public function builder();

    /**
     * Get all
     * @access public
     * @return mixed
     */
    public function getAll();

    /**
     * Get one
     * @param int id
     * @access public
     * @return mixed
     */
    public function find($id);

    /**
     * Select columns to get
     * @access public
     * @param array columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(array $colums = ['*']);

    /**
     * Execute the query and get the first result.
     * @access public
     * @param array columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function first(array $columns = ['*']);

    /**
     * Find a model by its primary key or throw an exception
     * @access public
     * @param $id, $columns
     * @return Model|Collection
     */
    public function findOrFail($id, array $columns = ['*']);

    /**
     * Create
     * @access public
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update
     * @access public
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes);

    /**
     * Delete
     * @access public
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Lock
     * @access public
     * @param $id
     * @return mixed
     */
    public function lock($id);

    /**
     * Where condition
     * @access public
     * @param  $column, $value, $option = null
     * @return mixed
     */
    public  function where($column, $value, $option = null);

    /**
     * orWhere
     * @access public
     * @param $column, $value, $option = null
     * @return mixed
     */
    public function orWhere($column, $value, $option = null);

    /**
     * Where in
     * @access public
     * @param $column, $array
     * @return mixed
     */
    public function whereIn($column, $array = []);

    /**
     * Check result is exists
     * @access public
     * @return boolean
     */
    public function exists();

    /**
     * Inner join table
     * @access public
     * @param string table
     * @param string first
     * @param string operator
     * @param string second
     * @return mixed
     */
    public function join($table, $first, $operator = null, $second = null);

    /**
     * Left join table
     * @access public
     * @param string table
     * @param string first
     * @param string operator
     * @param string second
     * @return mixed
     */
    public function leftJoin($table, $first, $operator = null, $second = null);

    /**
     * Right join table
     * @access public
     * @param string table
     * @param string first
     * @param string operator
     * @param string second
     * @return mixed
     */
    public function rightJoin($table, $first, $operator = null, $second = null);

    /**
     * Pagination
     * @access public
     * @param int limit
     * @param array columns
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($limit, $columns = ['*']);

    /**
     * Group
     * @access public
     * @param array groups
     * @return mixed
     */
    public function groupBy($groups);

    /**
     * Count
     * @access public
     * @param string columns
     * @return int
     */
    public function count($columns = '*');

    /**
     * Select columns
     * @access public
     * @param array columns
     * @return mixed
     */
    public function select($columns = ['*']);

    /**
     * Select distinct record
     * @access public
     * @return mixed
     */
    public function distinct();

    /**
     * Order by
     * @access public
     * @return mixed
     */
    public function orderBy($column, $direction = 'asc');

    /**
     * Where null
     *
     * @param string column
     * @param string boolean
     * @param bool not
     * @return mixed
     */
    public function whereNull($column, $boolean = 'and', $not = false);

    /**
     * Or where null
     *
     * @param string column
     * @return mixed
     */
    public function orWhereNull($column);

    /**
     * Insert multi record
     * @param array data
     * @return bool
     */
    public function insert($data);

    /**
     * Update multi record
     * @param array ids
     * @param array data
     * @param string column
     * @return bool
     */
    public function multiUpdate($ids, $data = [], $column = null);
}
