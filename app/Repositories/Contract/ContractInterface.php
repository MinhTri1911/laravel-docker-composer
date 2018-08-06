<?php

/*
 * File Company Interface
 * Define function for contract repository
 * @package App\Repositories\Contract
 * @author Rikkei.datPDT
 * @date 2018/07/02
 */
namespace App\Repositories\Contract;

interface ContractInterface {

    /**
     * Function create
     * @access public
     * @param arr data
     * @return mixed
     */
    public function createContract($data);

    /**
     * Function get contract id by company id and service id
     * @param int companyId
     * @param int serviceId
     * @return mixed this
     */
    public function selectContractIds($companyId, $serviceIds);

    /**
     * Function delete contract
     * @param array ids
     * @param string|null column
     * @return boolean
     */
    public function deleteContract($ids, $column = null);

    /**
     * Function update delete contract
     * @param array ids
     * @param array data
     * @param string|null column
     * @return boolean
     */
    public function updateDeleteContract($ids, $data, $column = null);

    /**
     * Function get contract id not yet delete by company id and service id
     * @param int companyId
     * @param array serviceId
     * @return mixed
     */
    public function selectContractIdsNotYetDelete($companyId, $serviceIds);

    /**
     * Function get new contract watting approved
     * @param int companyId
     * @param array serviceIds
     * @return array
     */
    public function getNewContractByCompanyAndService($companyId, $serviceIds);

    /**
     * Function get contract id with company id and service id
     * @param int companyId
     * @param array serviceIds
     * @return array
     */
    public function getContractActiveOrPendingById($companyId, $serviceIds);

    /**
     * Function select service not delete or not expired
     * @param int companyId
     * @param array columns
     * @return Collection
     */
    public function selectServiceNotDeleteOfCompany($companyId, $columns = ['*']);

    /**
     * Function check exists contract in company is watting approve with update_at not null
     * @param int companyId
     * @param array serviceIds
     * @param boolean
     */
    public function checkHaveContractWattingApproveById($companyId, $serviceIds);

    /**
     * Get contract of ship
     *
     * @access public
     * @param int $idShip
     * @param int|array $idContract
     * @return mixed Illuminate\Support\Collection
     */
    public function getContract($idShip = null, $idContract = '');

    /**
     * Get list spot of ship
     *
     * @access public
     * @param int $shipId
     * @param array $param
     * @return mixed Illuminate\Support\Collection
     */
    public function getSpotOfShip($shipId = null, $param = null);

        /**
     * Get list spot of ship
     *
     * @access public
     * @param int $shipId
     * @param array $param
     * @return mixed Illuminate\Support\Collection
     */
    public function updateContract($contractId = null, $param = null);

    /**
     * Insert Spot into for ship contract
     *
     * @access public
     * @param array $data
     * @return Illuminate/Database/Query/Builder
     */
    public function insertSpotForShipContract($data);

    /**
     * Function get contract after insert
     *
     * @param array $condition
     * @param array $serviceIds
     * @param array $columns
     * @return Collection
     */
    public function getContractAfterInsert($condition, $serviceIds, $columns = ['*']);
    
    /**
     * Check exists contract was enabled with this ship
     * 
     * @access public
     * @param array $config
     * @return boolean
     */
    public function getAllContractEnablingOfShip($shipId, $serviceId, $oldContract = null);
}
