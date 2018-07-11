<?php

/**
 * File company service business
 *
 * Handle business related to company with service
 * @package App\Business
 * @author Rikkei.trihnm
 * @date 2018/07/11
 */

namespace App\Business;

use App\Repositories\Service\ServiceInterface;
use App\Repositories\Contract\ContractInterface;
use App\Repositories\Company\CompanyInterface;
use App\Repositories\Ship\ShipInterface;

class CompanyServiceBusiness
{
    protected $serviceRepository;
    protected $contractRepository;
    protected $companyRepository;
    protected $shipRepository;

    public function __construct(ServiceInterface $service)
    {
        $this->serviceRepository = $service;
    }

    /**
     * Fucntion get list service have t_price_service and same currency id with company
     * @param string|int urlOrCompanyId
     * @return Collection
     */
    public function showAllService($urlOrCompanyId)
    {
        // Detech string url or company Id return array and get first element of array
        preg_match('/[0-9]+/', $urlOrCompanyId, $currencyId);

        return $this->serviceRepository->getListService(head($currencyId));
    }

    /**
     * Function check service id
     * @param int serviceId
     * @param int currencyId
     * @return boolean
     */
    public function checkServiceId($serviceId, $currencyId)
    {
        return $this->serviceRepository
            ->join('t_price_service', 't_price_service.service_id', 'm_service.id')
            ->where('m_service.id', $serviceId)
            ->where('t_price_service.currency_id', $currencyId)
            ->exists();
    }

    /**
     * Function create service for all ship
     * @param int serviceId
     * @param int serviceId
     * @param string startDate
     * @param string endDate
     * @return boolean
     */
    public function createContractCompany($companyId, $serviceId, $startDate, $endDate, $currencyId)
    {
        $this->contractRepository = app(ContractInterface::class);
        $this->companyRepository = app(CompanyInterface::class);
        $this->shipRepository = app(ShipInterface::class);

        $allShipNotHaveService = $this->shipRepository->select([
                'm_ship.id',
            ])
            ->join('m_company', 'm_company.id', 'm_ship.company_id')
            ->leftJoin('m_contract', function ($join) use ($serviceId) {
                $join->on('m_contract.ship_id', '=', 'm_ship.id')
                    ->where('m_contract.service_id', $serviceId);
            })
            ->where('m_company.id', $companyId)
            ->whereNull('m_contract.id')
            ->get()
            ->toArray();

        $dataInsert = [];

        foreach ($allShipNotHaveService as $shipId) {
            $dataInsert[] = [
                'ship_id' => $shipId['id'],
                'service_id' => $serviceId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 0,
                'approved_flag' => 1,
                'currency_id' => $currencyId,
            ];
        }


        $this->contractRepository->insert($dataInsert);

        return $dataInsert;
    }
}
