<?php

/**
 * Ship management Interface
 *
 * @package App\Repositories\MCurrency
 * @author Rikkei.DatPDT
 * @date 2018/07/05
 */

namespace App\Repositories\MCurrency;

interface MCurrencyInterface
{
    /**
     * Select MCurrency by currency id
     * @access public
     * @param int $currency_id
     * @return mixed Illuminate\Support\Collection
    */
    public function getMCurrencyByCurrencyId($currency_id);

    /**
     * Function check exits currency by currency id
     * @access public
     * @param int $currency_id
     * @return boolen
    */
    public function checkExits($currency_id);

    /**
     * Function get all currency
     *
     * @param array $columns
     * @return Collection
     */
    public function getAllCurrency($columns = ['*']);
}
