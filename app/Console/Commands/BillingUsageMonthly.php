<?php
/**
 * Batch calculate billing usage monthly of ship
 *
 * @package App\Console\Commands
 * @author Rikkei.quangpm
 * @date 2018/06/19
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use DB;
use App\Common\LoggingCommon as Log;
use App\Common\Constant;

class BillingUsageMonthly extends Command
{

    // The name and signature of the console command.
    protected $signature = 'batch:billingUsageMonthly';

    // The console command description.
    protected $description = 'Calculate billing usage monthly of ship';

    // The Object log.
    private $_log = null;

    private $_monthUsage = '';
    private $_now = '';
    private $_rateCurrency = 1;

    /**
     * Create a new command instance.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_log = Log::BBA0005Log();
    }

    /**
     * Execute the console command.
     *
     * @access public
     * @return void
     */
    public function handle()
    {
        try {
            $isException = 0;

            $this->error('START');
            $this->_log->info('');
            $this->_log->info('START');

            // Get list company ship
            $listShipCompany = $this->_getListCompanyShip();

            // Begin transaction
            DB::beginTransaction();
            $transLevelRoot = DB::transactionLevel();

            if ($listShipCompany !== null && count($listShipCompany) > 0) {

                // Set month usage batch
                $now = date('Y-m-d');
                $this->_monthUsage = date('Y-m-d', strtotime($now . ' first day of -1 month'));

                // Set currency time
                $monthNow = date('Y-m');
                $this->_now = $monthNow . '-01 00:00:00';

                // Set variable ID company for Process loop company 
                $companyIdTempl = -1;

                // List ID expired Contract
                $listExpiredContract = [];

                // Set Discount common
                $discountCommon = 0;

                // Loop and processing every company
                foreach ($listShipCompany as $shipCompany) {

                    $currencyId = $shipCompany->currency_id;
                    $companyId = $shipCompany->id;
                    $shipId = $shipCompany->ship_id;

                    // Case: First record of every Company
                    if ($companyIdTempl != $companyId) {

                        // Set parameter
                        $companyIdTempl = $companyId;
                        $this->_rateCurrency = $shipCompany->rate;
                        $discountCommon = $this->_processLoopCompany($companyId, $currencyId);
                    }

                    // Total money billing
                    $totalMoneyBilling = 0;

                    // Create save point transaction
                    DB::beginTransaction();

                    // Process for loop ship: First record of every Ship
                    $historyUsageId = $this->_processLoopShip($shipId, $currencyId, $totalMoneyBilling);
                    if ($historyUsageId === null) {
                        $isException = 1;
                        break;
                    }

                    // Get information of contract, charge service, total license, discount individual
                    $listContract = $this->_getInforContract($companyId, $shipId);
                    if ($listContract === null) {
                        $isException = 1;
                        break;
                    }

                    // Rollback data insert history usage if No has contract and charge spot
                    if (count($listContract) == 0 && $totalMoneyBilling == 0) {
                        DB::rollBack($transLevelRoot);
                        continue;
                    }
                    // Merge trasaction
                    DB::commit();

                    // Loop list contract
                    foreach ($listContract as $contract) {

                        $totalMoneyBilling = $this->_processLoopContract($contract, $discountCommon, $totalMoneyBilling, $historyUsageId);
                        if ($totalMoneyBilling === null) {
                            $isException = 1;
                            break;
                        }

                        // Get list ID of contract expired
                        $now = date('Y-m-d', strtotime($this->_now));
                        if ($contract->end_date < $now) {
                            $listExpiredContract[] = $contract->contract_id;
                        }
                    }

                    // Check exist exception
                    if ($isException == 1) {
                        break;
                    }

                    // Update total money of table t_history_usage
                    $resultUpdateMoney = $this->_updateTotalMoneyHistoryUsage($historyUsageId, $totalMoneyBilling);
                    if ($resultUpdateMoney === null) {
                        $isException = 1;
                        break;
                    }
                }

                // Update status of expired contract
                $resultUpdateStatus = $this->_updateStatusOfExpiredContract($listExpiredContract);
                if ($resultUpdateStatus === null) {
                    $isException = 1;
                }
            } elseif ($listShipCompany === null) {
                $isException = 1;
            }

            // Check exist exception
            if ($isException == 1) {
                // Rollback transaction
                DB::rollBack();

                $this->error('Error Exception');
            } else {
                // Commit transaction
                DB::commit();

                $this->_log->info('END');
                $this->error('END');
            }
            
        } catch (Exception $ex) {
            // Rollback transaction
            DB::rollBack();
            $this->error($ex->getMessage());
        }
        
    }

    /**
     * Process loop contract
     * 
     * @param object $contract Object contract 
     * @param float $discountCommon Amount discount common
     * @param type $totalMoneyBilling Total money billing
     * @param type $historyUsageId History usage ID
     * @return null|float
     */
    private function _processLoopContract ($contract, $discountCommon, $totalMoneyBilling, $historyUsageId)
    {
        // Set parameter contract
        $serviceId = $contract->service_id;
        $cLNumber = $contract->license_count === null ? 0 : $contract->license_count;
        $discountIndividual = $contract->discount_individual === null ? 0 : $contract->discount_individual;

        // Get Charge Volume discount of service
        $volumeDiscount = $this->_getChargeVolumeDiscount($serviceId, $cLNumber);
        if ($volumeDiscount === null) {
            return null;
        }

        // Calculate discount of service
        $moneyDiscount = 0;
        $discountId = 0;
        if ($volumeDiscount >= $discountCommon) {
            $moneyDiscount = $volumeDiscount;
            $discountId = Constant::DETAIL_CHARGE_VOLUME_DISCOUNT;
            if ($discountIndividual > $volumeDiscount) {
                $moneyDiscount = $discountIndividual;
                $discountId = Constant::DETAIL_CHARGE_DISCOUNT_INDIVIDUAL;
            }
        } else {
            $moneyDiscount = $discountCommon;
            $discountId = Constant::DETAIL_CHARGE_DISCOUNT_COMMON;
            if ($discountIndividual > $discountCommon) {
                $moneyDiscount = $discountIndividual;
                $discountId = Constant::DETAIL_CHARGE_DISCOUNT_INDIVIDUAL;
            }
        }

        // Insert price service into table t_detail_history_usage
        $resultRegisterPriceService = $this->_registerPriceService($historyUsageId, $contract);
        $totalMoneyBilling += $contract->price_service;
        if ($resultRegisterPriceService === null) {
             return null;
        }

        // Register money discount into table t_detail_history_usage
        $totalMoneyBilling -= $moneyDiscount;
        $result = $this->_registerMoneyDiscount($historyUsageId, $contract, $moneyDiscount, $discountId);
        if ($result === null) {
            return null;
        }

        return $totalMoneyBilling;
    }

    /**
     * Get list company and ship active
     *
     * @access private
     * @return null|object
     */
    private function _getListCompanyShip()
    {
        try {
            return DB::table('m_company')
                ->select('m_company.id', 'm_company.currency_id', 'm_ship.id AS ship_id', 'm_currency.rate')
                ->join('m_ship', function ($join) {
                    $join->on('m_ship.company_id', '=', 'm_company.id');
                })
                ->join('m_currency', function ($join) {
                    $join->on('m_company.currency_id', '=', 'm_currency.id')
                        ->where('m_currency.del_flag', '=', Constant::DELETE_FLAG_FALSE);
                })
                ->distinct()
                ->orderBy('m_company.id', 'ASC')
                ->get();

        } catch (Exception $ex) {
            $this->_log->err("Get list company fail: " . $ex->getMessage());
            $this->error('\n Get list company fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * Process for loop company: First record of every company
     *
     * @param int $companyId Company ID
     * @param int $currencyId Currency ID
     * @return null|float $discountCommon
     */
    private function _processLoopCompany($companyId, $currencyId)
    {

        // Get discount common of company
        $objectDiscountCommon = $this->_getDiscountCommon($companyId, $currencyId);
        if ($objectDiscountCommon === null) {
            return null;
        }

        // Set discount common
        $discountCommon = 0;
        if (count($objectDiscountCommon) > 0) {
            $discountCommon = $objectDiscountCommon[0]->money_discount === null ? 0 : $objectDiscountCommon[0]->money_discount;
        }

        return $discountCommon;
    }

    /**
     * Get discount common of company
     *
     * @access private
     * @param int $companyId Company ID
     * @param int $currencyId Currency ID
     * @return null|object
     */
    private function _getDiscountCommon($companyId, $currencyId)
    {
        try {
            return DB::table('t_discount_common')
                ->select('money_discount')
                ->where([
                    ['company_id', '=', $companyId],
                    ['setting_month', '=', $this->_monthUsage],
                    ['currency_id', '=', $currencyId],
                    ['del_flag', '=', Constant::DELETE_FLAG_FALSE]])
                ->get();

        } catch (Exception $ex) {
            $this->_log->err('Get discount common of company fail: ' . $ex->getMessage());
            $this->error('Get discount common of company fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * Get information of contract, charge service, total license, discount individual
     *
     * @access private
     * @param int $companyId Company Id
     * @param int $shipId Ship Id
     * @return null|object
     */
    private function _getInforContract($companyId, $shipId)
    {

        try {
            // Get month usage string
            $date = strtotime($this->_monthUsage);
            $monthUsageString = "'" . date('Y-m', $date) . "'";

            // Get count of license active
            $license = DB::raw(
                "(SELECT SC.service_id, SCO.id AS company_id
                    , COUNT(SC.service_id) AS license_count
                FROM m_contract AS SC
                        INNER JOIN m_ship AS SSH ON SSH.id = SC.ship_id
                        INNER JOIN m_company AS SCO ON SCO.id = SSH.company_id
                WHERE (SC.del_flag = " . Constant::DELETE_FLAG_FALSE ."
                        AND (SC.status = ".Constant::STATUS_CONTRACT_ACTIVE." 
                            AND (SC.approved_flag = ".Constant::STATUS_APPROVED." "
                             . " OR (SC.approved_flag <> ".Constant::STATUS_APPROVED." AND SC.updated_at IS NOT NULL))))
                GROUP BY SCO.id, SC.service_id) AS licenseTbl");

            // Get information contract 
            $contract = DB::raw(
                "(SELECT C.id AS contract_id, C.ship_id, C.service_id
                    , C.currency_id, C.start_date, C.end_date, C.end_pending_date
                 FROM m_contract AS C
                 WHERE C.ship_id = " . $shipId . " AND
                     ((C.del_flag = " . Constant::DELETE_FLAG_TRUE ." AND C.start_date < '".$this->_now ."'
                            AND SUBSTR(C.deleted_at, 1, 7) = " .$monthUsageString
                     . " AND (C.status = ".Constant::STATUS_CONTRACT_ACTIVE." 
                            OR (C.status = ".Constant::STATUS_CONTRACT_PENDING." AND SUBSTR(C.start_pending_date, 1, 7) = ".$monthUsageString.")))

                     OR (C.del_flag = ".Constant::DELETE_FLAG_FALSE
                       . " AND ((C.status = ".Constant::STATUS_CONTRACT_ACTIVE. "
                               AND ((SUBSTR(C.start_pending_date, 1, 7) = ".$monthUsageString." AND C.end_pending_date IS NULL 
                                        AND SUBSTR(C.start_date, 1, 7) = ".$monthUsageString.") 
                                    OR (SUBSTR(C.start_pending_date, 1, 7) = SUBSTR(C.end_pending_date, 1, 7) AND C.start_date < '".$this->_monthUsage."')
                                    OR (C.start_date < '".$this->_monthUsage."' "
                                        . "AND (C.end_pending_date IS NULL OR SUBSTR(C.end_pending_date, 1, 7) <> ".$monthUsageString.")))
                                AND (C.approved_flag = ".Constant::STATUS_APPROVED
                                    ." OR (C.approved_flag <> ".Constant::STATUS_APPROVED." AND C.updated_at IS NOT NULL)))

                         OR (C.status = ".Constant::STATUS_CONTRACT_PENDING." AND C.start_date < '" . $this->_now . "'
                            AND C.updated_at IS NOT NULL AND SUBSTR(C.start_pending_date, 1, 7) = ".$monthUsageString."))))
                UNION ALL 
                SELECT HC.contract_id, HC.ship_id, HC.service_id
                   , HC.currency_id, HC.start_date, HC.end_date, HC.end_pending_date
                FROM m_contract AS C
                INNER JOIN t_history_contract AS HC ON HC.contract_id = C.id
                WHERE HC.ship_id = " . $shipId 
                    . " AND (HC.del_flag = " . Constant::DELETE_FLAG_TRUE ." AND HC.start_date < '".$this->_now ."'
                            AND SUBSTR(HC.deleted_at, 1, 7) = " .$monthUsageString
                        . " AND (HC.status = ".Constant::STATUS_CONTRACT_ACTIVE." 
                               OR (HC.status = ".Constant::STATUS_CONTRACT_PENDING." AND SUBSTR(HC.start_pending_date, 1, 7) = ".$monthUsageString.")))
                ) AS C");

            $contractResult = DB::table('m_company AS CO')
                ->select(DB::raw("CO.id AS company_id
                                , CO.currency_id
                                , C.contract_id
                                , C.ship_id
                                , C.service_id
                                , C.start_date
                                , C.end_date
                                , C.end_pending_date
                                , licenseTbl.license_count
                                , S.name_short
                                , DI.money_discount AS discount_individual
                                , PS.price AS price_service"))
                ->join('m_ship AS SH', 'SH.company_id', '=', 'CO.id')
                ->join($contract, function ($join) {
                    $join->on('C.ship_id', '=', 'SH.id')
                        ->on('C.currency_id', '=', 'CO.currency_id');
                })
                ->join('m_service AS S', 'S.id', '=', 'C.service_id')
                ->join('t_price_service AS PS', function ($join) {
                    $join->on('PS.service_id', '=', 'C.service_id')
                        ->on('PS.currency_id', '=', 'C.currency_id')
                        ->where('PS.del_flag' , '=', Constant::DELETE_FLAG_FALSE);
                })
                ->leftJoin($license, function ($join) {
                    $join->on('licenseTbl.service_id', '=', 'C.service_id')
                        ->on('licenseTbl.company_id' , '=', 'CO.id');
                })
                ->leftJoin('t_discount_individual AS DI', function ($join) {
                    $join->on('DI.contract_id', '=', 'C.contract_id')
                        ->on('DI.currency_id' , '=', 'C.currency_id')
                        ->where('DI.setting_month' , '=', $this->_monthUsage)
                        ->where('DI.del_flag' , '=', Constant::DELETE_FLAG_FALSE);
                })
                ->orderBy('C.service_id', 'ASC')
                ->get();

            return $contractResult;

        } catch (Exception $ex) {
            $this->_log->err('Get information of contract, charge service, total license, discount individual fail:' . $ex->getMessage());
            $this->error('Get information of contract, charge service, total license, discount individual fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * Process for loop ship: First record of every Ship
     *
     * @param int $shipId Ship ID
     * @param int $currencyId Currency ID
     * @param float $totalMoneyBilling Total money billing
     * @return null|int $historyUsageId
     */
    private function _processLoopShip($shipId, $currencyId, &$totalMoneyBilling)
    {

        // Insert table t_history_usage
        $historyUsageId = $this->_insertHistoryUsage($shipId, $currencyId);
        if ($historyUsageId === null) {
            return null;
        }

        // Get list charge SPOT
        $listChargeSpot = $this->_getlistChargeSpot($shipId, $currencyId);
        if ($listChargeSpot === null) {
            return null;
        }

        // Insert list to table t_ship_spot
        $totalMoneySpot = $this->_insertListChargeSpot($historyUsageId, $listChargeSpot);
        if ($totalMoneySpot === null) {
            return null;
        }
        $totalMoneyBilling += $totalMoneySpot;

        return $historyUsageId;
    }

    /**
     * Insert table t_history_usage
     *
     * @access private
     * @param int $shipId Ship ID
     * @param int $currencyId Currency ID
     * @return null|int
     */
    private function _insertHistoryUsage($shipId, $currencyId)
    {
        try {
            // Add value insert
            $arrDataInsert = [
                'ship_id' => $shipId,
                'month_usage' => $this->_monthUsage,
                'currency_id' => $currencyId,
                'created_at' => date('Y-m-d H:i:s')
            ];

            return DB::table('t_history_usage')->insertGetId($arrDataInsert);

        } catch (Exception $ex) {
            $this->_log->err('Insert table t_history_usage fail: ' . $ex->getMessage());
            $this->error('Insert table t_history_usage fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * Get list charge spot
     *
     * @access private
     * @param int $shipId Ship ID
     * @param int $currencyId Currency ID
     * @return null|object
     */
    private function _getlistChargeSpot($shipId, $currencyId)
    {
        try {
            return DB::table('t_ship_spot AS SP')
                ->select('SP.ship_id'
                    , 'SP.spot_id'
                    , 'SP.currency_id'
                    , 'SP.amount_charge'
                    , 'SP.remark'
                    , 'S.name_jp')
                ->join('m_spot AS S', function ($join) {
                    $join->on('S.id', '=', 'SP.spot_id')
                        ->where('S.del_flag', '=', Constant::DELETE_FLAG_FALSE);
                })
                ->where([['SP.ship_id', '=', $shipId],
                    ['SP.currency_id', '=', $currencyId],
                    ['SP.month_usage', '=', $this->_monthUsage],
                    ['SP.del_flag', '=', Constant::DELETE_FLAG_FALSE]])
                ->whereRaw("(SP.approved_flag = ? OR ((SP.approved_flag = ? OR SP.approved_flag = ?) AND SP.updated_at IS NOT NULL))"
                    , [Constant::STATUS_APPROVED, Constant::STATUS_WAITING_APPROVE, Constant::STATUS_REJECT_APPROVE])
                ->get();

        } catch (Exception $ex) {
            $this->_log->err('Get list charge spot fail: ' . $ex->getMessage());
            $this->error('Get list charge spot fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * Insert list to table t_detail_history_usage
     *
     * @access private
     * @param int $historyUsageId History usage ID
     * @param array $listChargeSpot List object charge spot
     * @return null|float $totalMoneySpot Total charge spot
     */
    private function _insertListChargeSpot($historyUsageId, $listChargeSpot)
    {
        try {
            $totalMoneySpot = 0;
            $arrListInsert = [];

            foreach ($listChargeSpot as $spot) {

                // Add value insert
                if ($spot->amount_charge != 0) {
                    $arrListInsert[] = [
                        'history_usage_id' => $historyUsageId,
                        'charge_type_id' => Constant::CHARGE_SPOT_ID,
                        'detail_charge_type_id' => $spot->spot_id,
                        'month_usage' => $this->_monthUsage,
                        'description' => $spot->name_jp,
                        'currency_id' => $spot->currency_id,
                        'money_billing' => $spot->amount_charge,
                        'money' => $spot->amount_charge * $this->_rateCurrency,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
                $totalMoneySpot += $spot->amount_charge;
            }

            if (count($arrListInsert) > 0) {
                DB::table('t_detail_history_usage')->insert($arrListInsert);
            }

            return $totalMoneySpot;
        } catch (Exception $ex) {
            $this->_log->err('Insert list to table t_detail_history_usage fail: ' . $ex->getMessage());
            $this->error('Insert list to table t_detail_history_usage fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * Get Charge Volume discount of service
     * @access private
     * @param int $serviceId Service ID
     * @param int $cLNumber CL number of service
     * @return null|float $chargeVolumeDiscount
     */
    private function _getChargeVolumeDiscount($serviceId, $cLNumber)
    {
        // Get list charge spot
        $listVolumeDiscount = $this->_getListVolumeDiscount($serviceId);
        if ($listVolumeDiscount === null) {
            return null;
        }

        // Get charge volume discount
        $chargeVolumeDiscount = 0;
        foreach ($listVolumeDiscount as $volumeDiscount) {
            if ($cLNumber >= $volumeDiscount->cl_number) {
                $chargeVolumeDiscount = $volumeDiscount->money_discount;
                break;
            }
        }

        return $chargeVolumeDiscount;
    }

    /**
     * Get list charge spot
     *
     * @access private
     * @param int $serviceId Service ID
     * @return null|object
     */
    private function _getListVolumeDiscount($serviceId)
    {
        try {
            return DB::table('t_volume_discount')
                ->select('service_id'
                    , 'money_discount'
                    , 'cl_number')
                ->where([
                    ['service_id', '=', $serviceId],
                    ['del_flag', '=', Constant::DELETE_FLAG_FALSE]])
                ->orderBy('cl_number', 'desc')
                ->get();

        } catch (Exception $ex) {
            $this->_log->err('Get list charge spot fail: ' . $ex->getMessage());
            $this->error('Get list charge spot fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * Insert price service into table t_detail_history_usage
     *
     * @access private
     * @param int $historyUsageId History usage ID
     * @param object $contract Information contract
     * @return null|int
     */
    private function _registerPriceService($historyUsageId, $contract)
    {
        try {
            // Add value insert
            $arrDataInsert = [
                'history_usage_id' => $historyUsageId,
                'charge_type_id' => Constant::CHARGE_SERVICE_ID,
                'detail_charge_type_id' => $contract->service_id,
                'month_usage' => $this->_monthUsage,
                'description' => $contract->name_short . '利用料',
                'currency_id' => $contract->currency_id,
                'money_billing' => $contract->price_service,
                'money' => $contract->price_service * $this->_rateCurrency,
                'created_at' => date('Y-m-d H:i:s')
            ];

            return DB::table('t_detail_history_usage')->insert($arrDataInsert);

        } catch (Exception $ex) {
            $this->_log->err('Insert price service into table t_detail_history_usage fail: ' . $ex->getMessage());
            $this->error('Insert price service into table t_detail_history_usage fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * Register money discount into table t_detail_history_usage
     *
     * @access private
     * @param int $historyUsageId History usage ID
     * @param object $contract object contract
     * @param float $moneyDiscount Money discount
     * @param int $discountId Detail charge type ID
     * @return null|int
     */
    private function _registerMoneyDiscount($historyUsageId, $contract, $moneyDiscount, $discountId)
    {
        try {
            if ($moneyDiscount != 0) {
                // Add value insert
                $arrDataInsert = [
                    'history_usage_id' => $historyUsageId,
                    'charge_type_id' => Constant::CHARGE_DISCOUNT_ID,
                    'detail_charge_type_id' => $discountId,
                    'month_usage' => $this->_monthUsage,
                    'description' => $contract->service_id,
                    'currency_id' => $contract->currency_id,
                    'money_billing' => -$moneyDiscount,
                    'money' => -$moneyDiscount * $this->_rateCurrency,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                return DB::table('t_detail_history_usage')->insert($arrDataInsert);
            }
            return 1;

        } catch (Exception $ex) {
            $this->_log->err('Register money discount into table t_detail_history_usage fail: ' . $ex->getMessage());
            $this->error('Register money discount into table t_detail_history_usage fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     *  Update total money of table t_history_usage
     *
     * @access private
     * @param int $historyUsageId History usage ID
     * @param float $totalMoneyBilling Total money billing
     * @return null|int
     */
    private function _updateTotalMoneyHistoryUsage($historyUsageId, $totalMoneyBilling)
    {
        try {
            return DB::table('t_history_usage')
                ->where('id', '=', $historyUsageId)
                ->update([
                    'total_amount_billing' => $totalMoneyBilling,
                    'total_money' => $totalMoneyBilling * $this->_rateCurrency
                ]);

        } catch (Exception $ex) {
            $this->_log->err('Update total money of table t_history_usage fail: ' . $ex->getMessage());
            $this->error('Update total money of table t_history_usage fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * Update status of expired contract
     *
     * @access private
     * @param array $listExpiredContract List array ID contract
     * @return null|int
     */
    private function _updateStatusOfExpiredContract($listExpiredContract)
    {
        try {
            if (count($listExpiredContract) > 0) {
                return DB::table('m_contract')
                    ->whereRaw('id IN (?)', [implode(', ', $listExpiredContract)])
                    ->update([
                        'status' => Constant::STATUS_CONTRACT_EXPIRED
                    ]);
            }

            return 1;
        } catch (Exception $ex) {
            $this->_log->err('Update status of expired contract fail: ' . $ex->getMessage());
            $this->error('Update status of expired contract fail: ' . $ex->getMessage());
            return null;
        }
    }
}
