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
use DB;

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
     * Function get new contract waiting approved
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
     * @param array id
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
     * Function update delete contract waiting approve
     * @param array id
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

    /**
     * Get contract of ship
     *
     * @access public
     * @param int $idShip
     * @param int|array $idContract
     * @return mixed Illuminate\Support\Collection
     */
    public function getContract($idShip = null, $idContract = '', $paramCondition = null)
    {
        // Query get contract
        $contract = DB::table('m_contract')
                ->join('m_ship', function($join) {
                    $join->on('m_ship.id', '=', 'm_contract.ship_id')
                    ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                // Check company sync to ship
                ->join('m_company', function($join) use ($paramCondition) {
                    if (isset($paramCondition['company']) && count($paramCondition['company']) > 0) {
                        $join->on('m_ship.company_id', '=', 'm_company.id')
                            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE)
                            ->whereIn('m_company.id', $paramCondition['company']);
                        unset($paramCondition['company']);
                    } else {
                        $join->on('m_ship.company_id', '=', 'm_company.id')
                            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE);
                    }
                })
                ->join('m_service', function($join) {
                    $join->on('m_service.id', '=', 'm_contract.service_id')
                        ->where('m_service.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('t_price_service', function($join) {
                    $join->on('m_service.id', '=', 't_price_service.service_id')
                        ->where('t_price_service.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_nation', function($join) {
                    $join->on('m_ship.nation_id', '=', 'm_nation.id')
                            ->where('m_nation.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_currency', function($join) {
                    $join->on('m_company.currency_id', '=', 'm_currency.id')
                            ->where('m_currency.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->select([
                    "m_contract.id as contract_id",
                    "m_contract.revision_number as contract_revision_number",
                    "m_contract.start_date as contract_date_start",
                    "m_contract.end_date as contract_date_end",
                    "m_contract.status as contract_status",
                    "m_contract.approved_flag as contract_approved_flag",
                    "m_contract.reason_reject as contract_reason_reject",
                    "m_contract.created_at as contract_created_at",
                    "m_contract.updated_at as contract_updated_at",
                    "m_contract.approved_flag as contract_approved_flag",
                    "m_contract.remark as contract_remark",
                    "m_service.id as contract_service_id",
                    "m_service.name_jp as contract_service_name",
                    "m_ship.id as contract_ship_id",
                    "m_ship.name as contract_ship_name",
                    'm_currency.id as contract_currency_id',
                    'm_currency.code as contract_currency_name',
                    DB::raw(
                        "DATE_FORMAT(m_contract.start_date, '%Y/%m/%d') as contract_start_date, "
                        . "DATE_FORMAT(m_contract.end_date, '%Y/%m/%d') as contract_end_date")
                ])
                ->whereIn('approved_flag', [
                    Constant::STATUS_APPROVED,
                    Constant::STATUS_REJECT_APPROVE]);

        // Check if get all contract inside all ship
        if (empty($idShip) || is_null($idShip)) {
            if (!empty($idContract) && !is_null($idContract)) {
                if (is_array($idContract))
                    return $contract
                                    ->whereIn('m_contract.id', $idContract)
                                    ->get();
                return $contract
                                ->where('m_contract.id', $idContract)
                                ->first();
            }

            return $contract->get();
        }

        // If get contract inside a ship
        if (!empty($idContract) && !is_null($idContract)) {
            if (is_array($idContract))
                return $contract
                                ->whereIn('m_contract.id', $idContract)
                                ->where('m_ship.id', $idShip)
                                ->get();
            return $contract
                            ->where('m_contract.id', $idContract)
                            ->where('m_ship.id', $idShip)
                            ->first();
        }

        return $contract
                        ->where('m_ship.id', $idShip)
                        ->get();
    }

    /**
     * Get list spot of ship
     *
     * @access public
     * @param int $shipId
     * @param array $param
     * @return mixed Illuminate\Support\Collection
     */
    public function getSpotOfShip($shipId = null, $param = null)
    {
        $spot = DB::table('t_ship_spot')
                ->join('m_ship', function($join) use ($param) {
                    $join->on('t_ship_spot.ship_id', '=', 'm_ship.id')
                            ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_spot', function($join) {
                    $join->on('m_spot.id', '=', 't_ship_spot.spot_id')
                        ->where('m_spot.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->where([
                    'm_ship.id' => $shipId
                ]);

        if (isset($param['idSpot'])) {
            $spot = $spot->whereIn('t_ship_spot', $param['idSpot']);
        }

        return $spot;
    }

    /**
     * Get list spot of ship
     *
     * @access public
     * @param int $shipId
     * @param array $param
     * @return mixed Illuminate\Support\Collection
     */
    public function updateContract($contractId = null, $dataUpdate = [])
    {
        return DB::table('m_contract')
                ->where([
                    'm_contract.id' => $contractId
                ])
                ->update($dataUpdate);
    }

    /**
     * Insert Spot into for ship contract
     *
     * @access public
     * @param array $data
     * @return Illuminate/Database/Query/Builder
     */
    public function insertSpotForShipContract($data) {
        return DB::table('t_ship_spot')
                ->insert($data);
    }

    /**
     * Function get contract after insert
     *
     * @param array $condition
     * @param array $serviceIds
     * @param array $columns
     * @return Collection
     */
    public function getContractAfterInsert($condition, $serviceIds, $columns = ['*'])
    {
        return $this->select($columns)
            ->where($condition)
            ->whereIn('service_id', $serviceIds)
            ->get();
    }
}
