<?php

namespace App\Http\Controllers;

use App\Business\ShipBusiness;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchShipController extends Controller 
{

    private $_shipBusiness;

    public function __construct(ShipBusiness $shipBusiness) 
    {
        $this->_shipBusiness = $shipBusiness;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        try {
            
            $companyId = $request->get('companyId');

            return $this->_shipBusiness->initSearchShip($companyId);
            
        } catch (Exception $ex) {
            Log::info($ex);
        }
    }
    
    /**
     * Search a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) 
    {
        try {
           
            $companyId = $request->get('companyId');
            $idShipSearch = $request->get('idShipSearch'); 
            $nameShipSearch = $request->get('nameShipSearch'); 
            
            return $this->_shipBusiness->searchShip($companyId, $idShipSearch, $nameShipSearch);
            
        } catch (Exception $ex) {
            dd($ex);
            Log::info($ex);
        }
    }
}
