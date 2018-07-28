<?php

/**
 * File currency business
 *
 * Handle business related to currency
 * @package App\Business
 * @author Rikkei.Trihnm
 * @date 2018/07/27
 */

namespace App\Business;

use App\Repositories\MCurrency\MCurrencyInterface;

class CurrencyBusiness
{
    private $_currencyRepository;

    public function __construct(MCurrencyInterface $currency)
    {
        $this->_currencyRepository = $currency;
    }

    /**
     * Function search currency by code or id
     *
     * @param array $data
     * @return Collection
     */
    public function searchCurrencyByIdOrCode($data = [])
    {
        if (empty($data['currency-id'])) {
            $data['currency-id'] = null;
        }

        if (empty($data['currency-code'])) {
            $data['currency-code'] = null;
        }

        return $this->_currencyRepository->getCurrencyByIdOrCode($data['currency-id'], $data['currency-code'], ['id', 'code']);
    }
}
