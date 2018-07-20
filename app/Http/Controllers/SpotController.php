<?php

/**
 * File Spot controller
 *
 * @package App\Http\Controllers
 * @author Rikkei.DatPDT
 * @date 2018/07/19
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\SpotBusiness;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Http\Requests\SpotRequest;
use App\Common\Constant;

class SpotController extends Controller 
{
    private $_spotBusiness;

    public function __construct(SpotBusiness $spotBusiness) {
        $this->_spotBusiness = $spotBusiness;
    }

    /**
     * Show page init create spot
     * @param  idShip
     * @return view
     */
    public function initCreate($idShip = '') {
        try {
            $data = $this->_spotBusiness->initCreate($idShip);
            return view('spot.create', $data);
        } catch (Exception $ex) {
            Log::info($ex);
            return abort('NotFound');
        }
    }

    /**
     * Ajax search amount  by idSpot
     * @return amountCharge
     */
    public function searchAmount(Request $request) {
        try {
            $currency_id = $request->get('currencyId');
            $spot_id = $request->get('spotId');
            return $this->_spotBusiness->getCharge($currency_id, $spot_id);
        } catch (Exception $ex) {
            Log::info($ex);
            return abort(500, Constant::ID_SCREEN['SMB0009']);
        }
    }

    /**
     * Handel create spot
     * @param  request
     * @return view
     */
    public function create(SpotRequest $request) {
        try {
            $isCreate = $this->_spotBusiness->createSpot($request);
            if ($isCreate) {
                return redirect()->route('ship.contract.detail', $request->shipId);
            }
            return abort(500, Constant::ID_SCREEN['SMB0009']);
        } catch (Exception $ex) {
            Log::info($ex);
            return abort(500, Constant::ID_SCREEN['SMB0009']);
        }
    }

    /**
     * Show page edit spot
     * @param Type number id
     * @return view
     */
    public function edit($id) {
        return view('spot.edit');
    }
}