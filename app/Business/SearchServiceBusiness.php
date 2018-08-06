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
use App\Traits\CommonArray;

class SearchServiceBusiness
{
    use CommonArray;

    protected $serviceRepository;

    public function __construct(ServiceInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Business init search service
     * @access public
     * @param int currencyId
     * @param int shipId
     * @return data query
     */
    public function initSearchSevice($currencyId, $shipId, $serviceId = null)
    {
        $dataQuery = [];

        if ($shipId == null || $shipId == '') {
            $dataQuery = $this->serviceRepository->getListService($currencyId);
        } else {
            $dataQuery = $this->serviceRepository->getListServiceByShipId($currencyId, $shipId, $serviceId);
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
    public function searchSevice($currencyId, $shipId, $idServiceSearch, $nameServiceSearch, $serviceId)
    {
        $dataQuery = [];

        $dataQuery = $this->serviceRepository->searchListService(
                $currencyId, 
                $shipId, 
                $idServiceSearch, 
                $nameServiceSearch, 
                $serviceId);
        return $dataQuery;
    }

    /**
     * Function check service exists with currency
     * @param int companyId
     * @parama array serviceIds
     * @return boolean
     * @throws \Exception
     */
    public function checkServiceExistsWithCurrency($companyId, $serviceIds)
    {
        // Check company id is int and services is array
        if (!is_numeric($companyId) || !is_array($serviceIds)) {
            return false;
        }

        if (empty($serviceIds)) {
            return true;
        }

        $services = $this->serviceRepository->getServiceExistsWithCurrency($companyId);
        $servicesExists = array_column($services->toArray(), 'id');

        return $this->checkArrayExists($serviceIds, $servicesExists);
    }
}
