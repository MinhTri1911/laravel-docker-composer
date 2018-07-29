<?php

/**
 * File billing method repository
 *
 * Handle eloquent query builder billing method
 * @package App\Repositories\BillingMethod
 * @author Rikkei.trihnm
 * @date 2018/07/10
 */

namespace App\Repositories\BillingMethod;

use App\Repositories\EloquentRepository;
use App\Models\MBillingMethod;
use App\Common\Constant;

class BillingMethodRepository extends EloquentRepository implements BillingMethodInterface
{
    public function getModel()
    {
        return MBillingMethod::class;
    }

    /**
     * Function get billing method by currency
     * @param int currencyId
     * @param array columns
     * @return Collection
     */
    public function getBillingMethodByCurrency($currencyId, $columns = ['*'])
    {
        return $this->select($columns)
            ->where('currency_id', $currencyId)
            ->where('del_flag', Constant::DELETE_FLAG_FALSE)
            ->get();
    }

    /**
     * Function get all billing method
     *
     * @param array $columns
     * @return Collection
     */
    public function getAllBillingMethod($columns = ['*'])
    {
        return $this->where('del_flag', Constant::DELETE_FLAG_FALSE)->get($columns);
    }
}
