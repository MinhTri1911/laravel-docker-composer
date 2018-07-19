<?php

/**
 * Ship management Repository
 *
 * @package App\Repositories\Ship
 * @author Rikkei.Quyenl
 * @date 2018/07/05
 */

namespace App\Repositories\TShipSpot;

use App\Repositories\EloquentRepository;
use App\Models\TShipSpot;
use App\Common\Constant;
use App\Common\Common;

class TShipSpotRepository extends EloquentRepository implements TShipSpotInterface 
{
    /**
     * Set model ship for interface
     *
     * @return string \App\Models\TShipSpot
     */
    public function getModel() {
        return TShipSpot::class;
    }

    /**
     * Create
     * @access public
     * @param arr $data
     * @return mixed Illuminate\Support\Collection
     */
    public function createTShipSpot($data,$typeInsert) {

        $ship = new $this->_model;
        $ship->ship_id = $data['ship_id'];
        $ship->currency_id = $data['currency_id'];
        $ship->month_usage = date('Y-m').'-1';
        $ship->spot_id = 2;
        if ($typeInsert == 1) {
           $ship->amount_charge = Common::foramtNumber($data['chargeRegister']);
        } else {
           $ship->amount_charge = Common::foramtNumber($data['chargeCreate']);
        }
        $ship->approved_flag = Constant::STATUS_WAITING_APPROVE;
        $ship->updated_at = null;
        $ship->created_by = auth()->id();
        
        return $ship->save();
    }
    
    /**
     * Create
     * @access public
     * @param arr $data
     * @param int $typeInsert
     * @return mixed Illuminate\Support\Collection
    */
    public function createTShipSpotByCurrencyId($data) {
        
        $ship = new $this->_model;
        $ship->ship_id = $data['ship_id'];
        $ship->currency_id = $data['currency_id'];
        $ship->month_usage = $data['month_usage'];
        $ship->spot_id = $data['spot_id'];
        $ship->amount_charge = $data['amount_charge'];
        $ship->remark = $data['remark'];
        $ship->approved_flag = Constant::STATUS_WAITING_APPROVE;
        $ship->updated_at = null;
        $ship->created_by = auth()->id();
         
        return $ship->save();
    }
}