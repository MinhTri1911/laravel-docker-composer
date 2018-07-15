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
use App\Common\Constant;

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
     * @param int currencyId
     * @return Collection
     */
    public function showAllService($currencyId)
    {
        // Get all service
        return $this->serviceRepository->getListService($currencyId);
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
        $this->shipRepository = app(ShipInterface::class);

        // Get all ship is not have service id
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

        // Loop for set parameter for ship not have service id has been selected
        foreach ($allShipNotHaveService as $shipId) {
            $dataInsert[] = [
                'ship_id' => $shipId['id'],
                'service_id' => $serviceId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => Constant::STATUS_CONTRACT_ACTIVE,
                'approved_flag' => Constant::STATUS_WAITING_APPROVE,
                'currency_id' => $currencyId,
                'revision_number' => 1,
            ];
        }

        // Insert new contract
        $this->contractRepository->insert($dataInsert);

        return $dataInsert;
    }

    /**
     * Function get all service of company
     * @param int companyId
     * @return
     */
    public function getAllServiceOfCompany($companyId)
    {
        $this->contractRepository = app(ContractInterface::class);

        return $this->contractRepository
            ->select([
                'm_contract.service_id',
                'm_service.name_jp',
                'm_service.name_en',
            ])
            ->join('m_service', 'm_service.id', 'm_contract.service_id')
            ->join('m_ship', 'm_ship.id', 'm_contract.ship_id')
            ->where('m_ship.company_id', $companyId)
            ->where(function ($query) {
                return $query->where('m_contract.status', Constant::STATUS_CONTRACT_ACTIVE)
                    ->orWhere('m_contract.status', Constant::STATUS_CONTRACT_PENDING);
            })
            ->whereNull('m_contract.deleted_at')
            ->groupBy(['m_contract.service_id'])
            ->get();
    }

    /**
     * Function delete services
     * @param array serviceIds
     * @param int companyId
     * @param array serviceExists
     * @throws Exception
     * @return boolean
     */
    public function deleteService($serviceIds, $companyId, $serviceExists)
    {
        // Check param is array
        $serviceIds = is_array($serviceIds) ? $serviceIds : [$serviceIds];

        // Check can delete service id
        foreach ($serviceIds as $serviceId) {
            if (!in_array($serviceId, $serviceExists)) {
                throw new \Exception("Service id is not valid");
            }
        }

        // Get instance object from service container
        $this->contractRepository = app(ContractInterface::class);

        $reasonDelete = [
            'status' => Constant::STATUS_CONTRACT_DELETE,
            'deleted_at' => \Carbon\Carbon::now()->format('Y-m-d'),
        ];

        // Get contract id with ship id and service id
        $contractIds = $this->contractRepository
            ->select(['m_contract.id'])
            ->join('m_ship', 'm_ship.id', 'm_contract.ship_id')
            ->join('m_company', function ($join) use ($companyId) {
                $join->on('m_company.id', 'm_ship.company_id')
                    ->on('m_company.currency_id', 'm_contract.currency_id')
                    ->where('m_company.id', $companyId);
            })
            ->whereIn('m_contract.service_id', $serviceIds)
            ->get()
            ->toArray();

        // Update contract watting for approved delete
        $this->contractRepository
            ->multiUpdate(array_column($contractIds, 'id'), [
                'approved_flag' => Constant::STATUS_WAITING_APPROVE,
                'reason_reject' => json_encode($reasonDelete),
            ]);
    }

    /**
     * Function delete service in company
     * @param array serviceIds
     * @param int companyId
     * @throws Exception
     * @return boolean
     */
    public function deleteServiceInCompany($serviceIds, $companyId)
    {
        // Get all service of company
        $serviceExists = $this->getAllServiceOfCompany($companyId)->toArray();

        // Detech get service id to array
        $serviceExists = array_column($serviceExists, 'service_id');

        return $this->deleteService($serviceIds, $companyId, $serviceExists);
    }

    /**
     * Function delete all service in company
     * @param int companyId
     * @return boolean
     */
    public function deleteAllService($companyId)
    {
        // Get all service of company
        $serviceExists = $this->getAllServiceOfCompany($companyId)->toArray();

        // Detech get service id to array
        $serviceExists = array_column($serviceExists, 'service_id');

        return $this->deleteService($serviceExists, $companyId, $serviceExists);
    }
}
