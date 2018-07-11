<?php

/**
 * File contract repository
 *
 * Handle eloquent query builder contract
 * @package App\Repositories\Contract
 * @author Rikkei.trihnm
 * @date 2018/07/11
 */

namespace App\Repositories\Contract;

use App\Repositories\EloquentRepository;
use App\Models\MContract;

class ContractRepository extends EloquentRepository implements ContractInterface
{
    /**
     * Function get path model
     * @access public
     * @return string model
     */
    public function getModel()
    {
        return MContract::class;
    }
}
