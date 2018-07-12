<?php

/*
 * File Company Interface
 * Define function for contract repository
 * @package App\Repositories\Contract
 * @author Rikkei.datPDT
 * @date 2018/07/02
 */
namespace App\Repositories\Contract;

interface ContractInterface {

    /**
     * Function create
     * @access public
     * @param arr data
     * @return mixed
     */
    public function createContract($data);

    /**
     * Function edit
     * @access public
     * @param arr data
     * @return mixed
     */
    public function editContract($data);
}
