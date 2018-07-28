<?php

/**
 * ShipContractBusiness.php
 *
 * Handle business and logic ship and contract data
 *
 * @package    ShipContract
 * @author     Rikkei.DungLV
 * @date       2018/07/03
 */

namespace App\Business;

use App\Repositories\Ship\ShipInterface;
use App\Common\Constant;
use DB;
use Illuminate\Support\Facades\Hash;
use Str;
use Illuminate\Support\Facades\Log;
use App\Common\Common;

class ShipContractBusiness
{

    // Property contain interface App\Repositories\Ship\ShipInterface
    protected $shipContract;

    // Number record per page
    const N_RECORD_PAGE = 10;

    /**
     * Inject dependency to Interface and repository
     *
     * @access public
     * @param App\Repositories\Ship\ShipInterface $shipContract
     * @return Object
     */
    public function __construct(ShipInterface $shipContract)
    {
        $this->shipContract = $shipContract;
    }

    /**
     * Get ship contract by id ship
     *
     * @access public
     * @param integer $id
     * @param Illuminate\Support\Facades\Request $request
     * @return Illuminate\Support\Collection Contain info of ship
     */
    public function getShipContractById($idShip = '', $request = null)
    {
        // If has limit paginate from request, set limit else set default constant
        if ($request->filled('limit') && is_numeric($request->get('limit')) && $request->get('limit') > 0){
            return (object)[
                'detail_ship' => $this->shipContract->getShip($idShip),
                'contracts' => $this->applyReasonRejectContract($this->shipContract->getContract($idShip)),
                'spots' => $this->applyReasonRejectSpot($this->shipContract->getSpot($idShip, null, $request->get('limit')))
            ];
        }

        return (object)[
            'detail_ship' => $this->shipContract->getShip($idShip),
            'contracts' => $this->applyReasonRejectContract($this->shipContract->getContract($idShip)),
            'spots' => $this->applyReasonRejectSpot($this->shipContract->getSpot($idShip, null, self::N_RECORD_PAGE)),
        ];
    }

    /**
     * Apply data from reason reject to collection
     *
     * @access public
     * @param Illuminate\Support\Collection $contract
     * @return Illuminate\Support\Collection
     */
    public function applyReasonRejectContract($contracts)
    {
        // Set data for list contracts
        if (!is_null($contracts) && count($contracts) > 1) {
            foreach ($contracts as $contract) {
                // Data reason reject exists if approve flag is pending approve
                if (!empty($contract->contract_reason_reject) && $contract->contract_approved_flag == Constant::STATUS_WAITING_APPROVE) {
                    $obj = json_decode($contract->contract_reason_reject);
                    $contract->contract_status = $obj->status ?? $contract->contract_status;
                    $contract->contract_revision_number = $obj->revision_number ?? $contract->contract_revision_number;
                    $contract->service_name = $obj->service_name ?? $contract->service_name;
                    $contract->contract_date_start = $obj->start_date ?? $contract->contract_date_start;
                    $contract->contract_date_end = $obj->end_date ?? $contract->contract_date_end;
                }
            }
        } else {
            // Set data for a contract specialic
            if (!empty($contracts->contract_reason_reject) && $contracts->contract_approved_flag == Constant::STATUS_WAITING_APPROVE) {
                $obj = json_decode($contracts->contract_reason_reject);
                $contracts->contract_status = $obj->status ?? $contracts->contract_status;
                $contracts->contract_revision_number = $obj->revision_number ?? $contracts->contract_revision_number;
                $contracts->service_name = $obj->service_name ?? $contracts->service_name;
                $contracts->contract_date_start = $obj->start_date ?? $contracts->contract_date_start;
                $contracts->contract_date_end = $obj->end_date ?? $contracts->contract_date_end;
            }
        }

        return $contracts;
    }

    /**
     * Apply data from reason reject to collection
     *
     * @access public
     * @param Illuminate\Support\Collection $spots
     * @return Illuminate\Support\Collection
     */
    public function applyReasonRejectSpot($spots = null)
    {
        // Set data for list contracts
        if (!is_null($spots) && count($spots) > 1) {
            foreach ($spots as $spot) {
                // Data reason reject exists if approve flag is pending approve
                if (!empty($spot->spot_reason_reject) && $spot->spot_approved_flag == Constant::STATUS_WAITING_APPROVE) {
                    $obj = json_decode($spot->spot_reason_reject);
                    $spot->spot_name = $obj->name_jp ?? $spot->spot_name;
                    $spot->spot_month_usage = $obj->month_usage ?? $spot->spot_month_usage;
                    if(is_null($spot->spot_amount_charge) || empty($spot->spot_amount_charge) && (empty($obj->amount_charge) || is_null($obj->amount_charge)))
                        $spot->spot_amount_charge = $spot->spot_master_charge;
                    else
                        $spot->spot_amount_charge = $obj->amount_charge ?? $spot->spot_amount_charge;
                }
            }
        } else {
            // Set data for a contract specialic
            if (!empty($spots->spot_reason_reject) && $spots->spot_approved_flag == Constant::STATUS_WAITING_APPROVE) {
                $obj = json_decode($spots->spot_reason_reject);
                $spots->spot_name = $obj->name_jp ?? $spots->spot_name;
                $spots->spot_month_usage = $obj->month_usage ?? $spots->spot_month_usage;
                $spots->spot_amount_charge = $obj->amount_charge ?? $spots->spot_amount_charge;
            }
        }

        return $spots;
    }

    /**
     * Restore contract with data inside request
     *
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return array
     */
    public function restoreContract($request = null)
    {
        // Get ID contract and ID ship from request
        $idShip = $request->filled('ship_id')?$request->get('ship_id'):null;
        $idContract = $request->filled('contract_id')?$request->get('contract_id'):null;

        // Get contract need to restore
        $contract = $this->shipContract->getContract($idShip, $idContract);

        // Check status restore is change status or recover new update
        // If status is recover new, redirect to page recover, else show response
        $statusContract = $this->checkStatusContract($contract);

        if (isset($statusContract['restore']) && $statusContract['restore'])
            return [
                'status' => true,
                'redirectTo' => $statusContract['redirectTo']];

        return $this->processRestoreContract($this->applyReasonRejectContract($contract));
    }

    /**
     * Check status restore is change status or recover new
     *
     * @access public
     * @param Illuminate\Support\Collection $contract
     * @return array
     */
    public function checkStatusContract($contract = null)
    {
        // When contract not exists
        if (empty($contract) || is_null($contract))
            return ['restore' => false];

        // Case 1: Status contract is pending, only restore and return response
        if ($contract->contract_status == Constant::STATUS_CONTRACT_PENDING)
            return ['restore' => false];

        // Case 2: Status contract is stop, redirect to recover page
        if ($contract->contract_status == Constant::STATUS_CONTRACT_EXPIRED
                || $contract->contract_status == Constant::STATUS_CONTRACT_DELETED)
            return [
                'restore' => true,
                'redirectTo' => route('contract.restore', $contract->contract_id)];
    }

    /**
     * Process restoring contract of a ship
     *
     * @access public
     * @param Illuminate\Support\Collection $contract
     * @return array [Contain status response and id of contract]
     */
    public function processRestoreContract($contract)
    {
        // When contract was not exists
        if (is_null($contract) || empty($contract))
             return [
                'status' => false,
                'title' => __('ship-contract.detail.res_tit_restore_contract'),
                'message' => __('ship-contract.detail.msg_restore_failed')];

        // Set data to update contract
        // Run query Sql to update info contract
        $dataUpdate = [
          'reason_reject' => json_encode(
                  [
                      'status' => Constant::STATUS_CONTRACT_ACTIVE,
                      'pending_at' => null,
                      'updated_by' => auth()->user()->id,
                      'updated_by_name' => auth()->user()->name
                  ]),
            'updated_at' => date('Y-m-d H:i:s'),
            'approved_flag' => Constant::STATUS_WAITING_APPROVE
        ];

        /**
         * The cases that contracts may be restore:
         * 1. Approve flag is approved and status of contract are disable/pending and deleted, not is created
         * 2. Approved flag is rejected and status of contract are disable/pending and deleted,and not create
         */
        if (($contract->contract_approved_flag == Constant::STATUS_APPROVED && $contract->contract_status != Constant::STATUS_CONTRACT_ACTIVE && !is_null($contract->contract_updated_at))
                || ($contract->contract_approved_flag == Constant::STATUS_REJECT_APPROVE && $contract->contract_status != Constant::STATUS_CONTRACT_ACTIVE && !is_null($contract->contract_updated_at))) {

            // Execute Sql restore contract
            $contractUpdate = $this->shipContract->updateContract($contract->contract_id, $dataUpdate);

            // When update success, return success else return failed
            if ($contractUpdate)
                return [
                    'status' => true,
                    'title' => __('ship-contract.detail.res_tit_restore_contract'),
                    'message' => __('ship-contract.detail.msg_restore_success'),
                    'contract' => $contract->contract_id];
        }

        // When update failed
        return [
            'status' => false,
            'title' => __('ship-contract.detail.res_tit_restore_contract'),
            'message' => __('ship-contract.detail.msg_restore_failed')];
    }

    /**
     * Disable contract from request Ajax
     *
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return array [Method disable contract]
     */
    public function disableContract($request = null)
    {
        // Get ID contract and ID ship from request
        $idShip = $request->filled('ship_id')? $request->get('ship_id'):null;
        $idContract = $request->filled('contract_id')?explode(":", $request->get('contract_id')):null;

        // Get contract need to restore
        $contracts = $this->applyReasonRejectContract($this->shipContract->getContract($idShip, $idContract));

        return $this->processDisableContract($contracts);
    }

    /**
     * Processing disable contract from ajax and return response
     *
     * @access public
     * @param Illuminate\Support\Collection $contracts
     * @return array [Status of handle update and ID contract was updated]
     */
    public function processDisableContract($contracts)
    {
        // When contract wasn't exists, don't update
        if (is_null($contracts) || empty($contracts))
            return [
                'status' => false,
                'title' => __('ship-contract.detail.res_tit_disable_contract'),
                'message' => __('ship-contract.detail.msg_disable_failed')
            ];

        // Get list Id of contract from collection
        // Set data to update database
        // Execute sql query to update info contract
        /**
         * The cases that contracts may be delete:
         * 1. Approve flag is approved and status of contract is activating && deleted
         * 2. Approved flag is rejected,  status of contract is activating and not create
         */
        $idContracts = array_column(
                array_filter($contracts->toArray(), function($a){
                    return ($a->contract_approved_flag == Constant::STATUS_APPROVED && $a->contract_status == Constant::STATUS_CONTRACT_ACTIVE)
                        || ($a->contract_approved_flag == Constant::STATUS_REJECT_APPROVE
                            && $a->contract_status == Constant::STATUS_CONTRACT_ACTIVE && !is_null($a->contract_updated_at));
                }),
                "contract_id");

        $dataUpdate = [
          'reason_reject' => json_encode(
                  [
                      'status' => Constant::STATUS_CONTRACT_PENDING,
                      'updated_by' => auth()->user()->id,
                      'updated_by_name' => auth()->user()->name,
                      'pending_at' => date('Y-m-d H:i:s')
                  ]),
            'updated_at' => date('Y-m-d H:i:s'),
            'approved_flag' => Constant::STATUS_WAITING_APPROVE
        ];

        // If has any contract need to update, else don't update
        if (count($idContracts) > 0) {
            $contractUpdate = $this->shipContract->updateContract($idContracts, $dataUpdate);

            // Update success
            if ($contractUpdate)
                return [
                    'status' => true,
                    'title' => __('ship-contract.detail.res_tit_disable_contract'),
                    'message' => __('common.messages.m038_delete_watting_approve'),
                    "contracts" => $idContracts];
        }

        // Update failed
        return [
            'status' => false,
            'title' => __('ship-contract.detail.res_tit_disable_contract'),
            'message' => __('ship-contract.detail.msg_disable_failed')];
    }

    /**
     * Delete contract from request Ajax and return response
     *
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return array [Status and id of contract delete from method process]
     */
    public function deleteContract($request = null)
    {
        // Get ID contract and ID ship from request
        $idShip = $request->filled('ship_id')? $request->get('ship_id'):null;
        $idContract = $request->filled('contract_id')?explode(":", $request->get('contract_id')):null;

        // Get contract need to restore
        $contracts = $this->applyReasonRejectContract($this->shipContract->getContract($idShip, $idContract));

        return $this->processDeleteContract($contracts);
    }

    /**
     * Processing delete contract from request
     *
     * @access public
     * @param Illuminate\Support\Collection $contract
     * @return array [Status of processing delete contract and id contract]
     */
    public function processDeleteContract($contracts)
    {
        // Check if param contracts is null
        if (is_null($contracts) || empty($contracts))
            return [
                'status' => false,
                'title' => __('ship-contract.detail.res_tit_delete_contract'),
                'message' => __('ship-contract.detail.msg_delete_failed')];

        // Get list id contract fromt collection contract
        // Set data to update database
        // Execute sql to update info contract
        /**
         * The cases that contracts may be delete:
         * 1. Approve flag is approved and status of contract not equal deleted/finish
         * 2. Approved flag is waiting approve and status of contract not equal deleted/finish and is request created
         * 2. Approved flag is rejected and status of contract not equal deleted/finish
         */
        $idContracts = array_column(
                array_filter($contracts->toArray(), function($a){
                     return ($a->contract_approved_flag == Constant::STATUS_APPROVED && ($a->contract_status == Constant::STATUS_CONTRACT_ACTIVE || $a->contract_status == Constant::STATUS_CONTRACT_PENDING))
                             || ($a->contract_approved_flag == Constant::STATUS_REJECT_APPROVE
                             && ($a->contract_status == Constant::STATUS_CONTRACT_ACTIVE ||$a->contract_status == Constant::STATUS_CONTRACT_PENDING ) && !is_null($a->contract_updated_at));
                })
        , "contract_id");

        $idContractRemoves =  array_column(
                array_filter($contracts->toArray(), function($a){
                     return ($a->contract_approved_flag == Constant::STATUS_WAITING_APPROVE && $a->contract_status == Constant::STATUS_CONTRACT_ACTIVE && is_null($a->contract_updated_at))
                             || ($a->contract_approved_flag == Constant::STATUS_REJECT_APPROVE
                             && ($a->contract_status == Constant::STATUS_CONTRACT_ACTIVE ||$a->contract_status == Constant::STATUS_CONTRACT_PENDING ) && is_null($a->contract_updated_at));
                })
        , "contract_id");

        $dataUpdate = [
          'reason_reject' => json_encode(
                  [
                      'status' => Constant::STATUS_CONTRACT_DELETED,
                      'updated_by' => auth()->user()->id,
                      'updated_by_name' => auth()->user()->name,
                      'deleted_at' => date('Y-m-d H:i:s')
                  ]),
            'updated_at' => date('Y-m-d H:i:s'),
            'approved_flag' => Constant::STATUS_WAITING_APPROVE
        ];
        $contractUpdate = 0;
        $contractDelete = 0;
        // If has any contract to update, else ignore
        if (count($idContracts) > 0) {
            $contractUpdate = $this->shipContract->updateContract($idContracts, $dataUpdate);
        }

        // If has any contract to remove, else ignore
        if (count($idContractRemoves) > 0) {
            $contractDelete = DB::table('m_contract')
                ->whereIn('id', $idContractRemoves)
                ->delete();
        }

        // Update success
        if ($contractUpdate || $contractDelete) {
            return [
                    'status' => true,
                    'title' => __('ship-contract.detail.res_tit_delete_contract'),
                    'message' => __('ship-contract.detail.msg_delete_success', ['contract' => implode(array_merge($idContracts, $idContractRemoves), ",")]),
                    "contractDelete" => $idContracts,
                    "contractRemove" => $idContractRemoves];
        }
        // Update failed
        return [
            'status' => false,
            'title' => __('ship-contract.detail.res_tit_delete_contract'),
            'message' => __('ship-contract.detail.msg_delete_failed')];
    }

    /**
     * Delete spot of ship from request Ajax
     *
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return array [Status delete spot and id spot from method processing]
     */
    public function deleteSpot($request = null)
    {
        // Get ID contract and ID ship from request
        $idShip = $request->filled('ship_id')? $request->get('ship_id'):null;
        $idSpot = $request->filled('spot_id')?explode(":", $request->get('spot_id')):null;

        // Get contract need to restore
        $spot = $this->shipContract->getSpot($idShip, $idSpot);

        return $this->processDeleteSpot($spot);
    }

    /**
     * Processing delete spot of ship from request
     *
     * @access public
     * @param Illuminate\Support\Collection $spot
     * @return array [Status of delete processing spot and Id]
     */
    public function processDeleteSpot($spot = null)
    {
        // When no thing  to update
        if (is_null($spot) || empty($spot))
            return [
                'status' => false,
                'title' => __('ship-contract.detail.res_tit_delete_spot'),
                'message' => __('ship-contract.detail.msg_delete_spot_failed')];

        // If exists spot, check month setting of spot equal now month/year
        // Set data to update database
        // Excecute sql to update info spot to database
        /**
         * The cases that contracts may be delete:
         * 1. Month/Year of now >=  Month/year setting spot
         * 2. Approved flag is approved and request approve
         * 3. Approved flag is pending and is request approve is created
         * 4. Approved flag is rejected
         */
        if ((!empty($spot->spot_month_usage) && Str::checkValidMonthFromStr($spot->spot_month_usage))
                && (
                    $spot->spot_approved_flag == Constant::STATUS_APPROVED
                        || ($spot->spot_approved_flag == Constant::STATUS_WAITING_APPROVE && is_null($spot->spot_updated_at))
                        || $spot->spot_approved_flag == Constant::STATUS_REJECT_APPROVE)){

            if (($spot->spot_approved_flag == Constant::STATUS_WAITING_APPROVE && is_null($spot->spot_updated_at))
                    || ($spot->spot_approved_flag == Constant::STATUS_WAITING_APPROVE && is_null($spot->spot_updated_at))) {
                // Handle update spot
                $spotUpdate = DB::table('t_ship_spot')
                    ->where('id', $spot->spot_id)
                    ->delete();
            } else {
                // Assign data to update database
                $dataUpdate = [
                   'reason_reject' => json_encode(
                           [
                               'del_flag' => Constant::DELETE_FLAG_TRUE,
                               'updated_by' => auth()->user()->id,
                               'updated_by_name' => auth()->user()->name
                           ]),
                     'updated_at' => date('Y-m-d H:i:s'),
                     'approved_flag' => Constant::STATUS_WAITING_APPROVE
                 ];

                // Handle update spot
                $spotUpdate = DB::table('t_ship_spot')
                    ->where('id', $spot->spot_id)
                    ->update($dataUpdate);
            }

            // Update success
            if ($spotUpdate) {
                return [
                    'status'    => true,
                    'title'     => __('ship-contract.detail.res_tit_delete_spot'),
                    'message'   => __('ship-contract.detail.msg_delete_spot_success', ['spot' => $spot->spot_id]),
                    "spot"      => $spot->spot_id];
            }
        }

        // Update failed
        return [
            'status'    => false,
            'title'     => __('ship-contract.detail.res_tit_delete_spot'),
            'message'   => __('ship-contract.detail.msg_delete_spot_failed')];
    }

    /**
     * Get reason reject of request approved
     *
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return array [Reason reject approve]
     */
    public function getReasonReject($request = null)
    {
        // Initial andget data from request
        $type = $request->filled('type')?$request->get('type'):null;
        $id = $request->filled('id')?$request->get('id'):null;

        // If not request get reason reject
        if (is_null($type) || is_null($id))
            return ['status' => false];

        // When get reason reject approve of contract
        if ($type == "contract"){
            $contract = $this->shipContract->getContract(null, $id);
            if (!is_null($contract))
                return [
                    'status' => true,
                    'reason' => $contract->contract_reason_reject];
        }

        // When get reason reject approve of spot
        if ($type == "spot") {
            $spot = $this->shipContract->getSpot(null, $id);
            if (!is_null($spot))
                return [
                    'status' => true,
                    'reason' => $spot->spot_reason_reject];
        }
    }

    /**
     * Delete ship from request ajax and return response
     *
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return array [Status delete ship and id ship]
     */
    public function deleteShip($request = null)
    {
        // Set and initial data from request
        $pw = $request->filled('pw')?$request->get('pw'):null;
        $id = $request->filled('ship_id')?$request->get('ship_id'):null;

        // When not have info to delete ship
        if (is_null($pw) || is_null($id)) {
            return [
                'status'    => false,
                'title'     => __('ship-contract.detail.res_tit_delete_ship'),
                'message'   => __('ship-contract.detail.msg_delete_ship_failed')];
        }

        // 1. Get ship need to delete, then check exists ship
        // 2. Authenticate password user to delete ship
        // 3. Proccess delete ship
        // 4. Return response
        $ship = $this->shipContract->getShip($id);

        if (is_null($ship)) {
            return [
                'status'    => false,
                'title'     => __('ship-contract.detail.res_tit_delete_ship'),
                'message'   => __('ship-contract.detail.msg_delete_ship_failed')];
        }

        // Get user info
        $user = DB::table('t_user_login')
                ->where('id', auth()->user()->id)
                ->first();

        // Verify password user to delete
        if (is_null($user) || !Hash::check($pw, $user->password)) {
            return [
                'status'    => false,
                'title'     => __('ship-contract.detail.res_tit_delete_ship'),
                'message'   => __('ship-contract.detail.msg_delete_ship_failed_auth')];
        }

        // Check contract is waiting approve
        if ($this->checkExistContractWaitingApprove($ship)) {
            return [
                'status'    => false,
                'title'     => __('ship-contract.detail.res_tit_delete_ship'),
                'message'   => __('error.w005_have_contract_watting_approve')];
        }

        // Process delete ship
        $delShip = $this->processDeleteShip($ship);

        // When delete success
        if ($delShip)
            return [
                'status' => true,
                'title' => __('ship-contract.detail.res_tit_delete_ship'),
                'message' => __('ship-contract.detail.msg_delete_ship_success', ['ship' => $id])];

        // When delete failed
        return [
            'status'    => false,
            'title'     => __('ship-contract.detail.res_tit_delete_ship'),
            'message'   => __('ship-contract.detail.msg_delete_ship_failed')];
    }

    /**
     *
     * @param type $ship
     */
    public function checkExistContractWaitingApprove($ship = null)
    {
        $contracts = $this->shipContract
            ->join('m_contract', "m_contract.ship_id", "=", "m_ship.id")
             ->where([
            'm_contract.approved_flag' => Constant::STATUS_WAITING_APPROVE,
            'm_contract.ship_id' => $ship->ship_id])
             ->select(['*'])
            ->first();
        if (is_null($contracts)) {
            return false;
        }

        return true;
    }

    /**
     * Process delete ship from request Ajax
     *
     * @access public
     * @param Illuminate\Support\Collection $ship
     * @return boolean
     */
    public function processDeleteShip($ship)
    {
        // 1. Set data to update database
        // 2. Execute update database
        $data = [
          'del_flag' => Constant::DELETE_FLAG_TRUE
        ];

        // Begin transaction, if delete contract failed then rollback
        DB::beginTransaction();
        // Handle revert contract of ship
        $revertContract = $this->revertContractWithShip($ship);

        // If revert contract success, return true commit transaction else return false and rollback data
        if ($revertContract) {
            DB::table('m_ship')
                ->where('id', $ship->ship_id)
                ->update($data);

            DB::commit();
            Log::info('Ship '.$ship->ship_id .' was deleted by '.auth()->user()->login_id);
            return true;
        }

        DB::rollBack();
        return false;
    }

    /**
     * Process reverting contract of ship
     *
     * @access public
     * @param Illuminate\Support\Collection $ship
     * @return boolean [The result in revert contract]
     */
    public function revertContractWithShip($ship = null)
    {
        if (is_null($ship)) {
            return false;
        }

        $contracts = $this->shipContract->getContract($ship->ship_id);

        $dataIdDelete = [];
        $dataIdRemove = [];

        if (count($contracts) > 0) {
            foreach ($contracts as $contract) {
                if (($contract->contract_approved_flag == Constant::STATUS_WAITING_APPROVE
                        || $contract->contract_approved_flag == Constant::STATUS_WAITING_APPROVE
                    ) && is_null($contract->contract_updated_at)
                ) {
                    $dataIdRemove[] = $contract->contract_id;
                } else {
                    $dataIdDelete[] = $contract->contract_id;
                }
            }
        }

        // Initial response
        $updateDelete = 0;
        $updateRemove = 0;

        // Start transaction
        DB::beginTransaction();
        if (count($dataIdDelete) > 0) {
            $updateDelete = DB::table('m_contract')
                ->where('m_contract.ship_id', $ship->ship_id)
                ->whereIn('m_contract.id', $dataIdDelete)
                ->update([
                    'm_contract.status'         => Constant::STATUS_CONTRACT_DELETED,
                    'm_contract.deleted_at'       => date('Y-m-d H:i:s'),
                    'm_contract.approved_flag'  => Constant::STATUS_APPROVED
                ]);
        }

        if (count($dataIdRemove) > 0) {
            $updateRemove =  DB::table('m_contract')
                ->where('m_contract.ship_id', $ship->ship_id)
                ->whereIn('m_contract.id', $dataIdRemove)
                ->delete();
        }

        if ($updateDelete || $updateRemove) {
            DB::commit();
        } else {
             DB::rollBack();
        }

        return true;
    }

    /**
     * Function init page create ship contract
     * @param int companyId
     * @throws Exception
     * @return array
     */
    public function initCreateShipContract($companyId)
    {
        $companyRepository = app(\App\Repositories\Company\CompanyInterface::class);
        $companyData = $companyRepository->getCompanyDetail($companyId, ['id', 'name_en', 'name_jp']);

        $shipTypeRepository = app(\App\Repositories\ShipType\ShipTypeInterface::class);
        $shipTypes = $shipTypeRepository->getAllShipType([
            'id',
            'code',
            'type',
        ]);

        $classificationRepository = app(\App\Repositories\Classification\ClassificationInterface::class);
        $classificationies = $classificationRepository->getAllShipClassification([
            'id',
            'code',
            'name_en',
            'name_jp',
        ]);

        $nationRepository = app(\App\Repositories\Nation\NationInterface::class);
        $nations = $nationRepository->getAllNation([
            'id',
            'name_jp',
            'name_en',
        ]);

        $serviceRepository = app(\App\Repositories\Service\ServiceInterface::class);
        $services = $serviceRepository->getServiceValidWithCompany($companyId);

        $spotRepository = app(\App\Repositories\MSpot\MSpotInterface::class);
        $spotDefault = $spotRepository->getExistsSpotTypeWithCurrency($companyId, [
            Constant::SPOT_TYPE_REGISTER,
            Constant::SPOT_TYPE_CREATE_DATA
        ], [
            'm_spot.id',
            'm_spot.name_jp',
            'm_spot.name_en',
            'm_spot.type',
        ]);

        return [
            'company' => $companyData,
            'shipTypes' => $shipTypes,
            'classificationies' => $classificationies,
            'nations' => $nations,
            'services' => $services,
            'spotDefault' => $spotDefault,
        ];
    }

    /**
     * Function check ship type exists
     *
     * @param int $shipTypeId
     * @return boolean
     */
    public function checkShipTypeExists($shipTypeId)
    {
        $shipTypeRepository = app(\App\Repositories\ShipType\ShipTypeInterface::class);

        return $shipTypeRepository->checkTypeExists($shipTypeId);
    }

    /**
     * Function check classification id exists
     *
     * @param int $classificationId
     * @return boolean
     */
    public function checkShipClassificationExists($classificationId)
    {
        $shipClassificationRepository = app(\App\Repositories\Classification\ClassificationInterface::class);

        return $shipClassificationRepository->checkClassificationExists($classificationId);
    }

    /**
     * Function store ship, contract and spot
     *
     * @param array $dataShip
     * @param array $dataService
     * @param array $dataSpot
     * @return boolean
     */
    public function storeShipContractWithSpot($dataShip, $dataService = [], $dataSpot = [])
    {
        $companyRepository = app(\App\Repositories\Company\CompanyInterface::class);
        $company = $companyRepository->getCompanyCurrencyId($dataShip['company-id']);

        // Check currency company
        if ($dataService['currency-id'] && $company['currency_id'] != $dataService['currency-id']) {
            throw new \Exception("Invalid currency id with company", Constant::HTTP_CODE_ERROR_500);
        }

        $dataInsertToShip = [
            'name' => $dataShip['txt-ship-name'],
            'company_id' => $dataShip['company-id'],
            'imo_number' => $dataShip['txt-imo-number'],
            'mmsi_number' => $dataShip['txt-mmsi-number'],
            'nation_id' => $dataShip['nation-id'],
            'classification_id' => $dataShip['slb-classification'],
            'register_number' => $dataShip['txt-register-number'],
            'type_id' => $dataShip['slb-ship-type'],
            'width' => $dataShip['txt-ship-width'],
            'height' => $dataShip['txt-ship-length'],
            'water_draft' => $dataShip['txt-water-draft'],
            'total_weight_ton' => $dataShip['txt-total-weight-ton'],
            'total_ton' => $dataShip['txt-weight-ton'],
            'member_number' => $dataShip['txt-member-number'],
            'url_1' => $dataShip['txt-url-1'],
            'url_2' => $dataShip['txt-url-2'],
            'url_3' => $dataShip['txt-url-3'],
            'remark' => $dataShip['txt-remark'],
            'del_flag' => Constant::DELETE_FLAG_FALSE,
            'created_by' => auth()->id(),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Save ship
        $id = $this->shipContract->insertGetId($dataInsertToShip);

        // Not have service or spot then return true
        if (empty($dataService['service']) || empty($dataSpot['spot'])) {
            return true;
        }

        // Save contract
        $contractIds = $this->_storeServiceShipContract($dataService, $id);

        // Save spot
        $this->_storeSpotShipContract($dataSpot, $id, array_column($contractIds, 'id'));

        return true;
    }

    /**
     * Function create contract with ship id and return ids contract after insert
     *
     * @param array $dataService
     * @param int $shipId
     * @return array
     */
    private function _storeServiceShipContract($dataService, $shipId)
    {
        $dataInsertContract = [];
        $now = date('Y-m-d H:i:s');
        $serviceIds = [];

        foreach ($dataService['service'] as $service) {
            $dataInsertContract[] = [
                'ship_id' => $shipId,
                'service_id' => $service['id'],
                'remark' => $service['remark'],
                'start_date' => $service['start-date'],
                'end_date' => $service['end-date'],
                'status' => Constant::STATUS_CONTRACT_ACTIVE,
                'currency_id' => $dataService['currency-id'],
                'approved_flag' => Constant::STATUS_WAITING_APPROVE,
                'created_by' => auth()->id(),
                'created_at' => $now,
                'revision_number' => 1,
            ];

            $serviceIds[] = $service['id'];
        }

        $contractRepository = app(\App\Repositories\Contract\ContractInterface::class);
        $contractRepository->insert($dataInsertContract);

        $contractInsert = $contractRepository->getContractAfterInsert([
            'ship_id' => $shipId,
            'status' => Constant::STATUS_CONTRACT_ACTIVE,
            'currency_id' => $dataService['currency-id'],
            'approved_flag' => Constant::STATUS_WAITING_APPROVE,
            'created_by' => auth()->id(),
            'created_at' => $now,
            'revision_number' => 1,
        ], $serviceIds, ['id'])
        ->toArray();

        return $contractInsert;
    }

    /**
     * Function create spot with ship id
     *
     * @param array $dataSpot
     * @param int $shipId
     * @return boolean
     */
    private function _storeSpotShipContract($dataSpot, $shipId, $contractIds)
    {
        $dataInsertSpot = [];
        $now = date('Y/m/d H:i:s');

        //  Reset index of array start with 0
        $dataSpot['spot'] = array_values($dataSpot['spot']);
        $contractIds = array_values($contractIds);

        if (empty($contractIds)) {
            return true;
        }

        foreach ($dataSpot['spot'] as $index => $arrSpot) {
            foreach ($arrSpot as $key => $spot) {
                // Check charge is have value then insert
                if (is_numeric($spot['charge']) && $spot['charge'] > 0) {
                    // Setting spot register
                    $dataInsertSpot[] = [
                        'spot_id' => $spot['id'],
                        'amount_charge' => ($spot['charge'] > 0) ? Common::foramtNumber($spot['charge']) : 0,
                        'ship_id' => $shipId,
                        'currency_id' => $dataSpot['currency-id'],

                        // Set first date of this month when create spot
                        'month_usage' => date('Y/m/01'),
                        'approved_flag' => Constant::STATUS_WAITING_APPROVE,
                        'created_by' => auth()->id(),
                        'created_at' => $now,
                        'del_flag' => Constant::DELETE_FLAG_FALSE,
                        // 'contract_id' => $contractIds[$index], // Đợi a Dung tạo column
                    ];
                }
            }
        }

        $tShipSpotRepository = app(\App\Repositories\TShipSpot\TShipSpotInterface::class);
        $tShipSpotRepository->insert($dataInsertSpot);

        return true;
    }
}
