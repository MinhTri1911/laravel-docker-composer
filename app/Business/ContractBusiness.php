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

class ContractBusiness {

    protected $_contractInterface;
    protected $_shipInterface;
    protected $_tShipSpotInterface;

    // 初期登録費 Spot
    const SPOT_ID_REGISTER = 1;
    // データ作成 Spot
    const SPOT_ID_CREATE_DATA = 2;

    public function __construct(ContractInterface $contractInterface, ShipInterface $shipInterface, TShipSpotInterface $tShipSpotInterface) {
        $this->_contractInterface = $contractInterface;
        $this->_shipInterface = $shipInterface;
        $this->_tShipSpotInterface = $tShipSpotInterface;
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

            // Insert table TShipSlot 
            // ChargeRegister : 1
            if ($data['chargeRegister'] != 0) {
                $this->_tShipSpotInterface->createTShipSpot($data, self::SPOT_ID_REGISTER);
            }

            // ChargeCreate : 2
            if ($data['chargeCreate'] != 0) {
                $this->_tShipSpotInterface->createTShipSpot($data, self::SPOT_ID_CREATE_DATA);
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
    public function getContract($idShip, $idContract)
    {
        return $this->_contractInterface->getContract($idShip, $idContract);
    }

    /**
     * Handle update contract by contract collection
     * 
     * @access public
     * @param Illuminate\Support\Collection $contract
     * @param Illuminate\Support\Facades\Request $request
     * @return Illuminate/Http/RedirectResponse
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
                if (isset($config['serviceId']) && $config['serviceId'] != $contract->contract_service_id) {
                    $this->addSpotForShipContract($contract, $config);
                }
                $this->processUpdateContract($contract, $config);
            });
            // Redirect to detail ship contract page with message alert update success
            return redirect()
                        ->route('ship.contract.detail', $contract->contract_ship_id)
                        ->with([
                            'type' => 'success',
                            'message' => __('common.messages.m038_delete_watting_approve')
            ]);
        } catch (\Exception $exc) {
            // Redirect to detail ship contract page with message alert update failed
            return redirect()
                        ->route('ship.detail', $contract->contract_ship_id)
                        ->with([
                            'type' => 'danger',
                            'message' => 'Update không thành công'
            ]);
        }
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
        return $config;
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

        // If contract with status approved flag is waiting approve, don't update column updated at and revision number
        // Else update column updated at equal now datetime and revision number up to 0.1
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

        // If user input field charge spot register, insert into t_ship_spot else don't insert
        if (isset($config['chargeRegister']) && $config['chargeRegister'] > 0) {
            $dataInsert[] = [
                'ship_id'       => $contract->contract_ship_id,
                'currency_id'   => $contract->contract_currency_id,
                'month_usage'   => date('Y-m-1'),
                'spot_id'       => self::SPOT_ID_REGISTER,
                'amount_charge' => $config['chargeRegister'],
                'approved_flag' => Constant::STATUS_WAITING_APPROVE,
                'created_at'    => date('Y-m-d H:i:s'),
                'created_by'    => auth()->id()
            ];
        }

        // If user input field charge spot create data, insert into t_ship_spot else don't insert
        if (isset($config['chargeCreate']) && $config['chargeCreate'] > 0) {
            $dataInsert[] = [
                'ship_id'       => $contract->contract_ship_id,
                'currency_id'   => $contract->contract_currency_id,
                'month_usage'   => date('Y-m-1'),
                'spot_id'       => self::SPOT_ID_CREATE_DATA,
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
        $ruleValidate = [];

        $idContract = request()->route()->parameter('idContract');

        if (is_null($idContract)) {
            return array();
        }

        $contract = $this->_contractInterface->find($idContract);

        if (is_null($contract)) {
            return array();
        }

        // Contract is unactive
        if ($contract->start_date->format('Y-m-d') > date('Y-m-d')) {
            $ruleValidate = [
                'startDate' => 'required|date|date_format:Y/m/d|after_or_equal:'.date('Y/m/d'),
                'endDate' => 'required|date|date_format:Y/m/d|after_date_custom:startDate'
            ];

        // Contract was activated
        } else {
            $ruleValidate = [
                'startDate' => 'required|date|date_format:Y/m/d|after_or_equal:'.$contract->start_date->format('Y/m/d').'|before_or_equal:'.$contract->start_date->format('Y/m/t'),
                'endDate' => 'required|date|date_format:Y/m/d|after_date_custom:startDate|after_or_equal:'.date('Y/m/d')
            ];
        }

        return $ruleValidate;
    }
}
