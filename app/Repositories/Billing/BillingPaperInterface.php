<?php

/**
 * Billing Paper management Interface
 *
 * @package App\Repositories\Billing
 * @author Rikkei.quangpm
 * @date 2018/07/11
 */

namespace App\Repositories\Billing;

interface BillingPaperInterface
{
    /**
     * Get information billing
     *
     * @access public
     * @param array $models
     * @return mixed Illuminate\Support\Collection
     */
    public function getListSearchBilling($models);

}
