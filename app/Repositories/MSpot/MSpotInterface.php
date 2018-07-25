<?php

/**
 * Ship management Interface
 *
 * @package App\Repositories\TShipSpot
 * @author Rikkei.DatPDT
 * @date 2018/07/05
 */

namespace App\Repositories\MSpot;

interface MSpotInterface 
{
    /**
     * Select MSpot by currency id
     * @access public
     * @param int $currency_id
     * @return mixed Illuminate\Support\Collection
    */
    public function getMSpotByCurrencyId($currency_id);
    
    
     /**
     * Select charge by spot id and currency id
     * @access public
     * @param int $currency_id
     * @param int $spot_id
     * @return mixed Illuminate\Support\Collection
    */
    public function getCharge($currency_id, $spot_id);
    
    /**
     * Function check exits spot by $spot_id
     * @access public
     * @param int $spot_id
     * @return boolen
    */
    public function checkExits($spot_id);
    
    /**
     * Function get exists spot with same currency with company
     * @param int companyId
     * @return Collection
     */
    public function getExistsSpotWithCurrency($companyId) ;
}