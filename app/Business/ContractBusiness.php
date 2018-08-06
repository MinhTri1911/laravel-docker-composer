<?php

/**
 * File contract business
 *
 * Handle business related to contract
 * @package App\Business
 * @author Rikkei.DatPDT
 * @date 2018/07/10
 */

namespace App\Business;

use App\Repositories\Contract\ContractInterface;
use App\Repositories\Ship\ShipInterface;
use App\Repositories\TShipSpot\TShipSpotInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Common\Constant;
use App\Common\General;

class ContractBusiness {

    protected $_contractInterface;
    protected $_shipInterface;
    protected $_tShipSpotInterface;

    // 初期登録費 Spot
    const SPOT_ID_REGISTER = 1;
    // データ作成 Spot
    const SPOT_ID_CREATE_DATA = 2;

    public function __construct(
            ContractInterface $contractInterface, 
            ShipInterface $shipInterface, 
            TShipSpotInterface $tShipSpotInterface)
    {
        $this->_contractInterface = $contractInterface;
        $this->_shipInterface = $shipInterface;
        $this->_tShipSpotInterface = $tShipSpotInterface;
    }

    /**
     * Get info company by ship id
     * 
     * @access public
     * @param integer $shipId
     * @return Illuminate\Support\Collection|null
     */
    public function getCompanyByShip($shipId = null)
    {
        // Get list company by ship ID common
        $companies = General::getCompanyByShipOrContract(['shipId' => $shipId]);
        // Take first item company
        if (!is_null($companies) && count($companies) > 0) {
            return $companies->first();
        }

        return null;
    }

    /**
     * Get two spot cost master are register and create data for contract
     * 
     * @access public
     * @param integer $shipId
     * @return Illuminate\Support\Collection|null
     */
    public function getSpotCreateAndRegisterForContract($shipId = null)
    {
        // Inital instanceof MSpot 
        $mSpot = new \App\Repositories\MSpot\MSpotRepository();

        // Get company of ship
        // Base on currency Id, get mspot cost
        $company = $this->getCompanyByShip($shipId);

        // Check exists MSpot
        if (!is_null($mSpot)) {
            return (isset($company->company_id) && !is_null($company->company_id))
                        // Get spot by currency
                        ? $mSpot->getExistsSpotTypeWithCurrency(
                                // Currency of company
                                $company->company_id, 
                                // Get two spot
                                [Constant::SPOT_TYPE_REGISTER, Constant::SPOT_TYPE_CREATE_DATA],
                                // Only get id of spot
                                [
                                    'm_spot.id as spot_id',
                                    'm_spot.type as spot_type'
                                ])
                        : null;
        }

        return null;
    }

    /**
     * Convert list spot to Id spot
     * 
     * @access public
     * @param integer $shipId
     * @return Collection
     */
    public function getSpotIdCreateAndRegisterForContract($shipId = null) {
        $spotId = [];
        // Get list spot by ship id
        $spots = $this->getSpotCreateAndRegisterForContract($shipId);
        // If not exists spot, return empty list
        if (is_null($spots) || count($spots) == 0) {
            return $spotId;
        }

        $spotId['register'] = $spots->filter(function($value, $key){
                            return $value->spot_type == Constant::SPOT_TYPE_REGISTER;
                    })
                            ->first();
        // Get id of spot by type spot
        if (isset($spotId['register']) && !is_null($spotId['register'])) {
            $spotId['register'] = $spotId['register']->spot_id;
        } else {
            unset($spotId['register']);
        }

        // Get id spot create
        $spotId['create'] = $spots->filter(function($value, $key){
                        return $value->spot_type == Constant::SPOT_TYPE_CREATE_DATA;
                    })
                            ->first();

        if (isset($spotId['create']) && !is_null($spotId['create'])) {
            $spotId['create'] = $spotId['create']->spot_id;
        } else {
            unset($spotId['create']);
        }
        // Return list id of two spot create amd register
        return $spotId;
    }

    /**
     * Business create contract
     * 
     * @access public
     * @param arr request
     * @return true/false
     */
    public function createContract($request)
    {
        try {

            DB::beginTransaction();

            $data = [];
            $data['ship_id'] = $request->shipId;
            $data['currency_id'] = $request->currencyId;
            $data['service_id'] = $request->serviceIdHidden;
            $data['start_date'] = str_replace('/', '-', $request->dateStart);
            $data['end_date'] = str_replace('/', '-', $request->dateEnd);
            $data['remark'] = $request->remark;

            $idContract = $this->_contractInterface->createContract($data);
            $data['idContract'] = $idContract;
            $data['chargeRegister'] = $request->chargeRegister;
            $data['chargeCreate'] = $request->chargeCreate;

            $spotMaster = $this->getSpotIdCreateAndRegisterForContract([$request->shipId]);

            // Insert table TShipSlot 
            // ChargeRegister : 1
            if ($data['chargeRegister'] != 0) {
                $this->_tShipSpotInterface->createTShipSpot($data, $spotMaster['register']??0);
            }

            // ChargeCreate : 2
            if ($data['chargeCreate'] != 0) {
                $this->_tShipSpotInterface->createTShipSpot($data, $spotMaster['create']??0);
            }

            DB::commit();

            return true;
        } catch (Exception $ex) {
            Log::info($ex);
            DB::rollBack();
            return false;
        }
    }

    /**
     * Business init create
     * @access public
     * @param int idShip
     * @return mixed Illuminate\Support\Collection
     */
    public function initCreate($idShip)
    {
        return $this->_shipInterface->getIdShip($idShip);
    }

    /**
     * Get contract of ship
     * 
     * @access public
     * @param int $idShip
     * @param int $idContract
     * @return Illuminate\Support\Collection
     */
    public function getContract($idShip, $idContract, $condition = [])
    {
        return $this->_contractInterface->getContract($idShip, $idContract, $condition);
    }

    /**
     * Convert request user to data update
     * 
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return array
     */
    public function convertRequestToDataUpdate($request)
    {
        $config = [];

        if (is_null($request)) {
            return $config;
        }

        // Add service to data update
        if ($request->filled('serviceIdHidden')) {
            $config['serviceId'] = $request->get('serviceIdHidden');
        }
        if ($request->filled('idService')) {
            $config['serviceName'] = $request->get('idService');
        }

        // Add start date and end date to data update
        if ($request->filled('startDate')) {
            $config['startDate'] = $request->get('startDate');
        }
        if ($request->filled('endDate')) {
            $config['endDate'] = $request->get('endDate');
        }

        // Add remark to data update
        if ($request->filled('remark')) {
            $config['remark'] = $request->get('remark');
        }

        // Add Spot 初期登録費/Register and データ作成費/Create to data update
        if ($request->filled('chargeRegister')) {
            $config['chargeRegister'] = preg_replace('/(\.00)|([^0-9]+)/', '', $request->get('chargeRegister'));
        }
        if ($request->filled('chargeCreate')) {
            $config['chargeCreate'] = preg_replace('/(\.00)|([^0-9]+)/', '', $request->get('chargeCreate'));
        }

        // Add ship to data update
        if ($request->has('shipIdHidden') && $request->filled('shipIdHidden')) {
            $config['shipId'] = $request->get('shipIdHidden');
        }
        if ($request->filled('idShip')) {
            $config['shipName'] = $request->get('idShip');
        }

        return $config;
    }

    /**
     * Handle update contract by contract collection
     * 
     * @access public
     * @param Illuminate\Support\Collection $contract
     * @param Illuminate\Support\Facades\Request $request
     * @return boolean
     */
    public function updateContract($contract, $request)
    {
        // Check if contract not exists
        if (is_null($contract) || is_null($request)) {
            return false;
        }
        // Convert request to data update
        $config = $this->convertRequestToDataUpdate($request);
        // Run database transaction to update
        try {
            DB::transaction(function() use ($contract, $config) {
                // When change serrvice, add two spot for contract
                if (isset($config['serviceId']) && 
                        $config['serviceId'] != $contract->contract_service_id) {
                    $this->addSpotForShipContract($contract, $config);
                }
                // Execdute SQL update contract
                $this->processUpdateContract($contract, $config);
            });

            // Redirect to detail ship contract page with message alert update success
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
     * Execute SQL update contract
     * 
     * @access public
     * @param Illuminate\Support\Collection $contract
     * @param array $config
     * @return boolean
     */
    public function processUpdateContract($contract, $config)
    {
        if (count($config) == 0) {
            return false;
        }
        // Set data update
        $dataReasonRejectJson = [
            'service_id'        => $config['serviceId'] ?? null,
            'service_name'      => $config['serviceName'] ?? null,
            'start_date'        => $config['startDate'] ?? null,
            'end_date'          => $config['endDate'] ?? null,
            'remark'            => $config['remark'] ?? null,
            'updated_by'        => auth()->id(),
            'updated_by_name'   => auth()->user()->name,
            'status'            => Constant::STATUS_CONTRACT_ACTIVE
        ];
        // Init variable to contain data
        $dataUpdate = [];

        // If contract with status approved flag is reject create operation, don't update column updated at and revision number
        // Else update column updated at equal now datetime and revision number up to 0.1
        if (is_null($contract->contract_updated_at) 
                && $contract->contract_approved_flag == Constant::STATUS_REJECT_APPROVE) {
            $dataUpdate['updated_at'] = null;
        } else {
            $dataReasonRejectJson['revision_number'] = $contract->contract_revision_number + 0.1;
            $dataUpdate['updated_at'] = date('Y-m-d H:i:s');
        }
        // Merge data update array
        $dataUpdate = array_merge($dataUpdate, [
                'reason_reject' => json_encode($dataReasonRejectJson),
                'approved_flag' => Constant::STATUS_WAITING_APPROVE,
            ]);
        // Execute SQL in repository update contract
        if ($this->_contractInterface->updateContract($contract->contract_id, $dataUpdate)) {
            return true;
        }

        return false;
    }

    /**
     * Handle recover contract by contract collection
     * 
     * @access public
     * @param Illuminate\Support\Collection $contract
     * @param Illuminate\Support\Facades\Request $request
     * @return Illuminate/Http/RedirectResponse
     */
    public function recoverContract($contract, $request)
    {
        // Check if contract not exists
        if (is_null($contract) || is_null($request)) {
            return false;
        }
        // Convert request to data update
        $config = $this->convertRequestToDataUpdate($request);
        // Run database transaction to update
        try {
            // Check exist with contract was enabled inside company
            if ($this->checkExistsContractEnablingOfShip($config, $contract)) {
                return redirect()
                        ->back()
                        ->withErrors([__('contract.error.contract_exists')])
                        ->withInput();
            }

            DB::transaction(function() use ($contract, $config) {
                // When change compnay or contract, add two spot for contract
                if ((isset($config['shipId']) && $config['shipId'] != $contract->contract_ship_id) 
                        || (isset($config['serviceId']) && $config['serviceId'] != $contract->contract_service_id)) {
                    $config['contractId'] = $contract->contract_id;
                    $this->addSpotForShipContract($contract, $config);
                }
                $this->processRecoverContract($contract, $config);
            });

            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
     * Handle recover contract after delete
     * 
     * @param type $contract
     * @param array $config
     */
    public function processRecoverContract($contract, $config)
    {
        if (count($config) == 0) {
            return false;
        }
        // Set data update
        $dataReasonRejectJson = [
            'service_id'        => $config['serviceId'] ?? null,
            'service_name'      => $config['serviceName'] ?? null,
            'ship_id'           => $config['shipId'] ?? null,
            'ship_name'         => $config['shipName'] ?? null,
            'start_date'        => $config['startDate'] ?? null,
            'end_date'          => $config['endDate'] ?? null,
            'remark'            => $config['remark'] ?? null,
            'deleted_at'        => null,
            'del_flag'          => Constant::DELETE_FLAG_FALSE,
            'start_pending_date'=> null,
            'end_pending_date'  => null,
            'updated_by'        => auth()->id(),
            'updated_by_name'   => auth()->user()->name,
            'status'            => Constant::STATUS_CONTRACT_ACTIVE
        ];
        // Init variable to contain data
        $dataUpdate = [];

        /**
         * If contract with status approved flag is reject approve of create operation,
         * don't update column updated at and revision number
         * Else update column updated at equal now datetime and revision number up to 0.1
         */
        if (is_null($contract->contract_updated_at) 
                && $contract->contract_approved_flag == Constant::STATUS_REJECT_APPROVE) {
            $dataUpdate['updated_at'] = null;
        } else {
            $dataReasonRejectJson['revision_number'] =  $contract->contract_revision_number + 0.1;
            $dataUpdate['updated_at'] = date('Y-m-d H:i:s');
        }
        // Merge data update array
        $dataUpdate = array_merge($dataUpdate, [
                'reason_reject' => json_encode($dataReasonRejectJson),
                'approved_flag' => Constant::STATUS_WAITING_APPROVE,
            ]);

        if ($this->_contractInterface->updateContract($contract->contract_id, $dataUpdate)) {
            return true;
        }

        return false;
    }

    /**
     * Handle add spot for ship contract
     * 
     * @access public
     * @param App\Repositories\Contract\ContractInterface $contract
     * @param array $config
     * @return boolean
     */
    public function addSpotForShipContract($contract, $config)
    {
        $dataInsert = [];
        // If data update is empty, don't update
        if (count($config) == 0) {
            return $dataInsert;
        }

        // When service was selected
        if ((isset($config['chargeRegister']) && $config['chargeRegister'] > 0) 
                || (isset($config['chargeCreate']) && $config['chargeCreate'] > 0)) {

            // Get id spot master base on ship
            $spotMaster = $this->getSpotIdCreateAndRegisterForContract([$config['shipId']??$contract->contract_ship_id]);
            // If user input field charge spot register, insert into t_ship_spot else don't insert
            if (isset($config['chargeRegister']) && $config['chargeRegister'] > 0) {
                $dataInsert[] = [
                    'ship_id'       => $config['shipId']??$contract->contract_ship_id,
                    'currency_id'   => $contract->contract_currency_id,
                    'contract_id'   => $contract->contract_id,
                    'month_usage'   => date('Y-m-1'),
                    'spot_id'       => $spotMaster['register'] ?? 0,
                    'amount_charge' => $config['chargeRegister'],
                    'approved_flag' => Constant::STATUS_WAITING_APPROVE,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'created_by'    => auth()->id()
                ];
            }

            // If user input field charge spot create data, insert into t_ship_spot else don't insert
            if (isset($config['chargeCreate']) && $config['chargeCreate'] > 0) {
                $dataInsert[] = [
                    'ship_id'       => $config['shipId']??$contract->contract_ship_id,
                    'currency_id'   => $contract->contract_currency_id,
                    'contract_id'   => $contract->contract_id,
                    'month_usage'   => date('Y-m-1'),
                    'spot_id'       => $spotMaster['create'] ?? 0,
                    'amount_charge' => $config['chargeCreate'],
                    'approved_flag' => Constant::STATUS_WAITING_APPROVE,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'created_by'    => auth()->id()
                ];
            }

            // Execute SQL insert data into t_ship_spot
            // If success, return true else return false
            if (count($dataInsert) > 0) {
                return $this->_contractInterface->insertSpotForShipContract($dataInsert);
            }
        }

        return false;
    }

    /**
     * Add Rule validate request date time start and end of contract
     * 
     * @access public
     * @return array [Rule validate start and end date of contract]
     */
    public function addValidateDateContract()
    {
        // Init rule validate
        $ruleValidate = [];
        // Get id of contract will be validate
        $idContract = request()->route()->parameter('idContract');
        // If not exists contract, ignore validate
        if (is_null($idContract)) {
            return $ruleValidate;
        }
        // Get info of current contract will be validate
        $contract = $this->_contractInterface->find($idContract);

        // If not exists contract, no append rule validate
        if (is_null($contract)) {
            return $ruleValidate;
        }

        /**
         * When contract is inactive:
         * Start date of contract must to greater than or equal current date
         * End date of contract must to greater than start date
         */
        if ($contract->start_date->format('Y-m-d') > date('Y-m-d')) {
            $ruleValidate = [
                'startDate' => 'required|date_format:Y/m/d|after_or_equal:'.date('Y/m/d'),
                'endDate'   => 'required|date|date_format:Y/m/d|after_date_custom:startDate'
            ];

        /**
         * When contract was activating:
         * Start date of contract must to greater than previous start date and 
         * less than last day of old start date month
         * End date of contract must to greater than start date
         */
        } else {
            $ruleValidate = [
                'startDate' => 'required|date_format:Y/m/d|after_or_equal:'
                                        .$contract->start_date->format('Y/m/d').'|before_or_equal:'
                                        .$contract->start_date->format('Y/m/t'),
                'endDate'   => 'required|date|date_format:Y/m/d|after_date_custom:startDate|after_or_equal:'.date('Y/m/d', strtotime(' +1 day'))
            ];
        }

        return $ruleValidate;
    }

    /**
     * Check exists contract was enabled with this ship
     * When if contract was enabled, show message
     * 
     * @access public
     * @param array $config
     * @param array $config
     * @return boolean
     */
    public function checkExistsContractEnablingOfShip($config = [], $oldContract = null)
    {
        if (isset($config['serviceId']) && isset($config['shipId'])) {
            $contracts = $this->_contractInterface->getAllContractEnablingOfShip(
                            $config['shipId'],
                            $config['serviceId'], 
                            $oldContract);

            if (count($contracts) > 0) {
                return true;
            }
        }
        return false;
    }
}
