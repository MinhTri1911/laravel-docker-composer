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
use App\Http\Requests\RestoreContractRequest;

class ContractController extends Controller 
{
    /**
     * Variable handle business 
     * @var App\Business\ContractBusiness 
     */
    private $_contractBusiness;

    /**
     * Inject ContractBusiness
     * @param ContractBusiness $contractBusiness
     */
    public function __construct(ContractBusiness $contractBusiness) {
        $this->_contractBusiness = $contractBusiness;
    }

    /**
     * Show form create new contract
     * 
     * @access public
     * @param int $idShip [Contract of ship]
     * @return Illuminate\Support\Facades\View
     */
    public function initCreate($idShip = '')
    {
        try {

            // Get data ship to show UI
            $data['ship'] = $this->_contractBusiness->initCreate($idShip);
            // If ship not found, show 404 error screen
            if ($data['ship'] == null) {
                return view('exception.notfound');
            }
            // Show view
            return view('contract.create', $data);
        } catch (Exception $ex) {
            Log::info($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500);
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
                return redirect()
                        ->route('ship.contract.detail', $request->shipId)
                        ->with([
                                'type'      => 'success',
                                'message'   => __('common.messages.m038_waiting_approve')
                            ]);
            }
            // Redirect to detail ship contract page with message alert create failed
            return redirect()
                        ->route('ship.contract.detail', $request->shipId)
                        ->with([
                            'type'      => 'danger',
                            'message'   => __('contract.error.E002')
                ]);
        } catch (Exception $ex) {
            Log::info($ex);
            return abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0005']);
        }
    }

    /**
     * Show form edit contract
     *
     * @access public
     * @param  int $id [Id ship]
     * @param  int $id [Id contract]
     * @return Illuminate\Support\Facades\View
     */
    public function edit($idShip = '', $idContract = '')
    {
        try {
            // When edit param on url addressbar
            if (!is_numeric($idShip) || !is_numeric($idContract)) {
                return view('exception.404');
            }

            // Get data of contract and show UI
            $contract = $this->_contractBusiness->getContract($idShip, $idContract);
            // Check exists contract of ship
            if (is_null($contract)) {
                return view('exception.notfound');
            }

            // Show view
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
     * @return Illuminate\Http\RedirectResponse
     */
    public function update($idShip = '', $idContract = '', ContractUpdateRequest $request)
    {
        try {
            // Check token is valid, if token was expired throw exception error
            if (session()->token() != $request->get('_token')) {
                throw new Illuminate\Session\TokenMismatchException;
            }

            if (!is_numeric($idShip) || !is_numeric($idContract)) {
                return view('exception.404');
            }

            // Get list contract to update
            $contract = $this->_contractBusiness->getContract($idShip, $idContract);
            // Check exists contract of ship
            if (is_null($contract)) {
                return view('exception.notfound');
            }

            // Handle update contract
            if ($this->_contractBusiness->updateContract($contract, $request)) {
                // Redirect to detail ship contract page with message alert update success
                return redirect()
                            ->route('ship.contract.detail', $idShip)
                            ->with([
                                'type'      => 'success',
                                'message'   => __('common.messages.m038_waiting_approve')
                    ]);
            }

            // Redirect to detail ship contract page with message alert update failed
            return redirect()
                        ->route('ship.contract.detail', $idShip)
                        ->with([
                            'type'      => 'danger',
                            'message'   => __('contract.error.E002')
                ]);
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0006']);
        }
    }

    /**
     * Show form restore contract
     * 
     * @param  int $idShip [Id ship]
     * @param  int $idContract [Id contract]
     * @return Illuminate\Support\Facades\View
     */
    public function restore($idShip = '', $idContract = '')
    {
        try {
            // When user change param on url addressbar
            if (!is_numeric($idShip) || !is_numeric($idContract)) {
                return view('exception.404');
            }
            // Get info of contract and show on view. Only get d contract was deleted
            // contractStatus is contract was expired
            // contractDelete is del_flag is 1
            $contract = $this->_contractBusiness->getContract(
                                $idShip, 
                                $idContract, 
                                [
                                    'contractStatus' => [Constant::STATUS_CONTRACT_EXPIRED],
                                    'contractDelete' => true
                                ]);

            // Check exists contract of ship
            if (is_null($contract)) {
                return view('exception.notfound');
            }

            return view('contract.restore', compact('contract'));
        } catch (Exception $exc) {
            Log::error($exc->getFile() . ' on ' . $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0007']);
        }
    }
    
    /**
     * Recover contract with new data when contract was expired or deleted
     * 
     * @access public
     * @param type $idShip
     * @param type $idContract
     * @param App\Http\Requests\RestoreContractRequest $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function recover($idShip = '', $idContract = '', RestoreContractRequest $request)
    {
        try {
            // Check token is valid, if token was expired throw exception error
            if (session()->token() != $request->get('_token')) {
                throw new Illuminate\Session\TokenMismatchException;
            }
            // When user change param on url addressbar
            if (is_null($idShip) || is_null($idContract) || !is_numeric($idShip)
                    || !is_numeric($idContract)) {
                return view('exception.404');
            }

            // Get list contract to update
            $contract = $this->_contractBusiness->getContract(
                            $idShip, 
                            $idContract,
                            [
                                // Contract was expired
                                'contractStatus' => [Constant::STATUS_CONTRACT_EXPIRED],
                                // Contract was deleted
                                'contractDelete' => true
                            ]);

            // Check exists contract of ship
            if (is_null($contract)) {
                return view('exception.notfound');
            }

            // Handle update contract
            if ($this->_contractBusiness->recoverContract($contract, $request)) {
                // Redirect to detail ship contract page with message alert update success
                return redirect()
                        ->route('ship.contract.detail', $idShip)
                        ->with([
                            'type'      => 'success',
                            'message'   => __('common.messages.m038_waiting_approve')
                        ]);
            }
            // Redirect to detail ship contract page with message alert update failed
            return redirect()
                        ->route('ship.contract.detail', $idShip)
                        ->with([
                            'type'      => 'danger',
                            'message'   => __('contract.error.E002')
                    ]);
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0007']);
        }
    }
}
