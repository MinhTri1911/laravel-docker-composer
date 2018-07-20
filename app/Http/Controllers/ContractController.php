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
    public function initCreate($idShip = '') {
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
    public function create(ContractRequest $request) {
        try {
            $isInsert = $this->_contractBusiness->createContract($request);
            if ($isInsert) {
                return redirect()->route('ship.contract.detail', $request->shipId);
            }
            return abort(500, Constant::ID_SCREEN['SMB0005']);
        } catch (Exception $ex) {
            Log::info($ex);
            return abort(500, Constant::ID_SCREEN['SMB0009']);
        }
    }

    /**
     * Show form edit contract
     *
     * @param  int $id [Id contract]
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id = '') {
        return view('contract.edit');
    }

    /**
     * Show form restore contract
     * 
     * @param  int $id [Id contract]
     * @return Illuminate\Support\Facades\View
     */
    public function restore($id = '') {
        return view('contract.restore');
    }

}
