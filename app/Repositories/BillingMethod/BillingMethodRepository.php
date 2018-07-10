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

class BillingMethodRepository extends EloquentRepository implements BillingMethodInterface
{
    public function getModel()
    {
        return MBillingMethod::class;
    }
}
