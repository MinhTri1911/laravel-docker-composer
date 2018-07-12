<?php

/**
 * File contract business
 *
 * Handle business related to contract
 * @package App\Business
 * @author Rikkei.datPDT
 * @date 2018/07/10
 */

namespace App\Business;

use App\Repositories\Contract\ContractInterface;
use App\Repositories\Ship\ShipInterface;
use App\Repositories\TShipSpot\TShipSpotInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;

class ContractBusiness 
{

    protected $_contractInterface;
    protected $_shipInterface;
    protected $_tShipSpotInterface;

    public function __construct(ContractInterface $contractInterface, ShipInterface $shipInterface, TShipSpotInterface $tShipSpotInterface) 
    {
        $this->_contractInterface = $contractInterface;
        $this->_shipInterface = $shipInterface;
        $this->_tShipSpotInterface = $tShipSpotInterface;
    }

    /**
     * Business create contract
     * @access public
     * @param arr request
     * @return true/false
     */
    public function createContract($request) 
    {
        try 
        {
            DB::beginTransaction();
             
            $data = [];
            $data['ship_id'] = $request->shipId;
            $data['currency_id'] = $request->currencyId;
            $data['service_id'] = $request->serviceIdHidden;
            $data['start_date'] = str_replace('/','-',$request->dateStart);
            $data['end_date'] = str_replace('/','-',$request->dateEnd);
            $data['remark'] = $request->remark;

            $idContract = $this->_contractInterface->createContract($data);
            
            $data['idContract'] = $idContract;
            $data['chargeRegister'] = $request->chargeRegister;
            $data['chargeCreate'] = $request->chargeCreate;
            
            // Insert table TShipSlot 
            // chargeRegister : 1
            $this->_tShipSpotInterface->createTShipSpot($data, 1);
            
            // chargeCreate : 2
            $this->_tShipSpotInterface->createTShipSpot($data, 2);
            
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
    public function initCreate($idShip) 
    {
        return $this->_shipInterface->getIdShip($idShip);
    }

}
