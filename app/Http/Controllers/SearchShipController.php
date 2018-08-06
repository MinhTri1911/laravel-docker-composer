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
            $response = [
                'ships' => $this->_shipBusiness->initSearchShip($companyId)
            ];
            
            $service = $this->_shipBusiness->getPriceService($request);
            if(!is_null($service) && count($service) > 0) {
                $response['services'] = $service;
            }
            
            return response()->json($response);
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
            $response = [
                'ships' => $this->_shipBusiness->searchShip($companyId, $idShipSearch, $nameShipSearch)
            ];
            
            $service = $this->_shipBusiness->getPriceService($request);
            if(!is_null($service) && count($service) > 0) {
                $response['services'] = $service;
            }
            return response()->json($response);
            
        } catch (Exception $ex) {
            Log::info($ex);
        }
    }
}
