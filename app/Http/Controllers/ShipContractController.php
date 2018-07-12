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
            if (is_null($ship->detail_ship) || empty($ship->detail_ship))
                return 'Not exists';
            return view('ship.contract.detail')->with('ship', $ship);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
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
            echo $exc->getTraceAsString();
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
            echo $exc->getTraceAsString();
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
            echo $exc->getTraceAsString();
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
            echo $exc->getTraceAsString();
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
            echo $exc->getTraceAsString();
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
            echo $exc->getTraceAsString();
        }
    }
}
