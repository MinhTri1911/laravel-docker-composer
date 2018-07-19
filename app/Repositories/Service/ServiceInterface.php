<?php

/**
 * File Company Interface
 *
 * Define function for company repository
 * @package App\Repositories\Service
 * @author Rikkei.datPDT
 * @date 2018/07/02
 */

namespace App\Repositories\Service;

interface ServiceInterface
{
    /**
     * Function get list service by currencyId
     * @access public
     * @param int currencyId
     * @return mixed
    */
    public function getListService($currencyId);


    /**
     * Function get list service by currencyId and ShipId
     * @access public
     * @param int currencyId
     * @param int shipId
     * @return mixed
    */
    public function getListServiceByShipId($currencyId, $shipId);

    /**
     * Function search list service
     * @access public
     * @param int currencyId
     * @param int shipId
     * @param int idServiceSearch
     * @param string nameServiceSearch
     * @return mixed
    */
    public function searchListService($currencyId, $shipId , $idServiceSearch , $nameServiceSearch);

    /**
     * Function check exits service by idService
     * @access public
     * @param int $idService
     * @return boolen
    */
    public function checkExits($idService);

    /**
     * Function check exists currency of service by id
     * @param int serviceId
     * @param int currencyId
     * @return boolean
     */
    public function checkCurrencyService($serviceId, $currencyId);

}
