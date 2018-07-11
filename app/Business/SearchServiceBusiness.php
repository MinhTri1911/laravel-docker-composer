<?php

/**
 * File service business
 *
 * Handle business related to service
 * @package App\Business
 * @author Rikkei.datPDT
 * @date 2018/07/10
 */

namespace App\Business;

use App\Repositories\Service\ServiceInterface;

class SearchServiceBusiness {

    protected $serviceRepository;

    public function __construct(ServiceInterface $serviceRepository) {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Business init search service
     * @access public
     * @param int currencyId
     * @param int shipId
     * @return data query
     */
    public function initSearchSevice($currencyId, $shipId) {
        
        $dataQuery = [];
        
        if ($shipId == null || $shipId == '') {
            $dataQuery = $this->serviceRepository->getListService($currencyId);
        } else {
            $dataQuery = $this->serviceRepository->getListServiceByShipId($currencyId, $shipId);
        }

        return $dataQuery;
    }
    
     /**
     * Business search service
     * @access public
     * @param int currencyId
     * @param int shipId
     * @param int idServiceSearch
     * @param string nameServiceSearch
     * @return data query
     */
    public function searchSevice($currencyId, $shipId, $idServiceSearch, $nameServiceSearch) {
        
        $dataQuery = [];
        
        $dataQuery = $this->serviceRepository->searchListService($currencyId,$shipId,$idServiceSearch,$nameServiceSearch);

        return $dataQuery;
    }

}
