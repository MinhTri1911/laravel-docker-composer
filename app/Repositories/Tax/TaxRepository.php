<?php

/**
 * Tax management Repository
 *
 * @package App\Repositories\Billing
 * @author Rikkei.Quangpm
 * @date 2018/08/06
 */

namespace App\Repositories\Tax;

use App\Repositories\EloquentRepository;
use App\Models\THistoryBilling;
use Illuminate\Support\Facades\DB;
use App\Common\Constant;

class TaxRepository extends EloquentRepository implements TaxInterface
{
    /**
     * Set model billing for interface
     *
     * @return string \App\Models\THistoryBilling
     */
    public function getModel()
    {
        return T::class;
    }

    /**
     * Get list tax master
     *
     * @return null|object
     */
    public function getListTaxMaster()
    {
        return null;
    }

    /**
     * Get information tax by Id
     *
     * @access public
     * @param int $id Tax Id
     * @return mixed Illuminate\Support\Collection
     */
    public function getTaxById($id)
    {
        return null;
    }

}
