<?php

/**
 * ShipContractController.php
 *
 * Handle business and logic ship and contract data
 *
 * @package    ShipContract
 * @author     Rikkei.DungLV
 * @date       2018/07/03
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\ShipContractBusiness;
use Exception;
use App\Common\Constant;
use Illuminate\Support\Facades\Log;

class ShipContractController extends Controller
{
    // Business ship contract
    private $_shipContractBusiness;

    // Set default number record per page
    const N_RECORD_PAGE = 10;

    /**
     * Constructor dependency inject dependency to controller
     *
     * @access public
     * @param App\Business\ShipContractBusiness $shipContractBusiness
     * @return Object
     */
    public function __construct(ShipContractBusiness $shipContractBusiness)
    {
        $this->_shipContractBusiness = $shipContractBusiness;
    }

    /**
     * Show detail ship and anything  realted to ship, eg contract, spot, etc...
     *
     * @access public
     * @param integer $id
     * @param Illuminate\Support\Facades\Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function detail($id = '', Request $request)
    {
        try {
            // Ship detail get from business
            $ship = $this->_shipContractBusiness->getShipContractById($id, $request);

            // If ship not exists, show not found page
            if (is_null($ship->detail_ship) || empty($ship->detail_ship)) {
                return view('exception.404');
            }

            return view('ship.contract.detail')->with('ship', $ship);
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine().'\n'.$exc->getMessage());
            abort(Constant::HTTP_CODE_ERROR_500, "Not found 456");
        }
    }

    /**
     * Restore contract of a ship
     *
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return Illuminate\Support\Facades\Respons Response ajax
     */
    public function restoreContract(Request $request)
    {
        try {
            return response()->json($this->_shipContractBusiness->restoreContract($request));
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, $exc->getMessage());
        }
    }

    /**
     * Disable contract from ajax request
     *
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return Illuminate\Support\Facades\Respons Response ajax
     */
    public function disableContract(Request $request)
    {
        try {
            return response()->json($this->_shipContractBusiness->disableContract($request));
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, $exc->getMessage());
        }
    }

    /**
     * Delete contract from request ajax.
     *
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function deleteContract(Request $request)
    {
        try {
            return response()->json($this->_shipContractBusiness->deleteContract($request));
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, $exc->getMessage());
        }
    }

    /**
     * Delete spot from ajax request
     *
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function deleteSpot(Request $request)
    {
        try {
            return response()->json($this->_shipContractBusiness->deleteSpot($request));
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, $exc->getMessage());
        }
    }

    /**
     * Show reason reject of request approved
     *
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function getReasonReject(Request $request)
    {
        try {
            return response()->json($this->_shipContractBusiness->getReasonReject($request));
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, $exc->getMessage());
        }
    }

    /**
     * Delete ship from request ajax
     *
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function deleteShip(Request $request)
    {
        try {
            return response()->json($this->_shipContractBusiness->deleteShip($request));
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, $exc->getMessage());
        }
    }

    /**
     * Show page create ship contract
     * @param Illuminate\Support\Facades\Request request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if (!$request->get('company-id') || !is_numeric($request->get('company-id'))) {
            abort(404);
        }

        try {
            $data = $this->_shipContractBusiness->initCreateShipContract($request->get('company-id'));
        } catch (\Exception $e) {
            // abort(404);
            dd($e);
        }

        return view('ship.create-ship-contract', [
            'company' => $data['company'],
            'shipTypes' => $data['shipTypes'],
            'classificationies' => $data['classificationies'],
            'nations' => $data['nations'],
            'companyId' => $request->get('company-id'),
            'services' => $data['services']
        ]);
    }
}
