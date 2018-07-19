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
     * Function edit
     * @access public
     * @param arr data
     * @return mixed
     */
    public function editContract($data);

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
     * Function update delete contract watting approve
     * @param array ids
     * @param array data
     * @param string|null column
     * @return boolean
     */
    public function updateDeleteContractWattingApprove($ids, $data, $column = null);

    /**
     * Function select service of company
     * @param int companyId
     * @param array columns
     * @return Collection
     */
    public function selectServiceOfCompany($companyId, $columns = ['*']);

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
     * Function select service not watting approve of company
     * @param int companyId
     * @param array columns
     * @return Collection
     */
    public function selectServiceNotWattingApproveOfCompany($companyId, $columns = ['*']);

    /**
     * Function check exists contract in company is watting approve with update_at not null
     * @param int companyId
     * @param array serviceIds
     * @param boolean
     */
    public function checkHaveContractWattingApproveById($companyId, $serviceIds);
}
