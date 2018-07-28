<?php

/**
 * Define function hanlde in company operation
 *
 * File Company Interface
 * @package App\Repositories\CompanyOperation
 * @author Rikkei.Trihnm
 * @date 2018/07/27
 */

namespace App\Repositories\CompanyOperation;

interface CompanyOpeInterface
{
    /**
     * Function get company operation by permission
     *
     * @param array $columns
     * @throws Exception
     * @return Collection
     */
    public function getCompanyOperationByPermisstion($columns = ['*']);
}
