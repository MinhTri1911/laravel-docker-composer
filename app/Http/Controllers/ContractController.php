<?php

/**
 * Contract controller
 *
 * @package App\Http\Controllers
 * @author Rikkei.DatPDT
 * @date 2018/06/13
 */

namespace App\Http\Controllers;

use App\Business\ContractBusiness;
use App\Http\Requests\ContractRequest;
use App\Http\Requests\ContractUpdateRequest;
use App\Common\Constant;
use Illuminate\Support\Facades\Log;
use Exception;

class ContractController extends Controller 
{
    private $_contractBusiness;

    public function __construct(ContractBusiness $contractBusiness) {
        $this->_contractBusiness = $contractBusiness;
    }

    /**
     * Show form create new contract
     * @return Illuminate\Support\Facades\View
     */
    public function initCreate($idShip = '')
    {
        try {
            $data['ship'] = $this->_contractBusiness->initCreate($idShip);

            if ($data['ship'] == null) {
                return abort('NotFound');
            }
            return view('contract.create', $data);
        } catch (Exception $ex) {
            Log::info($ex);
            return abort('NotFound');
        }
    }

    /**
     * Handel create contract
     * @return Illuminate\Support\Facades\View
     */
    public function create(ContractRequest $request)
    {
        try {
            $isInsert = $this->_contractBusiness->createContract($request);
            if ($isInsert) {
                return redirect()->route('ship.contract.detail', $request->shipId);
            }
            return abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0005']);
        } catch (Exception $ex) {
            Log::info($ex);
            return abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0009']);
        }
    }

    /**
     * Show form edit contract
     *
     * @param  int $id [Id contract]
     * @return Illuminate\Support\Facades\View
     */
    public function edit($idShip = '', $idContract = '')
    {
        try {
            $contract = $this->_contractBusiness->getContract($idShip, $idContract);
            // Check exists contract of ship
            if (is_null($contract)) {
                return view('exception.notfound');
            }

            return view('contract.edit', compact('contract'));
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0006']);
        }
    }

    /**
     * Update contract with data from request from client
     *
     * @access public
     * @param  int $idShip [Id of ship]
     * @param  int $idContract [Id of contract]
     * @param  int App\Http\Requests\ContractUpdateRequest $request
     * 
     * @return Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update($idShip = '', $idContract = '', ContractUpdateRequest $request)
    {
        try {
            // Check token is valid, if token was expired throw exception error
            if (session()->token() != $request->get('_token')) {
                throw new Illuminate\Session\TokenMismatchException;
            }

            // Get list contract to update
            $contract = $this->_contractBusiness->getContract($idShip, $idContract);
            // Check exists contract of ship
            if (is_null($contract)) {
                return view('exception.notfound');
            }

            // Handle update contract
            return $this->_contractBusiness->updateContract($contract, $request);
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0006']);
        }
    }

    /**
     * Show form restore contract
     * 
     * @param  int $id [Id contract]
     * @return Illuminate\Support\Facades\View
     */
    public function restore($id = '')
    {
        return view('contract.restore');
    }
}
