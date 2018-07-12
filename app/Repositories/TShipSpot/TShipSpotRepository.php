<?php

/**
 * Ship management Repository
 *
 * @package App\Repositories\Ship
 * @author Rikkei.quyenl
 * @date 2018/07/05
 */

namespace App\Repositories\TShipSpot;

use App\Repositories\EloquentRepository;
use App\Models\TShipSpot;
use Illuminate\Support\Facades\DB;

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
           $ship->amount_charge = $data['chargeRegister'];
        } else {
           $ship->amount_charge = $data['chargeCreate'];
        }
        $ship->approved_flag = 2;
        
        return $ship->save();
    }
}
