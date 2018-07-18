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
     * @param int serviceId
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
     * @param int serviceId
     * @return mixed
     */
    public function selectContractIdsNotYetDelete($companyId, $serviceIds)
    {
        return $this->selectContractIds($companyId, $serviceIds)->whereNull('m_contract.deleted_at');
    }
}
