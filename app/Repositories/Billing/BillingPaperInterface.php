<?php

/**
 * Billing Paper management Interface
 *
 * @package App\Repositories\Billing
 * @author Rikkei.Quangpm
 * @date 2018/07/11
 */

namespace App\Repositories\Billing;

interface BillingPaperInterface
{

    /**
     * Get information billing search
     *
     * @access public
     * @param array $models condition search
     * @return mixed Illuminate\Support\Collection
     */
    public function getListSearchBilling($models);

    /**
     * Get information billing paper by company Id
     *
     * @access public
     * @param int $companyId Company Id
     * @return mixed Illuminate\Support\Collection
     */
    public function getBillingPaperByCompanyId($companyId);

    /**
     * Get list history usage no create billing by company id
     *
     * @access public
     * @param int $companyId Company Id
     * @return mixed Illuminate\Support\Collection
     */
    public function getListHistoryUsageByCompanyId($companyId);

    /**
     * Create database create billing paper
     *
     * @access public
     * @param object $billingPaper Billing object
     * @return mixed Illuminate\Support\Collection
     */
    public function insertHistoryBilling($billingPaper);

    /**
     * Update database create billing paper
     *
     * @access public
     * @param object $billingPaper Billing object
     * @return mixed Illuminate\Support\Collection
     */
    public function updateHistoryBilling($billingPaper);

    /**
     * Get billing paper delivery by company id
     *
     * @access public
     * @param int $historyBillingId History billing Id
     * @return mixed Illuminate\Support\Collection
     */
    public function getBillingPaperDeliveryByHistoryBillingId($historyBillingId);

    /**
     * Update Flag delivered
     *
     * @access public
     * @param object $billingPaper object History billing
     * @return mixed Illuminate\Support\Collection
     */
    public function updateFlagDelivered($billingPaper);
}
