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

class ContractController extends Controller 
{

    private $_contractBusiness;

    public function __construct(ContractBusiness $contractBusiness) 
    {
        $this->_contractBusiness = $contractBusiness;
    }

    /**
     * Show form create new contract
     * @return Illuminate\Support\Facades\View
     */
    public function initCreate($idShip = '') 
    {
        $data['ship'] = $this->_contractBusiness->initCreate($idShip);

        if ($data['ship'] == null) {
            return abort(404);
        }
        return view('contract.create', $data);
    }

    /**
     * Handel create contract
     * @return Illuminate\Support\Facades\View
     */
    public function create(ContractRequest $request) 
    {
        $isInsert = $this->_contractBusiness->createContract($request);

        if ($isInsert) {
            return redirect()->route('ship.contract.detail', $request->shipId);
        }

        return abort(404);
    }

    /**
     * Show form edit contract
     *
     * @param  int $id [Id contract]
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id = '') 
    {
        return view('contract.edit');
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
