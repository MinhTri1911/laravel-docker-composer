<?php

/**
 * ShipContractBusiness.php
 *
 * Handle business and logic ship and contract data
 *
 * @package    ShipContract
 * @author     DungLV
 * @date       2018/07/03
 */

namespace App\Business;

use App\Repositories\Ship\ShipInterface;
use App\Common\Constant;
use DB;

class ShipContractBusiness{
    
    protected $shipContract;
    
    const N_RECORD_PAGE = 10;
     
    /**
     * 
     * @param ShipInterface $shipContract
     */
    public function __construct(ShipInterface $shipContract) {
        $this->shipContract = $shipContract;
    }
    
    /**
     * Get ship contract by id ship
     * 
     * @param integer $id
     */
    public function getShipContractById($idShip = '') {
        return (object)[
            'detail_ship' => $this->shipContract->getShip($idShip),
            'contracts' => $this->shipContract->getContract($idShip),
            'spots' => $this->shipContract->getSpot($idShip, null, self::N_RECORD_PAGE),
        ];
    }
    
    /**
     * 
     * @param type $request
     */
    public function restoreContract($request = null) {
        // Get ID contract and ID ship from request
        $idShip = $request->filled('ship_id')?$request->get('ship_id'):null;
        $idContract = $request->filled('contract_id')?$request->get('contract_id'):null;
        
        // Get contract need to restore
        $contract = $this->shipContract->getContract($idShip, $idContract);
        
        $statusContract = $this->checkStatusContract($contract);
        
        if(isset($statusContract['restore']) && $statusContract['restore'])
            return ['status' => true, 'redirectTo' => $statusContract['redirectTo']];
        
        return $this->processRestoreContract($contract);
    }
    
    /**
     * 
     * @param type $idContract
     */
    public function checkStatusContract($contract = null) {
        if(empty($contract) || is_null($contract)) return null;
        
        if($contract->contract_status == 1) return ['restore' => false];
        
        if($contract->contract_status == 2) return ['restore' => true, 'redirectTo' => route('contract.restore', $contract->contract_id)];
        
    }
    
    /**
     * 
     * @param type $contract
     */
    public function processRestoreContract($contract) {
        if(is_null($contract) || empty($contract)) return null;
        $dataUpdate = [
          'reason_reject' => json_encode(
                  [
                      'status' => Constant::CONTRACT_STATUS_ACTIVE, 
                      'updated_by' => auth()->user()->id
                  ]),
            'updated_at' => date('Y-m-d H:i:s'),
            'approved_flag' => Constant::APPROVED_PENDING
        ];
        $contractUpdate = DB::table('m_contract')
            ->where('id', $contract->contract_id)
            ->update($dataUpdate);
        if($contractUpdate)
            return ['status' => true, 'contract' => $contract->contract_id];
        
        return ['status' => false];
    }
    
    /**
     * 
     * @param type $request
     */
    public function disableContract($request = null) {
        // Get ID contract and ID ship from request
        $idShip = $request->filled('ship_id')? $request->get('ship_id'):null;
        $idContract = $request->filled('contract_id')?explode(":", $request->get('contract_id')):null;
        
        // Get contract need to restore
        $contracts = $this->shipContract->getContractActive($idShip, $idContract);

        return $this->processDisableContract($contracts);
    }
    
    /**
     * 
     * @param type $contract
     */
    public function processDisableContract($contracts) {
        if(is_null($contracts) || empty($contracts)) return null;
        $idContracts = array_column($contracts->toArray(), "contract_id");
        
        $dataUpdate = [
          'reason_reject' => json_encode(
                  [
                      'status' => Constant::CONTRACT_STATUS_PENDING, 
                      'updated_by' => auth()->user()->id
                  ]),
            'updated_at' => date('Y-m-d H:i:s'),
            'approved_flag' => Constant::APPROVED_PENDING
        ];
        if(count($idContracts) > 0){
            $contractUpdate = DB::table('m_contract')
                ->whereIn('id', $idContracts)
                ->update($dataUpdate);
            if($contractUpdate)
                return ['status' => true, "contracts" => $idContracts];
        }
        return ['status' => false];
    }
    
    /**
     * 
     * @param type $request
     */
    public function deleteContract($request = null) {
        // Get ID contract and ID ship from request
        $idShip = $request->filled('ship_id')? $request->get('ship_id'):null;
        $idContract = $request->filled('contract_id')?explode(":", $request->get('contract_id')):null;
        
        // Get contract need to restore
        $contracts = $this->shipContract->getContractActive($idShip, $idContract);

        return $this->processDeleteContract($contracts);
    }
    
    /**
     * 
     * @param type $contract
     */
    public function processDeleteContract($contracts) {
        // Check if param contracts is null
        if(is_null($contracts) || empty($contracts)) 
            return ['status' => false];
        
        $idContracts = array_column($contracts->toArray(), "contract_id");
        
        $dataUpdate = [
          'reason_reject' => json_encode(
                  [
                      'status' => Constant::CONTRACT_STATUS_FINISH, 
                      'updated_by' => auth()->user()->id
                  ]),
            'updated_at' => date('Y-m-d H:i:s'),
            'approved_flag' => Constant::APPROVED_PENDING
        ];
        if(count($idContracts) > 0){
            $contractUpdate = DB::table('m_contract')
                ->whereIn('id', $idContracts)
                ->update($dataUpdate);
            if($contractUpdate)
                return ['status' => true, "contracts" => $idContracts];
        }
        return ['status' => false];
    }
    
    /**
     * 
     * @param type $request
     */
    public function deleteSpot($request = null) {
        // Get ID contract and ID ship from request
        $idShip = $request->filled('ship_id')? $request->get('ship_id'):null;
        $idSpot = $request->filled('spot_id')?explode(":", $request->get('spot_id')):null;
        
        // Get contract need to restore
        $spot = $this->shipContract->getSpot($idShip, $idSpot);

        return $this->processDeleteSpot($spot);
    }
    
    /**
     * 
     * @param type $contract
     */
    public function processDeleteSpot($spot = null) {
        if(is_null($spot) || empty($spot)) return ['status' => false];
                
        $dataUpdate = [
          'reason_reject' => json_encode(
                  [
                      'del_flag' => Constant::DELETE_FLAG_TRUE, 
                      'updated_by' => auth()->user()->id
                  ]),
            'updated_at' => date('Y-m-d H:i:s'),
            'approved_flag' => Constant::APPROVED_PENDING
        ];
        // Handle update spot
        $spotUpdate = DB::table('t_ship_spot')
            ->where('id', $spot->spot_id)
            ->update($dataUpdate);
        if($spotUpdate)
            return ['status' => true, "spot" => $spot->spot_id];
        
        return ['status' => false];
    }
}
