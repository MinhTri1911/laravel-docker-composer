<?php

/**
 * File BillingMethod Interface
 *
 * Define function for billing method repository
 * @package App\Repositories\BillingMethod
 * @author Rikkei.trihnm
 * @date 2018/07/10
 */

namespace App\Repositories\BillingMethod;

interface BillingMethodInterface
{
    /**
     * Function get billing method by currency
     * @param int currencyId
     * @param array columns
     * @return Collection
     */
    public function getBillingMethodByCurrency($currencyId, $columns = ['*']);

    /**
     * Function get all billing method
     *
     * @param array $columns
     * @return Collection
     */
    public function getAllBillingMethod($columns = ['*']);
}
