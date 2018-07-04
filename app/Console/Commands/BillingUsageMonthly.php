<?php
/**
 * Batch calculate billing usage monthly of ship
 *
 * @package App\Console\Commands
 * @author quangpm
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

    private $_monthUsage = '';
    private $_now = '';

    // Constant
    const STATUS_ACTIVE       = 0;
    const STATUS_PENDING       = 1;
    const STATUS_EXPIRED       = 2;

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
     * @return mixed
     */
    public function handle ()
    {
        $isException = 0;

        // 2. Get list company active
        $listCompany = $this->_getListCompany();

        if ($listCompany != null && count($listCompany) > 0) {

            // Set month usage
            $now = date('Y-m-d');
            $now = strtotime(date('Y-m-d', strtotime($now)) . ' -1 month');
            $now = date('Y-m',$now);
            $this->_monthUsage = $now . '-1';

            // Set currency time
            $now = date('Y-m-d');
            $this->_now = $now . ' 00:00:00';

            // Loop and processing ever company
            foreach ($listCompany as $company) {
                $currencyId = $company->currency_id;
                $companyId = $company->id;

                // 3. Get discount common of company
                $discountCommon = $this->_getDiscountCommon($companyId, $currencyId);
                if ($discountCommon != null) {
                    $isException = 1;
                    break;
                }

                // 4. Get information of contract, charge service, total license, discount individual
                $listContract = $this->_getInforContract($companyId, $currencyId);
            }

            if ($isException = 1) {
//                 Log::error("Error Exception: " . $ex->getMessage());
                $this->error('\n Error Exception');
            }
        }
    }

    /**
     * 2. Get list company active
     *
     * @access private
     * @return object
     */
    private function _getListCompany()
    {
        try {
            return DB::table('m_company')
                    ->select('id', 'currency_id')
                    ->where('del_flag', '=', self::STATUS_ACTIVE)
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
     * @return object
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
                        ['del_flag', '=', self::STATUS_ACTIVE]])
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
     * @return object
     */
    private function _getInforContract($companyId, $currencyId)
    {
        try {
            return DB::raw('SELECT
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
                                            WHERE SCO.id = ?
                                                    AND SC.status = 0
                                                    AND (SC.approved_flag = 1 OR ((SC.approved_flag = 2 OR SC.approved_flag = 3) 
                                                                                  AND SC.updated_at IS NOT NULL))
                                            GROUP BY SC.service_id
                                            ) AS licenseTbl ON C.service_id = licenseTbl.service_id
                        LEFT JOIN t_discount_individual AS DI ON DI.contract_id = C.id
                           AND DI.setting_month = ?
                           AND DI.currency_id = ?
                           AND DI.del_flag = 0
                        WHERE CO.id = ?
                            AND C.status = 0 
                            AND (C.approved_flag = 1 OR ((C.approved_flag = 2 OR C.approved_flag = 3) AND C.updated_at IS NOT NULL))
                            AND C.start_date < ?
                        ORDER BY C.ship_id DESC
                                , C.service_id DESC'
                        , $companyId, $this->_monthUsage, $currencyId, $companyId, $this->_now)
                    ->get();

        } catch (Exception $ex) {
//            Log::error("Get information of contract, charge service, total license, discount individual fail: " . $ex->getMessage());
            $this->error('\n Get information of contract, charge service, total license, discount individual fail: ' . $ex->getMessage());
            return null;
        }
    }
}