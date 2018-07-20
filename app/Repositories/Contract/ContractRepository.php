<?php

/**
 * File contract repository
 *
 * Handle eloquent query builder contract
 * @package App\Repositories\Contract
 * @author Rikkei.trihnm
 * @date 2018/07/11
 */

namespace App\Repositories\Contract;

use App\Repositories\EloquentRepository;
use App\Models\MContract;
use App\Common\Constant;

class ContractRepository extends EloquentRepository implements ContractInterface
{
    /**
     * Function get path model
     * @access public
     * @return string model
     */
    public function getModel()
    {
        return MContract::class;
    }

    /**
     * Function create
     * @access public
     * @param arr data
     * @return mixed
     */
    public function createContract($data)
    {
        // Check company and ship is available
        $checkExists = \DB::table('m_ship')
            ->join('m_company', 'm_company.id', 'm_ship.company_id')
            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE)
            ->where('m_ship.id', $data['ship_id'])
            ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE)
            ->exists();

        if (!$checkExists) {
            throw new \Exception("Error create contract when company or ship does not exists");
        }

        $contact = new $this->_model;
        $contact->ship_id = $data['ship_id'];
        $contact->currency_id = $data['currency_id'];
        $contact->service_id = $data['service_id'];
        $contact->start_date = $data['start_date'];
        $contact->end_date = $data['end_date'];
        $contact->remark = $data['remark'];
        $contact->approved_flag = Constant::STATUS_WAITING_APPROVE;
        $contact->created_by = auth()->id();
        $contact->revision_number = 1;
        $contact->updated_at = null;
        $contact->save();

        return $contact->id;
    }

    /**
     * Function edit
     * @access public
     * @param arr data
     * @return mixed
     */
    public function editContract($data) {

    }

    /**
     * Function get contract id by company id and service id
     * @param int companyId
     * @param array serviceIds
     * @return mixed
     */
    public function selectContractIds($companyId, $serviceIds)
    {
        return $this->select(['m_contract.id'])
            ->join('m_ship', 'm_ship.id', 'm_contract.ship_id')
            ->join('m_company', function ($join) use ($companyId) {
                $join->on('m_company.id', 'm_ship.company_id')
                    ->on('m_company.currency_id', 'm_contract.currency_id')
                    ->where('m_company.id', $companyId)
                    ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE);
            })
            ->whereIn('m_contract.service_id', $serviceIds);
    }

    /**
     * Function get contract id not yet delete by company id and service id
     * @param int companyId
     * @param array serviceId
     * @return mixed
     */
    public function selectContractIdsNotYetDelete($companyId, $serviceIds)
    {
        return $this->selectContractIds($companyId, $serviceIds)->whereNull('m_contract.deleted_at');
    }

    /**
     * Function get new contract watting approved
     * @param int companyId
     * @param array serviceIds
     * @return array
     */
    public function getNewContractByCompanyAndService($companyId, $serviceIds)
    {
        return $this->selectContractIdsNotYetDelete($companyId, $serviceIds)
            ->whereIn('m_contract.approved_flag', [Constant::STATUS_WAITING_APPROVE, Constant::STATUS_REJECT_APPROVE])
            ->where('m_contract.status', Constant::STATUS_CONTRACT_ACTIVE)
            ->whereNull('m_contract.updated_at')
            ->get()
            ->toArray();
    }

    /**
     * Function get contract id with company id and service id
     * @param int companyId
     * @param array serviceIds
     * @return array
     */
    public function getContractActiveOrPendingById($companyId, $serviceIds)
    {
        return $this->selectContractIdsNotYetDelete($companyId, $serviceIds)
            ->whereIn('m_contract.approved_flag', [Constant::STATUS_APPROVED, Constant::STATUS_REJECT_APPROVE])
            ->whereIn('m_contract.status', [Constant::STATUS_CONTRACT_ACTIVE, Constant::STATUS_CONTRACT_PENDING])
            ->whereNotNull('m_contract.updated_at')
            ->get()
            ->toArray();
    }

    /**
     * Function delete contract
     * @param array ids
     * @param string|null column
     * @return boolean
     */
    public function deleteContract($ids, $column = null)
    {
        return $this
            ->whereIn('approved_flag', [Constant::STATUS_WAITING_APPROVE, Constant::STATUS_REJECT_APPROVE])
            ->whereNull('updated_at')
            ->where('status', Constant::STATUS_CONTRACT_ACTIVE)
            ->multiDelete($ids, $column);
    }

    /**
     * Function update delete contract watting approve
     * @param array ids
     * @param array data
     * @param string|null column
     * @return boolean
     */
    public function updateDeleteContractWattingApprove($ids, $data, $column = null)
    {
        $data = is_array($data) ? $data : [$data];

        return $this
            ->whereIn('approved_flag', [Constant::STATUS_APPROVED, Constant::STATUS_REJECT_APPROVE])
            ->whereIn('status', [Constant::STATUS_CONTRACT_ACTIVE, Constant::STATUS_CONTRACT_PENDING])
            ->whereNotNull('m_contract.updated_at')
            ->multiUpdate($ids, $data, $column);
    }

    /**
     * Function select service of company
     * @param int companyId
     * @param array columns
     * @return Collection
     */
    public function selectServiceOfCompany($companyId, $columns = ['*'])
    {
        return $this->select($columns)
            ->join('m_service', 'm_service.id', 'm_contract.service_id')
            ->join('m_ship', 'm_ship.id', 'm_contract.ship_id')
            ->where('m_ship.company_id', $companyId)
            ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE)
            ->where(function ($query) {
                return $query->where('m_contract.status', Constant::STATUS_CONTRACT_ACTIVE)
                    ->orWhere('m_contract.status', Constant::STATUS_CONTRACT_PENDING);
            })
            ->whereNull('m_contract.deleted_at')
            ->groupBy(['m_contract.service_id'])
            ->get();
    }

    /**
     * Function select service not watting approve of company
     * @param int companyId
     * @param array columns
     * @return Collection
     */
    public function selectServiceNotWattingApproveOfCompany($companyId, $columns = ['*'])
    {
        return $this->select($columns)
            ->join('m_service', 'm_service.id', 'm_contract.service_id')
            ->join('m_ship', 'm_ship.id', 'm_contract.ship_id')
            ->leftJoin('m_contract as contract', function ($join) {
                $join->on('contract.id', '=', 'm_contract.id')
                    ->where('contract.approved_flag', Constant::STATUS_WAITING_APPROVE)
                    ->whereNotNull('contract.updated_at');
            })
            ->where('m_ship.company_id', $companyId)
            ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE)
            ->where(function ($query) {
                return $query->where('m_contract.status', Constant::STATUS_CONTRACT_ACTIVE)
                    ->orWhere('m_contract.status', Constant::STATUS_CONTRACT_PENDING);
            })
            ->whereNull('m_contract.deleted_at')
            ->whereNull('contract.id')
            ->groupBy(['m_contract.service_id'])
            ->get();
    }

    /**
     * Function check exists contract in company is watting approve with update_at not null
     * @param int companyId
     * @param array serviceIds
     * @param boolean
     */
    public function checkHaveContractWattingApproveById($companyId, $serviceIds)
    {
        return $this->selectContractIds($companyId, $serviceIds)
            ->where('m_contract.approved_flag', Constant::STATUS_WAITING_APPROVE)
            ->whereNotNull('m_contract.updated_at')
            ->exists();
    }
}
