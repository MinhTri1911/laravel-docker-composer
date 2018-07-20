<?php

/**
 * File company service business
 *
 * Handle business related to company with service
 * @package App\Business
 * @author Rikkei.Trihnm
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
        return $this->serviceRepository->checkCurrencyService($serviceId, $currencyId);
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
        $allShipNotHaveService = $this->shipRepository->selectShipNotHaveService($companyId, $serviceId, ['m_ship.id']);

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
                'created_by' => auth()->id(),
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Insert new contract
        $this->contractRepository->insert($dataInsert);

        return true;
    }

    /**
     * Function get all service of company
     * @param int companyId
     * @return Collection
     */
    public function getAllServiceOfCompany($companyId)
    {
        $this->contractRepository = app(ContractInterface::class);

        return $this->contractRepository->selectServiceNotWattingApproveOfCompany($companyId, [
            'm_contract.service_id',
            'm_service.name_jp',
            'm_service.name_en',
        ]);
    }

    /**
     * Function delete services
     * @param array serviceIds
     * @param int companyId
     * @param array serviceExists
     * @throws Exception
     * @return boolean|null
     */
    public function deleteService($serviceIds, $companyId, $serviceExists)
    {
        // Check param is array
        $serviceIds = is_array($serviceIds) ? $serviceIds : [$serviceIds];

        // Check can delete service id
        foreach ($serviceIds as $serviceId) {
            if (!in_array($serviceId, $serviceExists)) {
                throw new \Exception("Service id is not valid", 500);
            }
        }

        // Check if not have service id
        if (empty($serviceIds)) {
            return null;
        }

        // Get instance object from service container
        if (!$this->contractRepository) {
            $this->contractRepository = app(ContractInterface::class);
        }

        // Select new contract watting approve or new contract have been reject
        $newContractIdWattingApproved = $this->contractRepository
            ->getNewContractByCompanyAndService($companyId, $serviceIds);

        if (!empty($newContractIdWattingApproved)) {
            $this->contractRepository->multiDelete(array_column($newContractIdWattingApproved, 'id'));
        }

        $reasonDelete = [
            'status' => Constant::STATUS_CONTRACT_DELETED,
            'deleted_at' => \Carbon\Carbon::now()->format('Y-m-d'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_by' => auth()->id(),
        ];

        /*
         * Get contract id with company id and service id
         * The contract was approved or contract have been reject then update else not select
         */
        $contractIds = $this->contractRepository->getContractActiveOrPendingById($companyId, $serviceIds);

        // Check company not have contract then return
        if (!empty($contractIds)) {
            // Update contract watting for approved delete
            $this->contractRepository->multiUpdate(array_column($contractIds, 'id'), [
                'approved_flag' => Constant::STATUS_WAITING_APPROVE,
                'reason_reject' => json_encode($reasonDelete),
            ]);
        }

        return true;
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
        $this->contractRepository = app(ContractInterface::class);

        // Get all service of company for check service id is valid in all service company using
        $serviceExists = $this->contractRepository->selectServiceOfCompany($companyId, [
            'm_contract.service_id',
        ])->toArray();

        // Detech get service id to array
        $serviceIdsExists = array_column($serviceExists, 'service_id');

        // Delete service id in company
        return $this->deleteService($serviceIds, $companyId, $serviceIdsExists);
    }

    /**
     * Function delete all service in company
     * @param int companyId
     * @return boolean|null
     */
    public function deleteAllService($companyId)
    {
        $this->contractRepository = app(ContractInterface::class);

        // Get all service of company for check service id is valid in all service company using
        $serviceExists = $this->contractRepository->selectServiceOfCompany($companyId, [
            'm_contract.service_id',
        ])->toArray();

        // Check if not have service id
        if (empty($serviceExists)) {
            return null;
        }

        // Detech get service id to array
        $serviceIdsExists = array_column($serviceExists, 'service_id');

        // Check can delete contract
        $this->_checkCanDeleteServices($companyId, $serviceIdsExists);

        // Delete all service
        return $this->deleteService($serviceIdsExists, $companyId, $serviceIdsExists);
    }

    /**
     * Function check can delete service
     * @param int companyId
     * @param int serviceIds
     * @throws Exception
     * @return boolean
     */
    private function _checkCanDeleteServices($companyId, $serviceIds)
    {
        if (!$this->contractRepository) {
            $this->contractRepository = app(ContractInterface::class);
        }

        // Select contract in company have approved_flag = 2 and updated_at not null
        $contractCanNotDelete = $this->contractRepository
            ->checkHaveContractWattingApproveById($companyId, $serviceIds);

        if ($contractCanNotDelete) {
            throw new \Exception(trans('error.w005_have_contract_watting_approve'));
        }

        return true;
    }
}
