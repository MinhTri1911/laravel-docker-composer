<?php

/**
 * Ship management Repository
 *
 * @package App\Repositories\TShipSpot
 * @author Rikkei.QuyenL
 * @date 2018/07/05
 */

namespace App\Repositories\TShipSpot;

use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\DB;
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
     * @param array $data
     * @return mixed Illuminate\Support\Collection
     */
    public function createTShipSpot($data, $typeInsert) {

        $ship = new $this->_model;
        $ship->ship_id = $data['ship_id'];
        $ship->currency_id = $data['currency_id'];
        $ship->month_usage = date('Y-m').'-1';
        $ship->spot_id = $typeInsert;
        $ship->contract_id = $data['idContract'] ?? null;
        if ($typeInsert == 1) {
           $ship->amount_charge = Common::formatNumber($data['chargeRegister']);
        } else {
           $ship->amount_charge = Common::formatNumber($data['chargeCreate']);
        }
        $ship->approved_flag = Constant::STATUS_WAITING_APPROVE;
        $ship->updated_at = null;
        $ship->created_by = auth()->id();
        
        return $ship->save();
    }
    
    /**
     * Create
     * @access public
     * @param array $data
     * @return mixed Illuminate\Support\Collection
    */
    public function createTShipSpotByCurrencyId($data) {
        
        $ship = new $this->_model;
        $ship->ship_id = $data['ship_id'];
        $ship->currency_id = $data['currency_id'];
        $ship->month_usage = $data['month_usage'];
        $ship->spot_id = $data['spot_id'];
        $ship->amount_charge = str_replace(',', '', $data['amount_charge']);
        $ship->remark = $data['remark'];
        $ship->approved_flag = Constant::STATUS_WAITING_APPROVE;
        $ship->updated_at = null;
        $ship->created_by = auth()->id();
        return $ship->save();
    }

    /**
     * Get edit spot data
     *
     * @param int $spotId
     * @return mixed Laravel collection
     */
    public function getEditShipSpotData($spotId)
    {
        return DB::table('t_ship_spot')->select([
            't_ship_spot.id',
            't_ship_spot.ship_id',
            't_ship_spot.month_usage',
            't_ship_spot.currency_id',
            't_ship_spot.spot_id',
            't_ship_spot.amount_charge',
            't_ship_spot.remark',
            't_ship_spot.approved_flag',
            't_ship_spot.updated_at',
        ])
            ->where('t_ship_spot.del_flag', Constant::DELETE_FLAG_FALSE)
            ->where('t_ship_spot.id', $spotId)
            ->get()
            ->first();
    }

    /**
     * Update spot
     *
     * @param int $shipSpotId
     * @param array $updateData
     * @return bool
     */
    public function updateShipSpot($shipSpotId, $updateData)
    {
        return DB::table('t_ship_spot')->where('id', $shipSpotId)
            ->where('del_flag', Constant::DELETE_FLAG_FALSE)
            ->update($updateData);
    }
}
