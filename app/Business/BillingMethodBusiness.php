<?php

/**
 * File billing method business
 *
 * Handle business billing method
 * @package App\Business
 * @author Rikkei.trihnm
 * @date 2018/07/10
 */

namespace App\Business;

use App\Repositories\BillingMethod\BillingMethodInterface;

class BillingMethodBusiness
{
    protected $billingMethodRepository;

    public function __construct(BillingMethodInterface $billingMethod)
    {
        $this->billingMethodRepository = $billingMethod;
    }

    /**
     * Function get all billing method
     * @param int currencyId
     * @return Collection
     */
    public function getAllBillingMethodForCompany($currencyId)
    {
        return $this->billingMethodRepository
            ->select([
                'id',
                'name_jp',
                'name_en',
            ])
            ->where('currency_id', $currencyId)
            ->get();
    }

    /**
     * Function check billing method id exists
     * @param int id
     * @return boolean
     */
    public function checkBillingMethodExists($id)
    {
        return $this->billingMethodRepository->where('id', $id)->exists();
    }

    /**
     * Function check new billing method is valid
     * @param int newId
     * @param int oldCurrency
     * @return boolean
     */
    public function compareCurrencyId($newId, $oldCurrency)
    {
        $currencyId = $this->billingMethodRepository->findOrFail($newId, ['currency_id'])->currency_id;

        return $currencyId === $oldCurrency;
    }
}
