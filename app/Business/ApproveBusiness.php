<?php

/**
 * ApproveBusiness.php
 *
 * Handle business process approve
 *
 * @package    Approve
 * @author     Rikkei.DungLV
 * @date       2018/07/03
 */

namespace App\Business;

use App\Common\Constant;
use App\Repositories\Approve\ApproveInterface;
use DB;
use App\Common\LoggingCommon;

class ApproveBusiness
{
    // Declare interface of repository contain query sql
    protected $approveInterface;
    
    // Set limit number record per page
    const RECORD_PER_PAGE = 10;
    
    const TYPE_APPROVE_CONTRACT     = 0;
    const TYPE_APPROVE_SPOT         = 1;
    const TYPE_APPROVE_BILLING      = 2;
    
    const REQ_TYPE_APPROVE = 0;
    const REQ_TYPE_REJECT = 1;
    
    /**
     * Initial interface execute query SQL
     * 
     * @access public
     * @param App\Repositories\Approve\ApproveInterface $approveInterface
     * @return void
     */
    public function __construct(ApproveInterface $approveInterface)
    {
        $this->approveInterface = $approveInterface;
    }
    
    /**
     * Get data to display view home approve
     * 
     * @access public
     * @return Illuminate\Support\Collection [List data to display view]
     */
    public function getDataForHomeApprove()
    {
        // Config data contract to filter
        $config = [
            'limit' => request()->filled('limit')?request()->get('limit'):self::RECORD_PER_PAGE,
            'm_contract.approved_flag' => Constant::STATUS_WAITING_APPROVE
        ];
        
        return $this->convertDataApproveContract($this->approveInterface->getListContract($config));
    }
    
    /**
     * Add properties data_update and infor to object contract
     * 
     * @access public
     * @param Illuminate\Support\Collection $approves
     * @return Illuminate\Support\Collection [List collection contract]
     */
    public function convertDataApproveContract($approves = null)
    {
        // If not exists approves return null
        if (is_null($approves)) {
            return null;
        }
        
        // Add data update and request approve type properties 
        if (count($approves) > 0) {
            foreach ($approves as $contract) {
                // If request approve is create, data update is null
                if (is_null($contract->contract_updated_at)) {
                    $contract->data_update = null;
                } else {
                    if (!is_null($contract->contract_reason_reject)) {
                        $obj = json_decode($contract->contract_reason_reject);
                        $contract->data_update = (object)[
                            'contract_id'               => $obj->contract_id ?? $contract->contract_id,
                            'contract_revision_number'  => $obj->revision_number ?? $contract->contract_revision_number,
                            'contract_ship_id'          => $obj->ship_id ?? $contract->contract_ship_id,
                            'contract_ship_name'        => $obj->ship_name ?? $contract->contract_ship_name,
                            'contract_service_id'       => $obj->service_id ?? $contract->contract_service_id,
                            'contract_service_name'     => $obj->service_name ?? $contract->contract_service_name,
                            'contract_start_date'       => $obj->start_date ?? $contract->contract_start_date,
                            'contract_end_date'         => $obj->end_date ?? $contract->contract_end_date,
                            'contract_status'           => $obj->status ?? $contract->contract_status,
                            'contract_created_at'       => $obj->created_at ?? $contract->contract_created_at,
                            'contract_created_by'       => $obj->created_by ?? $contract->contract_created_by,
                            'contract_updated_at'       => $obj->updated_at ?? $contract->contract_updated_at,
                            'contract_updated_by'       => $obj->updated_by ?? $contract->contract_updated_by,
                            'contract_user_id'          => $obj->user_id ?? $contract->contract_user_id,
                            'contract_user_name'        => $obj->user_name ?? $contract->contract_user_name,
                            'contract_remark'           => $obj->remark ?? $contract->contract_remark,
                            'contract_deleted_at'       => $obj->deleted_at ?? $contract->contract_deleted_at,
                            'contract_pending_at'       => $obj->pending_at ?? $contract->contract_pending_at,
                            'contract_date_request'     => $obj->updated_at ?? $contract->contract_updated_at,
                        ];
                    } else {
                        $contract->data_update = null;
                    }
                }
                // Set datetime send request
                $contract->contract_date_request = is_null($contract->contract_updated_at)?$contract->contract_created_at:$contract->contract_updated_at;

                // Set request approve type
                $contract = $this->setOperationType($contract);
            }
        }
        
        return $approves;
    }
    
    /**
     * Add properties data_update and info to object spot
     * 
     * @access public
     * @param Illuminate\Support\Collection $approves
     * @return Illuminate\Support\Collection [List collection spot]
     */
    public function convertDataApproveSpot($approves = null)
    {
        // If not exists approves return null
        if (is_null($approves)) {
            return null;
        }
        
        // Add data update and request approve type properties 
        if (count($approves) > 0) {
            foreach ($approves as $spot) {
                // If request approve is create, data update is null
                if (is_null($spot->spot_updated_at)) {
                    $spot->data_update = null;
                } else {
                    if (!is_null($spot->spot_reason_reject)) {
                        $obj = json_decode($spot->spot_reason_reject);
                        $spot->data_update = (object)[
                            'spot_id'               => $obj->spot_id ?? $spot->spot_id,
                            'spot_month_usage'      => $obj->month_usage ?? $spot->spot_month_usage,
                            'spot_amount_charge'    => $obj->amount_charge ?? $spot->spot_amount_charge,
                            'spot_remark'           => $obj->remark ?? $spot->spot_remark,
                            'spot_ship_id'          => $obj->ship_id ?? $spot->spot_ship_id,
                            'spot_ship_name'        => $obj->ship_name ?? $spot->spot_ship_name,
                            'spot_spot_id'          => $obj->spot_id ?? $spot->spot_spot_id,
                            'spot_spot_name'        => $obj->spot_name ?? $spot->spot_spot_name,
                            'spot_user_id'          => $obj->user_id ?? $spot->spot_user_id,
                            'spot_user_name'        => $obj->user_name ?? $spot->spot_user_name,
                            'spot_currency_id'      => $obj->currency_id ?? $spot->spot_currency_id,
                            'spot_currency_name'    => $obj->currency_name ?? $spot->spot_currency_name,
                            'spot_company_name'     => $obj->company_name ?? $spot->spot_company_name,
                            'spot_created_at'       => $obj->created_at ?? $spot->spot_created_at,
                            'spot_created_by'       => $obj->created_by ?? $spot->spot_created_by,
                            'spot_updated_at'       => $obj->updated_at ?? $spot->spot_updated_at,
                            'spot_updated_by'       => $obj->updated_by ?? $spot->spot_updated_by,
                            'spot_del_flag'         => $obj->del_flag ?? $spot->spot_del_flag,
                            'spot_date_request'     => $obj->updated_at ?? $spot->spot_updated_at,
                        ];
                    } else {
                       $spot->data_update = null;
                    }
                }
                // Set datetime send request
                $spot->spot_date_request = is_null($spot->spot_updated_at)?$spot->spot_created_at:$spot->spot_updated_at;
                
                // Set property type of request (operation) for spot
                $spot = $this->setOperationType($spot);
            }
        }
        
        return $approves;
    }
    
    /**
     * Add property operation send request approve is create, edit or delete
     * 
     * @access public
     * @param Object $object
     * @return Object
     */
    public function setOperationType($object = null)
    {
        $ope = null;
        // If current object is contract
        if (property_exists($object, 'contract_status')) {
            if (!is_null($object->contract_created_at) && is_null($object->contract_updated_at)) {
                $ope = Constant::TYPE_OPE['create'];
            } else {
                if (!is_null($object->data_update)) {
                    switch ($object->data_update->contract_status) {
                        case Constant::STATUS_CONTRACT_ACTIVE:
                        case Constant::STATUS_CONTRACT_PENDING:
                            $ope = Constant::TYPE_OPE['edit'];
                            break;
                        case Constant::STATUS_CONTRACT_DELETED:
                            $ope = Constant::TYPE_OPE['delete'];
                            break;
                        default:
                            $ope = Constant::TYPE_OPE['create'];
                            break;
                    }
                }
            }
         
        // If current object is spot
        } elseif (property_exists($object, 'spot_created_at')) {
            if (!is_null($object->spot_created_at) && is_null($object->spot_updated_at) ) {
                $ope = Constant::TYPE_OPE['create'];
            } else {
                if (!is_null($object->spot_updated_at) 
                        && optional($object->data_update)->spot_del_flag == Constant::DELETE_FLAG_FALSE) {
                    $ope = Constant::TYPE_OPE['edit'];
                } else {
                    $ope = Constant::TYPE_OPE['delete'];
                }
            }
        }
        
        // Inject request_operation property for object
        $object->request_operation = $ope;
        
        return $object;
    }
    
    /**
     * Return data when user search request approve
     * 
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return Illuminate\Support\Collection [Colection data]
     */
    public function getDataForSearchAprrove($request = null)
    {
        $config = $this->configRequestCondition($request);
        
        switch ($config['type']) {
            case self::TYPE_APPROVE_SPOT:
                return $this->searchSpot($config);
                break;
            
            case self::TYPE_APPROVE_BILLING:
                return $this->searchBilling($config);
                break;

            default:
                return $this->searchContract($config);
                break;
        }
        
        // Else return data for home
        return $this->getDataForHomeApprove();
    }
    
    /**
     * Return data when user show detail of request approve
     * 
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return Illuminate\Support\Collection [Colection data]
     */
    public function getDataForDetailAprrove($request = null)
    {
        $type = $request->get('type', null);
        
        switch ($type) {
            case self::TYPE_APPROVE_SPOT:
                $config['idSpot'] = $request->filled('id')?$request->get('id'):null;
                return $this->searchSpot($config);
                break;
            
            case self::TYPE_APPROVE_BILLING:
                $config['idBilling'] = $request->filled('id')?$request->get('id'):null;
                return $this->searchBilling($config);
                break;
            
            default:
                $config['idContract'] = $request->filled('id')?$request->get('id'):null;
                return $this->searchContract($config);
                break;
        }

        return null;
    }
    
    /**
     * Convert request to clause condition in query
     * 
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return Array
     */
    public function configRequestCondition($request = null)
    {
        $condition = [];
        if ($request->filled('date_from') && preg_match('/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/', $request->get('date_from'))) {
            $condition['date']['date_from'] = $request->get('date_from');
        }
        
        if ($request->filled('date_to') && preg_match('/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/', $request->get('date_to'))) {
            $condition['date']['date_to'] = $request->get('date_to');
        }
        
        if ($request->filled('sender')) {
            $condition['user'] = $request->get('sender');
        }
        
        // Config type of request approve is contract(0), spot(1) or billing(2)
        $condition['type'] = ($request->filled('setting_type') 
                && in_array($request->get('setting_type'), [self::TYPE_APPROVE_CONTRACT, self::TYPE_APPROVE_SPOT, self::TYPE_APPROVE_BILLING]))
                ?(int)$request->get('setting_type')
                :self::TYPE_APPROVE_CONTRACT;
        
        // Config status of request approve is waiting approve (2) or rejected (3)
        $condition['status'] = ($request->filled('setting_status') && in_array($request->get('setting_status'), [Constant::STATUS_WAITING_APPROVE, Constant::STATUS_REJECT_APPROVE]))
                ?(int)$request->get('setting_status')
                :Constant::STATUS_WAITING_APPROVE;
        
        // Config limit record show on per page [10, 25, 50]
        $condition['limit'] = ($request->filled('limit') 
                && in_array($request->get('limit'), Constant::ARY_PAGINATION_PER_PAGE))
                ?(int)$request->get('limit')
                :self::RECORD_PER_PAGE;
        
        return $condition;
    }
    
    /**
     * Handle search spot base on condition after convert
     * 
     * @access public
     * @param Array $condition
     * @return Illuminate\Support\Collection
     */
    public function searchSpot($condition = [])
    {
        if (isset($condition['status'])) {
            $condition['t_ship_spot.approved_flag'] = $condition['status'];
        }
        
        $spots = $this->convertDataApproveSpot($this->approveInterface->getListSpot($condition));
        
        return $spots;
    }
    
    /**
     * Handle search contract base on condition after convert
     * 
     * @access public
     * @param Array $condition
     * @return Illuminate\Support\Collection
     */
    public function searchContract($condition = [])
    {
        if (isset($condition['status'])) {
            $condition['m_contract.approved_flag'] = $condition['status'];
        }
       
        $contracts = $this->convertDataApproveContract($this->approveInterface->getListContract($condition));
        
        return $contracts;
    }
    
    /**
     * Handle search billing base on condition after convert
     * 
     * @access public
     * @param Array $condition
     * @return Illuminate\Support\Collection
     */
    public function searchBilling($condition = [])
    {
        if (isset($condition['status'])) {
            $condition['t_history_billing.approved_flag'] = $condition['status'];
        }
        
        $billings = $this->approveInterface->getListBilling($condition);
        
        return $billings;
    }
    
    /**
     * Handle accept request approve
     * 
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return Array [Response return to ajax]
     */
    public function handleAcceptApprove($request = null)
    {
        $config = $this->configRequestAjaxApprove($request);
        if (isset($config['type']) && isset($config['id'])) {
            switch ($config['type']) {
                case self::TYPE_APPROVE_CONTRACT:
                    return $this->acceptApproveContract($config);
                    break;
                case self::TYPE_APPROVE_SPOT:
                    return $this->acceptApproveSpot($config);
                    break;
                
                case self::TYPE_APPROVE_BILLING:
                    return $this->acceptApproveBilling($config);
                    break;
                
                default:
                    return [
                        'status' => false,
                        'message' => __('approve.msg_error_approve')
                    ];
                    break;
            }
        }
        return [
            'status' => false,
            'message' => __('approve.msg_error_approve')
        ];
    }
    
    /**
     * Convert request Ajax to array config
     * 
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return Array [List param insert query sql]
     */
    public function configRequestAjaxApprove($request = null) {
        $config = [];
        if ($request->filled('id') 
                && is_array($request->get('id'))
                && count($request->get('id')) > 0 ) {
            $config['id'] = $request->get('id');
        }
        
        if ( $request->filled('type') ) {
            $config['type'] = $request->get('type');
        }
        
        if ( $request->filled('reason-reject') ) {
            $config['reason-reject'] = $request->get('reason-reject');
        }
        
        return $config;
    }
    
    /**
     * Process accept approve contract
     * 
     * @access public
     * @param Array $config [Array config was convert from request ajax]
     * @return Array [Response accept approve]
     */
    public function acceptApproveContract($config = []) {
        $condition = [
            'idContract' => $config['id'],
            'm_contract.approved_flag' => Constant::STATUS_WAITING_APPROVE
        ];
        
        // Get list contract need to accept approve
        $contracts = $this->convertDataApproveContract($this->approveInterface->getListContract($condition));
        
        if (count($contracts) > 0) {
            // Divide contracts to groups contract with each request approve is create/edit/delete
            $groupContract = $this->groupTypeAcceptApprove($contracts);
            
            try {
                // Execute update contract in transaction
                DB::transaction(function() use ($groupContract){
                    // If accept approve contract with request create
                    if (isset($groupContract['create']) && count($groupContract['create']) > 0) {
                        $arrId = array_column($groupContract['create'], 'contract_id');
                        $this->approveInterface->updateContract(
                                $arrId, [
                                    'm_contract.approved_flag' => Constant::STATUS_APPROVED,
                                    'm_contract.updated_at' => null,
                                    'm_contract.updated_by' => null
                                ]);
                    // If accept approve contract with request update
                    } elseif (isset($groupContract['update']) && count($groupContract['update']) > 0) {
                        foreach ($groupContract['update'] as $uContract) {
                            $dataU = [
                                'm_contract.revision_number' => $uContract->data_update->contract_revision_number,
                                'm_contract.ship_id' => $uContract->data_update->contract_ship_id,
                                'm_contract.service_id' =>  $uContract->data_update->contract_service_id,
                                'm_contract.start_date' =>  $uContract->data_update->contract_start_date,
                                'm_contract.end_date' => $uContract->data_update->contract_end_date,
                                'm_contract.status' => $uContract->data_update->contract_status,
                                'm_contract.updated_at' => $uContract->data_update->contract_updated_at,
                                'm_contract.updated_by' => $uContract->data_update->contract_updated_by,
                                'm_contract.remark' => $uContract->data_update->contract_remark,
                                'm_contract.reason_reject' => null,
                                'm_contract.approved_flag' => Constant::STATUS_APPROVED
                            ];
                            
                            // Config data update column deleted_at
                            if (isset($uContract->data_update->contract_deleted_at)) {
                                if (is_null($uContract->data_update->contract_deleted_at)) {
                                    $dataU['m_contract.deleted_at'] = null;
                                } else {
                                    $dataU['m_contract.deleted_at'] = date('Y-m-d H:i:s');
                                }
                            }
                            
                            // Config data update column pending_at
                            if (isset($uContract->data_update->contract_pending_at)) {
                                if (is_null($uContract->data_update->contract_pending_at)) {
                                    $dataU['m_contract.pending_at'] = null;
                                } else {
                                    $dataU['m_contract.pending_at'] = date('Y-m-d H:i:s');
                                }
                            }
                            
                            $this->approveInterface->updateContract($uContract->contract_id, $dataU);
                        }
                    // If accept approve contract with request delete
                    } elseif (isset($groupContract['delete']) && count($groupContract['delete']) > 0) {
                        foreach ($groupContract['delete'] as $delContract) {
                            $dataDel = [
                                'm_contract.status' => Constant::STATUS_CONTRACT_DELETED,
                                'm_contract.approved_flag' => Constant::STATUS_APPROVED,
                                'm_contract.deleted_at' => date('Y-m-d H:i:s'),
                                'm_contract.reason_reject' => null
                            ];
                            
                            // Config data update column updated_by
                            if(isset($delContract->data_update->contract_updated_by) && !is_null($delContract->data_update->contract_updated_by)) {
                                $dataDel['m_contract.updated_by'] = $delContract->data_update->contract_updated_by;
                            }
                            
                            $this->approveInterface->updateContract($delContract->contract_id, $dataDel);
                        }
                    }
                }); // End transaction
                
                // Handle log approve
                $this->writeLogApprove([
                    'message' => __('approve.header_contract'),
                    'id' => $config['id'],
                    'type' => self::REQ_TYPE_APPROVE
                ]);
                return [
                    'status' => true,
                    'message' => __('approve.msg_approve_contract_sucess', ['id' => implode($config['id'], ',')])
                ];
            } catch (\Exception $exc) {
               return [
                   'status' => false,
                   'message' => __('approve.msg_error_approve'),
                   'error' => $exc->getMessage()
               ];
            }
        }// End foreach
        
        return [
            'status' => false,
            'message' => __('approve.msg_approve_contract_no')
        ];
    }
    
    /**
     * Group approves item to each group
     * 
     * @access public
     * @param Illuminate\Support\Collection $approves
     * @return Array [List collection each group]
     */
    public function groupTypeAcceptApprove($approves = null)
    {
        $dataUpdateCreate = [];
        $dataUpdateUpdate = [];
        $dataUpdateDelete = [];
        foreach ($approves as $approve) {
            if (property_exists($approve, 'request_operation')) {
                if($approve->request_operation === Constant::TYPE_OPE['create']) {
                    $dataUpdateCreate[] = $approve;
                } elseif ($approve->request_operation === Constant::TYPE_OPE['edit']) {
                    $dataUpdateUpdate[] = $approve;
                } elseif ($approve->request_operation === Constant::TYPE_OPE['delete']) {
                    $dataUpdateDelete[] = $approve;
                }
            }
        }
        
        return [
            'create' => $dataUpdateCreate,
            'update' => $dataUpdateUpdate,
            'delete' => $dataUpdateDelete
        ];
    }
    
    /**
     * Handle accept approve spot
     * 
     * @access public
     * @param Array $config
     * @param Array [Array response]
     */
    public function acceptApproveSpot($config = []) {
        $condition = [
            'idSpot' => $config['id'],
            't_ship_spot.approved_flag' => Constant::STATUS_WAITING_APPROVE
        ];
        
        // Get list spot need to accept approve
        $spots = $this->convertDataApproveSpot($this->approveInterface->getListSpot($condition));
        
        if (count($spots) > 0) {
            // Divide spots to groups with each request approve is create/edit/delete
            $groupSpot = $this->groupTypeAcceptApprove($spots);
            
            try {
                // Execute update spot in transaction
                DB::transaction(function() use ($groupSpot){
                    // If accept approve contract with request create
                    if (isset($groupSpot['create']) && count($groupSpot['create']) > 0) {
                        $arrId = array_column($groupSpot['create'], 'spot_id');
                        $this->approveInterface->updateSpot(
                                $arrId, [
                                    't_ship_spot.approved_flag' => Constant::STATUS_APPROVED,
                                    't_ship_spot.updated_at' => null,
                                    't_ship_spot.updated_by' => null
                                ]);
                     
                    // If accept approve spot with request update
                    } elseif (isset($groupSpot['update']) && count($groupSpot['update']) > 0) {
                        foreach ($groupSpot['update'] as $uSpot) {
                            $dataU = [
                                't_ship_spot.spot_id' => $uSpot->data_update->spot_spot_id,
                                't_ship_spot.month_usage' => $uSpot->data_update->spot_month_usage,
                                't_ship_spot.amount_charge' =>  $uSpot->data_update->spot_amount_charge,
                                't_ship_spot.remark' =>  $uSpot->data_update->spot_remark,
                                't_ship_spot.updated_at' => $uSpot->data_update->spot_updated_at,
                                't_ship_spot.updated_by' => $uSpot->data_update->spot_updated_by,
                                't_ship_spot.del_flag' => $uSpot->data_update->spot_del_flag,
                                't_ship_spot.reason_reject' => null,
                                't_ship_spot.approved_flag' => Constant::STATUS_APPROVED
                            ];
                            
                            $this->approveInterface->updateSpot($uSpot->spot_id, $dataU);
                        }
                    // If accept approve spot with request delete
                    } elseif (isset($groupSpot['delete']) && count($groupSpot['delete']) > 0) {
                        foreach ($groupSpot['delete'] as $delSpot) {
                            $dataDel = [
                                't_ship_spot.approved_flag' => Constant::STATUS_APPROVED,
                                't_ship_spot.del_flag' => $delSpot->data_update->spot_del_flag,
                                't_ship_spot.reason_reject' => null
                            ];
                            
                            // Config data update column updated_by
                            if(isset($delSpot->data_update->spot_updated_by) && !is_null($delSpot->data_update->spot_updated_by)) {
                                $dataDel['t_ship_spot.updated_by'] = $delSpot->data_update->spot_updated_by;
                            }
                            
                            $this->approveInterface->updateSpot($delSpot->spot_id, $dataDel);
                        }
                    }
                }); // End transaction
                
                $this->writeLogApprove([
                    'message' => __('approve.header_spot'),
                    'id' => $config['id'],
                    'type' => self::REQ_TYPE_APPROVE
                ]);
                
                return [
                    'status' => true,
                    'message' => __('approve.msg_approve_spot_sucess', ['id' => implode($config['id'], ',')])
                ];
            } catch (\Exception $exc) {
               return [
                   'status' => false,
                   'message' => __('approve.msg_error_approve'),
                   'error' => $exc->getMessage()
               ];
            }
        }// End foreach
        
        return [
            'status' => false,
            'message' => __('approve.msg_approve_spot_no')
        ];
    }
    
    /**
     * Handle accept approve billing
     * 
     * @access public
     * @param Array $config
     * @return Array [Array response return to ajax]
     */
    public function acceptApproveBilling($config = []) {
        $condition = [
            'idBilling' => $config['id'],
            't_history_billing.approved_flag' => Constant::STATUS_WAITING_APPROVE
        ];
        
        // Get list billing need to accept approve
        $billings = $this->approveInterface->getListBilling($condition);
        if (!is_null($billings) && count($billings) > 0) {
            try {
                // Execute update billing in transaction
                DB::transaction(function() use ($billings){
                    // If accept approve contract with request create
                    $arrId = array_column($billings->toArray(), 'billing_id');
                    $this->approveInterface->updateBilling(
                            $arrId, [
                                't_history_billing.approved_flag' => Constant::STATUS_APPROVED,
                                't_history_billing.updated_at' => null,
                                't_history_billing.updated_by' => null
                            ]);
                }); // End transaction
                
                // Log info approve
                $this->writeLogApprove([
                    'message' => __('approve.header_billing'),
                    'id' => $config['id'],
                    'type' => self::REQ_TYPE_APPROVE
                ]);
                
                return [
                    'status'    => true,
                    'message'   => __('approve.msg_approve_billing_sucess')
                ];
            } catch (\Exception $exc) {
               return [
                   'status'     => false,
                   'message'    => __('approve.msg_error_approve'),
                   'error'      => $exc->getMessage()
               ];
            }
        }// End foreach
        
        return [
            'status'    => false,
            'message'   => __('approve.msg_approve_billing_no')
        ];
    }
    
    /**
     * Handle reject request approve
     * 
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return Array [Response return to ajax]
     */
    public function handleRejectApprove($request = null)
    {
        $config = $this->configRequestAjaxApprove($request);
        
        if (isset($config['type']) && isset($config['id'])) {
            switch ($config['type']) {
                case self::TYPE_APPROVE_CONTRACT:
                    return $this->rejectApproveContract($config);
                    break;
                case self::TYPE_APPROVE_SPOT:
                    return $this->rejectApproveSpot($config);
                    break;
                
                case self::TYPE_APPROVE_BILLING:
                    return $this->rejectApproveBilling($config);
                    break;
                
                default:
                    return [
                        'status' => false,
                        'message' => __('approve.msg_error_reject')
                    ];
                    break;
            }
        }
        return [
            'status' => false,
            'message' => __('approve.msg_error_reject')
        ];
    }
    
    /**
     * Reject request approve of contract
     * 
     * @access public
     * @param Array $config [Array config after convert from request]
     * @return Array [List param response to ajax]
     */
    public function rejectApproveContract($config)
    {
        $condition = [
            'idContract' => $config['id'],
            'm_contract.approved_flag' => Constant::STATUS_WAITING_APPROVE
        ];
      
        // Get list contract need to accept approve
        $contracts = $this->convertDataApproveContract($this->approveInterface->getListContract($condition));
        
        if (count($contracts) > 0) {
            // Divide contracts to groups contract with each request approve is create/edit/delete
            $groupContract = $this->groupTypeAcceptApprove($contracts);
            
            try {
                // Execute update contract in transaction
                DB::transaction(function() use ($config, $groupContract){
                    // If accept approve contract with request create
                    if (isset($groupContract['create']) && count($groupContract['create']) > 0) {
                        $arrId = array_column($groupContract['create'], 'contract_id');
                        $this->approveInterface->updateContract(
                                $arrId, [
                                    'm_contract.reason_reject' => $config['reason-reject']??null,
                                    'm_contract.approved_flag' => Constant::STATUS_REJECT_APPROVE,
                                    'm_contract.updated_at' => null,
                                    'm_contract.updated_by' => null
                                ]);
                    
                    // If accept approve contract with request update
                    } elseif (isset($groupContract['update']) && count($groupContract['update']) > 0) {
                        foreach ($groupContract['update'] as $uContract) {
                            $dataU = [
                                'm_contract.reason_reject' => $config['reason-reject']??null,
                                'm_contract.approved_flag' => Constant::STATUS_REJECT_APPROVE
                            ];
                            
                            $this->approveInterface->updateContract($uContract->contract_id, $dataU);
                        }
                    // If accept approve contract with request delete
                    } elseif (isset($groupContract['delete']) && count($groupContract['delete']) > 0) {
                        foreach ($groupContract['delete'] as $delContract) {
                            $dataDel = [
                                'm_contract.approved_flag' => Constant::STATUS_REJECT_APPROVE,
                                'm_contract.reason_reject' => $config['reason-reject']??null
                            ];
                            
                            $this->approveInterface->updateContract($delContract->contract_id, $dataDel);
                        }
                    }
                }); // End transaction
                
                // Log info approve
                $this->writeLogApprove([
                    'message' => __('approve.header_billing'),
                    'id' => $config['id'],
                    'type' => self::REQ_TYPE_REJECT
                ]);
                
                return [
                    'status' => true,
                    'message' => __('approve.msg_reject_contract_sucess', ['id' => implode($config['id'], ',')])
                ];
            } catch (\Exception $exc) {
               return [
                   'status' => false,
                   'message' => __('approve.msg_error_reject'),
                   'error' => $exc->getMessage()
               ];
            }
        }// End foreach
        
        return [
            'status' => false,
            'message' => __('approve.msg_reject_contract_no')
        ];
    }
    
    /**
     * Execute SQL query to reject request approve spot
     * 
     * @access public
     * @param Array $config [List param config after convert from request Ajax]
     * @return Array [List param reponse to ajax]
     */
    public function rejectApproveSpot($config = [])
    {
        $condition = [
            'idSpot' => $config['id'],
            't_ship_spot.approved_flag' => Constant::STATUS_WAITING_APPROVE
        ];
      
        // Get list contract need to accept approve
        $spots = $this->convertDataApproveSpot($this->approveInterface->getListSpot($condition));
        
        if (count($spots) > 0) {
            // Divide contracts to groups contract with each request approve is create/edit/delete
            $groupSpot = $this->groupTypeAcceptApprove($spots);
            
            try {
                // Execute update spot in transaction
                DB::transaction(function() use ($config, $groupSpot){
                    // If accept approve spot with request create
                    if (isset($groupSpot['create']) && count($groupSpot['create']) > 0) {
                        $arrId = array_column($groupSpot['create'], 'spot_id');
                        $this->approveInterface->updateSpot(
                                $arrId, [
                                    't_ship_spot.reason_reject' => $config['reason-reject']??null,
                                    't_ship_spot.approved_flag' => Constant::STATUS_REJECT_APPROVE,
                                    't_ship_spot.updated_at' => null,
                                    't_ship_spot.updated_by' => null
                                ]);
                    
                    // If accept approve spot with request update
                    } elseif (isset($groupSpot['update']) && count($groupSpot['update']) > 0) {
                        foreach ($groupSpot['update'] as $uSpot) {
                            $dataU = [
                                't_ship_spot.reason_reject' => $config['reason-reject']??null,
                                't_ship_spot.approved_flag' => Constant::STATUS_REJECT_APPROVE
                            ];
                            
                            $this->approveInterface->updateSpot($uSpot->spot_id, $dataU);
                        }
                    // If accept approve spot with request delete
                    } elseif (isset($groupSpot['delete']) && count($groupSpot['delete']) > 0) {
                        foreach ($groupSpot['delete'] as $delSpot) {
                            $dataDel = [
                                't_ship_spot.approved_flag' => Constant::STATUS_REJECT_APPROVE,
                                't_ship_spot.reason_reject' => $config['reason-reject']??null
                            ];
                            
                            $this->approveInterface->updateSpot($delSpot->spot_id, $dataDel);
                        }
                    }
                }); // End transaction
                
                // Log info approve
                $this->writeLogApprove([
                    'message' => __('approve.header_spot'),
                    'id' => $config['id'],
                    'type' => self::REQ_TYPE_REJECT
                ]);
                
                return [
                    'status' => true,
                    'message' => __('approve.msg_reject_spot_sucess', ['id' => implode($config['id'], ',')])
                ];
            } catch (\Exception $exc) {
               return [
                   'status' => false,
                   'message' => __('approve.msg_error_reject'),
                   'error' => $exc->getMessage()
               ];
            }
        }// End foreach
        
        return [
            'status' => false,
            'message' => __('approve.msg_reject_spot_no')
        ];
    }
    
    /**
     * Execute SQL query reject request approve billing
     * 
     * @access public
     * @param Array $config [List parameter after convert from request Ajax]
     * @return Array [List parameter response to Ajax]
     */
    public function rejectApproveBilling($config = [])
    {
        $condition = [
            'idBilling' => $config['id'],
            't_history_billing.approved_flag' => Constant::STATUS_WAITING_APPROVE
        ];
        
        // Get list billing need to accept approve
        $billings = $this->approveInterface->getListBilling($condition);
        
        if (count($billings) > 0) {
            try {
                // Execute update spot in transaction
                DB::transaction(function() use ($config, $billings){
                    // If accept approve spot with request create
                    $arrId = array_column($billings->toArray(), 'billing_id');
                    $this->approveInterface->updateBilling
                            ($arrId, [
                                't_history_billing.reason_reject' => $config['reason-reject']??null,
                                't_history_billing.approved_flag' => Constant::STATUS_REJECT_APPROVE,
                                't_history_billing.updated_at' => null,
                                't_history_billing.updated_by' => null
                            ]);
                
                }); // End transaction
                
                // Log info approve
                $this->writeLogApprove([
                    'message' => __('approve.header_billing'),
                    'id' => $config['id'],
                    'type' => self::REQ_TYPE_REJECT
                ]);
                
                return [
                    'status' => true,
                    'message' => __('approve.msg_reject_billing_sucess', ['id' => implode($config['id'], ',')])
                ];
            } catch (\Exception $exc) {
                dd($exc->getMessage());
               return [
                   'status' => false,
                   'message' => __('approve.msg_error_reject'),
                   'error' => $exc->getMessage()
               ];
            }
        }// End foreach
        
        return [
            'status' => false,
            'message' => __('approve.msg_reject_billing_no')
        ];
    }
    
    /**
     * Process write log approve
     * 
     * @access public
     * @param Array $param [List param config log write]
     * @return Monolog\Logger
     */
    public function writeLogApprove($param = [])
    {
        // Config log where was store after write anf fromat line file
        $filename = date('Ym').'_'.__('approve.title_approve').'.log';
        $logFormat = "%datetime% [%context.type%] %message% %context.info% \n";
        
        // Initial logger write
        $log = LoggingCommon::logWrite($filename, storage_path('logs/approve'), $logFormat);
        
        // Set content to write
        $contentLog = [];
        
        // Classify type approve is accept or reject and write it into file
        if (isset($param['type'])) {
            $reqType = '';
            
            if ($param['type'] == self::REQ_TYPE_APPROVE) {
                $reqType = 'ACCEPT';
            } else {
                $reqType = 'REJECT';
            }
            
            $contentLog['type'] = $reqType;
        } else {
            $contentLog['type'] = NULL;
        }
        
        // Set info include id, user of type of approve request
        // Id user is array or string and save with format string: id1,id2,id3,...
        // Format context is json of user and id
        if (isset($param['id'])) {
            if (is_array($param['id']) && count($param['id']) > 0) {
                $id = implode($param['id'], ',');
            } else {
                $id = $param['id'];
            }
            
            $contentLog['info'] = json_encode(['user' => auth()->user()->login_id, 'id' => $id]);
        } else {
            $contentLog['info'] = json_encode(['user' => auth()->user()->login_id]);
        }
        
        return $log->info($param['message']??"Message", $contentLog);
    }
}
