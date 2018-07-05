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
use Log;
use DB;

class BillingUsageMonthly extends Command {

    // The name and signature of the console command.
    protected $signature        = 'batch:billingUsageMonthly';

    // The console command description.
    protected $description      = 'Calculate billing usage monthly of ship';

    private $_monthUsage   = '';
    private $_now          = '';
    private $_rateCurrency = 1;

    // Constant deleted flag
    const DELETED         = 1;
    const NO_DELETE       = 0;

    // Constant status
    const STATUS_ACTIVE    = 0;
    const STATUS_PENDING   = 1;
    const STATUS_EXPIRED   = 2;

    // Constant approve
    const APPROVED          = 1;
    const WAITING_APPROVE   = 2;
    const REJECT            = 3;

    // Constant ID Type Charge 
    const CHARGE_SERVICE    = 0;
    const CHARGE_SPOT       = 1;
    const CHARGE_DISCOUNT   = 2;

    // Constant ID Detail Type Charge 
    const DETAIL_CHARGE_VOLUME_DISCOUNT      = 0;
    const DETAIL_CHARGE_DISCOUNT_COMMON      = 1;
    const DETAIL_CHARGE_DISCOUNT_INDIVIDUAL  = 2;

    /**
     * Create a new command instance.
     *
     * @access public
     * @return void
     */
    public function __construct ()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @access public
     * @return void
     */
    public function handle ()
    {
        $isException = 0;

        $this->error('START');

        // 2. Get list company active
        $listCompany = $this->_getListCompany();

        if ($listCompany !== null && count($listCompany) > 0) {

            // Set month usage batch
            $now = date('Y-m-d');
            $now = strtotime(date('Y-m-d', strtotime($now)) . ' -1 month');
            $now = date('Y-m', $now);
            $this->_monthUsage = $now . '-01';

            // Set currency time
            $now = date('Y-m');
            $this->_now = $now . '-01 00:00:00';

            // Begin transaction
            DB::beginTransaction();

            // Loop and processing every company
            foreach ($listCompany as $company) {
                $currencyId = $company->currency_id;
                $companyId = $company->id;

                $this->_rateCurrency = $this->_getRateCurrency($currencyId);

                // 3. Get discount common of company
                $objectDiscountCommon = $this->_getDiscountCommon($companyId, $currencyId);
                if ($objectDiscountCommon === null) {
                    $isException = 1;
                    break;
                }

                // Set discount common
                if (count($objectDiscountCommon) > 0) {
                    $discountCommon = $objectDiscountCommon[0]->money_discount === null ? 0 : $objectDiscountCommon[0]->money_discount;
                } else {
                    $discountCommon = 0;
                }

                // 4. Get information of contract, charge service, total license, discount individual
                $listContract = $this->_getInforContract($companyId, $currencyId);

                // Set variable ID Ship for Process loop ship
                $shipIdTempl = -1;

                // List ID expired Contract
                $listExpiredContract = [];

                // Total money billing
                $totalMoneyBilling = 0;

                // Loop list contract
                $i = 0;
                while ($i < count($listContract)) {
                    $contract = $listContract[$i];
                    $shipId = $contract->ship_id;
                    $serviceId = $contract->service_id;
                    $discountIndividual = $contract->discount_individual === null ? 0 : $contract->discount_individual;
                    $cLNumber = $contract->license_count;

                    // 5. Case: First record of every Ship
                    if ($shipIdTempl != $shipId) {
                        $shipIdTempl = $shipId;
                        $totalMoneyBilling = 0;

                        // Process for loop ship: First record of every Ship
                        $historyUsageId = $this->_processLoopShip($shipId, $currencyId, $totalMoneyBilling);
                        if ($historyUsageId === null) {
 
                            $isException = 1;
                            break;
                        }
                    }

                    // 6. Get Charge Volume discount of service
                    $volumeDiscount = $this->_getChargeVolumeDiscount($serviceId, $cLNumber);
                    if ($volumeDiscount === null) {
                        $isException = 1;
                        break;
                    }

                    // 7. Calculate discount of service
                    $moneyDiscount = 0;
                    $discountId = 0;
                    if ($volumeDiscount >= $discountCommon) {
                        $moneyDiscount = $volumeDiscount;
                        $discountId = self::DETAIL_CHARGE_VOLUME_DISCOUNT;
                        if ($discountIndividual > $volumeDiscount) {
                            $moneyDiscount = $discountIndividual;
                            $discountId = self::DETAIL_CHARGE_DISCOUNT_INDIVIDUAL;
                        }
                    } else {
                        $moneyDiscount = $discountCommon;
                        $discountId = self::DETAIL_CHARGE_DISCOUNT_COMMON;
                        if ($discountIndividual > $discountCommon) {
                            $moneyDiscount = $discountIndividual;
                            $discountId = self::DETAIL_CHARGE_DISCOUNT_INDIVIDUAL;
                        }
                    }

                    // 8. Insert price service into table t_detail_history_usage
                    $result = $this->_registerPriceService($historyUsageId, $contract);
                    $totalMoneyBilling += $contract->price_service;
                    if ($result === null) {
                        $isException = 1;
                        break;
                    }

                    // 9. Register money discount into table t_detail_history_usage
                    $totalMoneyBilling -= $moneyDiscount;
                    $result = $this->_registerMoneyDiscount($historyUsageId, $contract, $moneyDiscount, $discountId);
                    if ($result === null) {
                        $isException = 1;
                        break;
                    }

                    // 10. Get list ID of contract expired
                    $now = date('Y-m-d',strtotime($this->_now));
                    if ($contract->end_date < $now) {
                        $listExpiredContract[] = $contract->id;
                    }

                    // Check is last record or last record of ship
                    if ($i == count($listContract) - 1 || $shipIdTempl != $listContract[$i + 1]->ship_id) {

                        // 11. Update total money of table t_history_usage
                        $result = $this->_updateTotalMoneyHistoryUsage($historyUsageId, $totalMoneyBilling);
                        if ($result === null) {
                            $isException = 1;
                            break;
                        }
                    }

                    $i++;
                }

                // 12. Update status of expired contract
                $result = $this->_updateStatusOfExpiredContract($listExpiredContract);
                if ($result === null) {
                    $isException = 1;
                    break;
                }

                if ($isException == 1) {
                    break;
                }
            }

            // Check exist exception
            if ($isException == 1) {
                // Rollback transaction
                DB::rollBack();

//                 Log::error("Error Exception "));
                $this->error('\n Error Exception');
            } else {
                // Commit transaction
                DB::commit();
            }
        }
        $this->error('\n END');
    }

    /**
     * 2. Get list company active
     *
     * @access private
     * @return null|object
     */
    private function _getListCompany()
    {
        try {
            return DB::table('m_company')
                    ->select('id', 'currency_id')
                    ->where('del_flag', '=', self::NO_DELETE)
                    ->get();

        } catch (Exception $ex) {
//            Log::error("Get list company fail: " . $ex->getMessage());
            $this->error('\n Get list company fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * 3. Get discount common of company
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
                        ['del_flag', '=', self::NO_DELETE]])
                    ->get();

        } catch (Exception $ex) {
//            Log::error("Get discount common of company fail: " . $ex->getMessage());
            $this->error('\n Get discount common of company fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * 4. Get information of contract, charge service, total license, discount individual
     *
     * @access private
     * @param int $companyId Company ID
     * @param int $currencyId Currency ID
     * @return null|object
     */
    private function _getInforContract($companyId, $currencyId)
    {
        try {
            $date = strtotime($this->_monthUsage);
            $month = (integer)date('m', $date);
            $year = (integer)date('Y', $date);

            return DB::select("SELECT DISTINCT
                                CO.currency_id
                                , C.id
                                , C.ship_id
                                , C.service_id
                                , C.start_date
                                , C.end_date
                                , licenseTbl.license_count
                                , S.name_short
                                , DI.money_discount AS discount_individual
                                , PS.price AS price_service
                            FROM m_contract AS C
                            INNER JOIN m_ship AS SH ON SH.id = C.ship_id AND SH.del_flag = 0
                            INNER JOIN m_company AS CO ON CO.id = SH.company_id AND CO.del_flag = 0
                            INNER JOIN m_service AS S ON S.id = C.service_id AND S.del_flag = 0
                            INNER JOIN t_price_service AS PS ON PS.service_id = C.service_id
                               AND PS.currency_id = C.currency_id AND PS.del_flag = 0
                            INNER JOIN m_currency AS CR ON CR.id = PS.currency_id AND CR.del_flag = 0
                            INNER JOIN (SELECT SC.service_id
                                            , COUNT(SC.service_id) AS license_count
                                            FROM m_contract AS SC
                                            INNER JOIN m_ship AS SSH ON SSH.id = SC.ship_id AND SSH.del_flag = 0
                                            INNER JOIN m_company AS SCO ON SCO.id = SSH.company_id AND SCO.del_flag = 0
                                            WHERE SCO.id = $companyId
                                                    AND SC.status = 0
                                                    AND (SC.approved_flag = 1 OR ((SC.approved_flag = 2 OR SC.approved_flag = 3) 
                                                                                  AND SC.updated_at IS NOT NULL))
                                                    OR (MONTH(SC.end_date) = $month AND YEAR(SC.end_date) = $year)
                                            GROUP BY SC.service_id
                                            ) AS licenseTbl ON C.service_id = licenseTbl.service_id
                        LEFT JOIN t_discount_individual AS DI ON DI.contract_id = C.id
                           AND DI.setting_month = '$this->_monthUsage'
                           AND DI.currency_id = $currencyId
                           AND DI.del_flag = 0
                        WHERE CO.id = $companyId
                            AND C.status = 0 
                            AND (C.approved_flag = 1 OR ((C.approved_flag = 2 OR C.approved_flag = 3) AND C.updated_at IS NOT NULL))
                            AND C.start_date < '$this->_now'
                            OR (MONTH(C.end_date) = $month AND YEAR(C.end_date) = $year)
                        ORDER BY C.ship_id DESC
                                ,C.service_id DESC");

        } catch (Exception $ex) {
//            Log::error("Get information of contract, charge service, total license, discount individual fail: " . $ex->getMessage());
            $this->error('\n Get information of contract, charge service, total license, discount individual fail: ' . $ex->getMessage());
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

        // 5.1. Insert table t_history_usage
        $historyUsageId = $this->_insertHistoryUsage($shipId, $currencyId);
        if ($historyUsageId === null) {
            return null;
        }

        // 5.2 Get list charge SPOT
        $listChargeSpot = $this->_getlistChargeSpot($shipId, $currencyId);
        if ($listChargeSpot === null) {
            return null;
        }

        // 5.3. Insert list to table t_ship_spot
        $totalMoneySpot = $this->_insertListChargeSpot($historyUsageId, $listChargeSpot);
        $totalMoneyBilling += $totalMoneySpot;
        if ($totalMoneySpot === null) {
            return null;
        }

         return $historyUsageId;
    }

    /**
     * 5.1. Insert table t_history_usage
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
                'ship_id'            => $shipId,
                'month_usage'        => $this->_monthUsage,
                'currency_id'        => $currencyId,
            ];

            return DB::table('t_history_usage')->insertGetId($arrDataInsert);

        } catch (Exception $ex) {
//            Log::error("Insert table t_history_usage fail: " . $ex->getMessage());
            $this->error('\n Insert table t_history_usage fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * 5.2. Get list charge spot
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
                            ,'SP.spot_id'
                            ,'SP.currency_id'
                            ,'SP.amount_charge'
                            ,'SP.remark'
                            ,'S.name_jp')
                    ->join('m_spot AS S', function($join){
                      $join->on('S.id', '=', 'SP.spot_id')
                            ->where('S.del_flag', '=', self::NO_DELETE);
                    })
                    ->where([['SP.ship_id', '=', $shipId],
                            ['SP.currency_id', '=', $currencyId],
                            ['SP.month_usage', '=', $this->_monthUsage],
                            ['SP.del_flag', '=', self::NO_DELETE]])
                    ->whereRaw("(SP.approved_flag = ? OR ((SP.approved_flag = ? OR SP.approved_flag = ?) AND SP.updated_at IS NOT NULL))"
                                , [self::APPROVED, self::WAITING_APPROVE, self::REJECT])
                    ->get();

        } catch (Exception $ex) {
//            Log::error("Get list charge spot fail: " . $ex->getMessage());
            $this->error('\n Get list charge spot fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * 5.3. Insert list to table t_detail_history_usage
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
            if (count($listChargeSpot) > 0) {
                $arrListInsert = [];

                foreach ($listChargeSpot as $spot) {
                    // Add value insert
                    $arrListInsert[] = [
                        'history_usage_id'       => $historyUsageId,
                        'charge_type_id'         => self::CHARGE_SPOT,
                        'detail_charge_type_id'  => $spot->spot_id,
                        'month_usage'            => $this->_monthUsage,
                        'description'            => $spot->name_jp,
                        'currency_id'            => $spot->currency_id,
                        'money_billing'          => $spot->amount_charge,
                        'money'                  => $spot->amount_charge * $this->_rateCurrency
                    ];
                    $totalMoneySpot += $spot->amount_charge;
                }
                DB::table('t_detail_history_usage')->insert($arrListInsert);
            }

            return $totalMoneySpot;
        } catch (Exception $ex) {
//            Log::error("Insert list to table t_detail_history_usage fail: " . $ex->getMessage());
            $this->error('\n Insert list to table t_detail_history_usage fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * Get rate of currency
     *
     * @access private
     * @param int $currencyId Currency ID
     * @return null|float
     */
    private function _getRateCurrency($currencyId)
    {
        try {
            $currency = DB::table('m_currency')
                        ->select('id', 'rate')
                        ->where([
                            ['id', '=', $currencyId],
                            ['del_flag', '=', self::NO_DELETE]])
                        ->get();

            if (count($currency) > 0) {
                 return $currency[0]->rate;
            }

            return 1;
        } catch (Exception $ex) {
//            Log::error("Get rate of currency fail: " . $ex->getMessage());
            $this->error('\n Get rate of currency fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * 6. Get Charge Volume discount of service
     * @access private
     * @param int $serviceId Service ID
     * @param int $cLNumber CL number of service
     * @return null|float $chargeVolumeDiscount
     */
    private function _getChargeVolumeDiscount($serviceId, $cLNumber)
    {
        // 6.1. Get list charge spot
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
     * 6.1. Get list charge spot
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
                            ,'money_discount'
                            ,'cl_number')
                    ->where([
                        ['service_id', '=', $serviceId],
                        ['del_flag', '=', self::NO_DELETE]])
                    ->orderBy('cl_number', 'desc')
                    ->get();

        } catch (Exception $ex) {
//            Log::error("Get list charge spot fail: " . $ex->getMessage());
            $this->error('\n Get list charge spot fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * 8. Insert price service into table t_detail_history_usage
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
                'history_usage_id'      => $historyUsageId,
                'charge_type_id'        => self::CHARGE_SERVICE,
                'detail_charge_type_id' => $contract->service_id,
                'month_usage'           => $this->_monthUsage,
                'description'           => $contract->name_short . '利用料',
                'currency_id'           => $contract->currency_id,
                'money_billing'         => $contract->price_service,
                'money'                 => $contract->price_service * $this->_rateCurrency
                ];

            return DB::table('t_detail_history_usage')->insert($arrDataInsert);

        } catch (Exception $ex) {
//            Log::error("Insert price service into table t_detail_history_usage fail: " . $ex->getMessage());
            $this->error('\n Insert price service into table t_detail_history_usage fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * 9. Register money discount into table t_detail_history_usage
     * 
     * @access private
     * @param type $historyUsageId History usage ID
     * @param type $contract object contract
     * @param type $moneyDiscount Money discount
     * @param type $discountId Detail charge type ID
     * @return null|int
     */
    private function _registerMoneyDiscount($historyUsageId, $contract, $moneyDiscount, $discountId)
    {
        try {
            // Add value insert
            $arrDataInsert = [
                'history_usage_id'      => $historyUsageId,
                'charge_type_id'        => self::CHARGE_DISCOUNT,
                'detail_charge_type_id' => $discountId,
                'month_usage'           => $this->_monthUsage,
                'description'           => $contract->service_id,
                'currency_id'           => $contract->currency_id,
                'money_billing'         => -$moneyDiscount,
                'money'                 => -$moneyDiscount * $this->_rateCurrency
                ];

            return DB::table('t_detail_history_usage')->insert($arrDataInsert);

        } catch (Exception $ex) {
//            Log::error("Register money discount into table t_detail_history_usage fail: " . $ex->getMessage());
            $this->error('\n Register money discount into table t_detail_history_usage fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     *  11. Update total money of table t_history_usage
     * 
     * @access private
     * @param type $historyUsageId History usage ID
     * @param type $totalMoneyBilling Total money billing
     * @return null|int
     */
    private function _updateTotalMoneyHistoryUsage($historyUsageId, $totalMoneyBilling)
    {
         try {
           return DB::table('t_history_usage')
                ->where('id', '=', $historyUsageId)
                ->update([
                    'total_amount_billing'   => $totalMoneyBilling,
                    'total_money'           => $totalMoneyBilling * $this->_rateCurrency
                    ]);

        } catch (Exception $ex) {
//            Log::error("Update total money of table t_history_usage fail: " . $ex->getMessage());
            $this->error('\n Update total money of table t_history_usage fail: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * 12. Update status of expired contract
     * 
     * @access private
     * @param array $listExpiredContract List array ID contract
     * @return null|int
     */
    private function  _updateStatusOfExpiredContract($listExpiredContract)
    {
         try {
            if (count($listExpiredContract) > 0) {
                return DB::table('m_contract')
                    ->whereRaw('id IN (?)', [implode(", ",$listExpiredContract)])
                    ->update([
                        'status'   => self::STATUS_EXPIRED
                        ]);
            }

            return 1;
        } catch (Exception $ex) {
//            Log::error("Update status of expired contract fail: " . $ex->getMessage());
            $this->error('\n Update status of expired contract fail: ' . $ex->getMessage());
            return null;
        }
    }
}
