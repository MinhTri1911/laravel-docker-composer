<?php

/**
 * File contract business
 *
 * Handle business related to spot
 * @package App\Business
 * @author Rikkei.DatPDT
 * @date 2018/07/10
 */

namespace App\Business;

use App\Repositories\Ship\ShipInterface;
use App\Repositories\MSpot\MSpotInterface;
use App\Repositories\MCurrency\MCurrencyInterface;
use App\Repositories\TShipSpot\TShipSpotInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Common\Constant;

class SpotBusiness 
{
    protected $_shipInterface;
    protected $_mSpotInterface;
    protected $_mCurrency;
    protected $_tShipSpotInterface;

    public function __construct(
            ShipInterface $shipInterface, 
            MSpotInterface $mSpotInterface, 
            MCurrencyInterface $mCurrency, 
            TShipSpotInterface $tShipSpotInterface) {
        $this->_shipInterface = $shipInterface;
        $this->_mSpotInterface = $mSpotInterface;
        $this->_mCurrency = $mCurrency;
        $this->_tShipSpotInterface = $tShipSpotInterface;
    }

    /**
     * Business create spot
     * @access public
     * @param arr request
     * @return true/false
    */
    public function createSpot($request) {
        try {
            DB::beginTransaction();
            $date  = substr($request->dateStart,0,8).'01';
            $data = [];
            $data['ship_id'] = $request->shipId;
            $data['spot_id'] = $request->spotId;
            $data['month_usage'] = str_replace('/','-',$date);
            $data['amount_charge'] = $request->amountCharge;
            $data['currency_id'] = $request->currencyId;
            $data['remark'] = $request->remark;
            $this->_tShipSpotInterface->createTShipSpotByCurrencyId($data);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            Log::info($ex);
            DB::rollBack();
            return false;
        }
    }

    /**
     * Business init create
     * @access public
     * @param int idShip
     * @return mixed Illuminate\Support\Collection
     */
    public function initCreate($idShip) {
        try {
            $data['ship'] = $this->_shipInterface->getIdShip($idShip);
            if ($data['ship'] == null) {
                return abort(404);
            }
            $currency_id = $data['ship']->currency_id;
            $data['spotName'] = $this->_mSpotInterface->getMSpotByCurrencyId($currency_id);
            if ($data['spotName'] == null) {
                return abort(404);
            }
            $data['spotNameSelect'] = array_column($data['spotName']->toArray(), 'name_jp', 'id');
            $data['amountCharge'] =  $data['spotName'][0]->charge.'.00';
            $data['currencyCode'] = $this->_mCurrency->getMCurrencyByCurrencyId($currency_id);
            return $data;
        } catch (Exception $ex) {
            Log::info($ex);
            return abort(500,Constant::ID_SCREEN['SMB0009']);
        }
    }

    /**
     * Business get amount charge
     * @access public
     * @param int idShip
     * @param int currency_id
     * @return mixed Illuminate\Support\Collection
     */
    public function getCharge($currency_id, $spot_id) {
        try {
            $amountCharge = $this->_mSpotInterface->getCharge($currency_id, $spot_id);
            return $amountCharge->charge;
        } catch (Exception $ex) {
            Log::info($ex);
            return abort(500,Constant::ID_SCREEN['SMB0009']);
        }
    }
}