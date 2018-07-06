<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\ShipContractBusiness;

class ShipContractController extends Controller
{
    private $_shipContractBusiness;
    
    const N_RECORD_PAGE = 10;


    /**
     * 
     * @param ShipContractBusiness $shipContractBusiness
     */
    public function __construct(ShipContractBusiness $shipContractBusiness) {
        $this->_shipContractBusiness = $shipContractBusiness;
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function detail($id = '') {
        
        $ship = $this->_shipContractBusiness->getShipContractById(1);
        if(is_null($ship->detail_ship) || empty($ship->detail_ship))
            return 'Not exists';
        
        return view('ship.contract.detail')->with('ship', $ship);
    }
    
    /**
     * 
     * @param Illuminate\Support\Facades\Request $request
     */
    public function restoreContract(Request $request) {
        
        return response()->json($this->_shipContractBusiness->restoreContract($request));
    }
    
    /**
     * 
     * @param Illuminate\Support\Facades\Request $request
     */
    public function disableContract(Request $request) {
        return response()->json($this->_shipContractBusiness->disableContract($request));
    }
    
    /**
     * 
     * @param Illuminate\Support\Facades\Request $request
     */
    public function deleteContract(Request $request) {
        return response()->json($this->_shipContractBusiness->deleteContract($request));
    }
    
    /**
     * 
     * @param Illuminate\Support\Facades\Request $request
     */
    public function deleteSpot(Request $request) {
        return response()->json($this->_shipContractBusiness->deleteSpot($request));
    }
}
