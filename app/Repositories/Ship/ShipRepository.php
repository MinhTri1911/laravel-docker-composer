<?php

namespace App\Repositories\Ship;

use App\Repositories\EloquentRepository;
use App\Models\MShip;
use DB;
use App\Common\Constant;

class ShipRepository extends EloquentRepository implements ShipInterface
{
    /**
     * Set model user for interface
     * 
     * @return \App\Models\User $user
     */
    public function getModel(){
        return MShip::class;
    }
    
    /**
     * 
     * @param type $idShip
     * @param type $param
     */
    public function getShip($idShip = null) {
        // Check exists param id ship
        
        $queryShip = DB::table('m_ship')
                ->join('m_company', function($join){
                    $join->on('m_ship.company_id', '=', 'm_company.id')
                         ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE);
                    
                })
                ->join('m_nation', function($join){
                    $join->on('m_ship.nation_id', '=', 'm_nation.id')
                            ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_currency', function($join){
                    $join->on('m_company.currency_id', '=', 'm_currency.id')
                            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_ship_classification', function($join){
                    $join->on('m_ship.classification_id', '=', 'm_ship_classification.id')
                            ->where('m_ship_classification.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_ship_type', function($join){
                    $join->on('m_ship.type_id', '=', 'm_ship_type.id')
                            ->where('m_ship_type.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->select([
                    "m_ship.id as ship_id",
                    "m_ship.name as ship_name",
                    "m_ship.imo_number as ship_imo_number",
                    "m_ship.mmsi_number as ship_mmsi_number",
                    "m_ship.register_number as ship_register_number",
                    "m_ship.width as ship_width",
                    "m_ship.height as ship_height",
                    "m_ship.water_draft as ship_water_draft",
                    "m_ship.total_weight_ton as ship_total_weight_ton",
                    "m_ship.total_ton as ship_weight_ton",
                    "m_ship.member_number as ship_member_number",
                    "m_ship.remark as ship_remark",
                    "m_ship.url_1 as ship_url_1",
                    "m_ship.url_2 as ship_url_2",
                    "m_ship.url_3 as ship_url_3",

                    "m_company.name_jp as company_name",
                    
                    "m_nation.name_jp as nation_name",
                    
                    "m_ship_classification.name_jp as ship_classify",
                    "m_ship_type.type as ship_type"
                ]);
                
        if(empty($idShip) || is_null($idShip)){
            return $queryShip->get();
        }
        
        return $queryShip->where([
                    'm_ship.id' => $idShip
                    ])
                ->first();
    }
    
    /**
     * Get contract 
     * @param type $idShip
     * @param type $param
     */
    public function getContract($idShip = null, $idContract = '') {
        // Query get contract
        $contract = DB::table('m_contract')
            ->join('m_ship', function($join){
                $join->on('m_ship.id', '=', 'm_contract.ship_id')
                        ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE);
            })
            ->join('m_service', function($join){
                $join->on('m_service.id', '=', 'm_contract.service_id')
                        ->where('m_service.del_flag', Constant::DELETE_FLAG_FALSE);
            })
            ->select([
                "m_contract.id as contract_id",
                "m_contract.revision_number as contract_revision_number",
                "m_contract.start_date as contract_date_start",
                "m_contract.end_date as contract_date_end",
                "m_contract.status as contract_status",
                "m_contract.approved_flag as contract_approved_flag",
                "m_contract.created_at as contract_created_at",
                "m_contract.updated_at as contract_updated_at",
                "m_contract.approved_flag as contract_approved_flag",
                "m_service.id as service_id",
                "m_service.name_jp as service_name",
            ])
            ->whereIn('approved_flag', [Constant::APPROVED_DONE, Constant::APPROVED_PENDING , Constant::APPROVED_REJECT]);
        
            // Check if get all contract inside all ship
            if(empty($idShip) || is_null($idShip)){
                if(!empty($idContract) || is_null($idContract)){
                    return $contract
                            ->where('m_contract.id', $idContract)
                            ->first();
                }

                return $contract->get();
            }
            
            // If get contract inside a ship
            if(!empty($idContract) || is_null($idContract)){
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
     * Get contract 
     * @param type $idShip
     * @param type $param
     */
    public function getContractActive($idShip = null, $idContract = []) {
        // Query get contract
        $contract = DB::table('m_contract')
            ->join('m_ship', function($join){
                $join->on('m_ship.id', '=', 'm_contract.ship_id')
                        ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE);
            })
            ->join('m_service', function($join){
                $join->on('m_service.id', '=', 'm_contract.service_id')
                        ->where('m_service.del_flag', Constant::DELETE_FLAG_FALSE);
            })
            ->select([
                "m_contract.id as contract_id",
                "m_contract.revision_number as contract_revision_number",
                "m_contract.start_date as contract_date_start",
                "m_contract.end_date as contract_date_end",
                "m_contract.status as contract_status",
                "m_contract.approved_flag as contract_approved_flag",
                "m_contract.created_at as contract_created_at",
                "m_contract.updated_at as contract_updated_at",
                "m_contract.approved_flag as contract_approved_flag",
                "m_service.id as service_id",
                "m_service.name_jp as service_name",
            ])
            ->whereIn('approved_flag', [Constant::APPROVED_DONE, Constant::APPROVED_PENDING , Constant::APPROVED_REJECT])
            ->where('status', Constant::CONTRACT_STATUS_ACTIVE);
        
            // Check if get all contract inside all ship
            if(empty($idShip) || is_null($idShip)){
                if(!empty($idContract) || is_null($idContract)){
                    return $contract
                            ->whereIn('m_contract.id', $idContract)
                            ->get();
                }

                return $contract->get();
            }
            
            // If get contract inside a ship
            if(!empty($idContract) || is_null($idContract)){
                return $contract
                        ->whereIn('m_contract.id', $idContract)
                        ->where('m_ship.id', $idShip)
                        ->get();
            }

            return $contract
                    ->where('m_ship.id', $idShip)
                    ->get();
    }
    
    /**
     * Get contract 
     * @param type $idShip
     * @param type $param
     */
    public function getSpot($idShip = null, $idSpot = null, $limit = null) {
        $spot = DB::table('t_ship_spot')
                ->join('m_ship', function($join) use ($idShip){
                    $join->on('m_ship.id', '=', 't_ship_spot.ship_id')
                            ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_spot', function($join){
                    $join->on('m_spot.id', '=', 't_ship_spot.spot_id')
                            ->where('m_spot.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->select([
                    "t_ship_spot.id as spot_id",
                    "m_spot.name_jp as spot_name",
                    "t_ship_spot.month_usage as spot_month_usage",
                    "t_ship_spot.amount_charge as spot_amount_charge",
                    "t_ship_spot.approved_flag as spot_approved_flag",
                    "t_ship_spot.created_at as spot_created_at",
                    "t_ship_spot.updated_at as spot_updated_at",
                ])
                ->where('t_ship_spot.del_flag', Constant::DELETE_FLAG_FALSE);
                
        // Check exists param id ship
        if(empty($idShip) || is_null($idShip)){
            if(!empty($idSpot) && !is_null($idSpot))
                return $spot->where(['t_ship_spot.id' => $idSpot])->first();
            
            if(!is_null($limit)){
                return $spot->paginate($limit);
            }
            return $spot->get();
        }
        
        if(!empty($idSpot) && !is_null($idSpot))
            return $spot->where([
                't_ship_spot.id' => $idSpot,
                'm_ship.id' => $idShip])
                ->first();

        if(!is_null($limit)){
            return $spot->where('m_ship.id', $idShip)->paginate($limit);
        }
        return $spot->get();
    }
}
