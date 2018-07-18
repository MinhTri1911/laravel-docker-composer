<?php

/**
 * Billing Paper management Repository
 *
 * @package App\Repositories\Billing
 * @author Rikkei.quangpm
 * @date 2018/07/11
 */

namespace App\Repositories\Billing;

use App\Repositories\EloquentRepository;
use App\Models\THistoryBilling;
use Illuminate\Support\Facades\DB;
use App\Common\Constant;

class BillingPaperRepository extends EloquentRepository implements BillingPaperInterface
{
    /**
     * Set model billing for interface
     *
     * @return string \App\Models\THistoryBilling
     */
    public function getModel()
    {
        return THistoryBilling::class;
    }

    /**
     * Get list search billing
     * 
     * @param array $models condition search
     * @return null|object
     */
    public function getListSearchBilling($models)
    {
        $historyUsage = DB::raw('(SELECT DISTINCT SHU.id, SHU.ship_id, SHU.billed_flag, SHU.total_amount_billing, SHU.total_money
                                    FROM t_history_usage AS SHU
                                      INNER JOIN t_detail_history_usage AS SDHU ON SDHU.history_usage_id= SHU.id
                                  ) AS history_usage');

        return DB::table('m_company AS C')

                ->select(DB::raw("C.id AS company_id,
                                C.name_jp AS company_name,
                                C.payment_deadline_no,
                                C.ope_person_name_1,
                                C.ope_phone_1,
                                C.ope_email_1,
                                BM.name_jp AS method_name,
                                BM.charge,
                                HB.id AS history_billing_id,
                                HB.approved_flag,
                                HB.reason_reject,
                                CR.name_jp AS currency_name ,
                                CR.rate,
                                SUM(
                                    CASE 
                                        WHEN history_usage.billed_flag = 0 THEN history_usage.total_amount_billing
                                        WHEN history_usage.billed_flag = 1 OR HB.id IS NOT NULL THEN HB.total_amount_billing
                                    END
                                ) AS total_amount_billing,
                                SUM(
                                    CASE 
                                        WHEN history_usage.billed_flag = 0 THEN history_usage.total_money
                                        WHEN history_usage.billed_flag = 1 OR HB.id IS NOT NULL THEN HB.total_money
                                    END
                                ) AS total_money,
                                CASE 
                                    WHEN C.month_billing IS NULL OR C.month_billing = '' THEN BM.month_billing
                                    ELSE C.month_billing
                                END AS month_billing,
                                CASE 
                                    WHEN HB.id IS NULL OR HB.approved_flag = 3 THEN 1
                                    WHEN HB.delivered_flag = 0 THEN 2
                                    WHEN HB.delivered_flag = 1 THEN 3
                                END AS status"))
                ->join('m_billing_method AS BM', function($join) {
                    $join->on('BM.id', '=', 'C.billing_method_id')
                        ->on('BM.currency_id', '=', 'C.currency_id')
                        ->where('BM.del_flag', '=', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_ship AS S', 'S.company_id', '=','C.id')
                ->join('m_currency AS CR', function($join) {
                    $join->on('CR.id', '=', 'C.currency_id')
                        ->where('CR.del_flag', '=', Constant::DELETE_FLAG_FALSE);
                })
                ->join($historyUsage , function($join) {
                    $join->on('history_usage.ship_id', '=', 'S.id');
                    
                })
                ->leftJoin('t_history_billing AS HB', function($join) {
                    $join->on('HB.company_id', '=', 'C.id')
                        ->whereNull('HB.payment_actual_date')
                        ->whereraw('MONTH(HB.claim_date) = ?',[(integer)date('m)')])
                        ->whereraw('YEAR(HB.claim_date) = ?', [(integer)date('Y)')]);
                })
                ->whereRaw("(? IS NULL OR C.name_jp LIKE ?)", [$models['companyName'], '%' . $models['companyName'] . '%'])
                ->whereRaw("(? = 0 "
                        . "OR (? = 1 AND HB.company_id IS NULL) "
                        . "OR (? = 2 AND HB.delivered_flag = ? AND HB.approved_flag = ?) "
                        . "OR (? = 3 AND HB.delivered_flag = ?))"
                        , [$models['status'], $models['status'], $models['status'], Constant::DELIVERY_FLAG_FALSE
                            , Constant::STATUS_APPROVED, $models['status'], Constant::DELIVERY_FLAG_TRUE])
                ->whereRaw("(? = 0 OR HB.approved_flag = ?)", [$models['approve'], $models['approve']])
                ->whereRaw("(C.payment_deadline_no >= ? AND C.payment_deadline_no <= ?)"
                        , [$models['minMonth'], $models['maxMonth']])
                ->groupBy(['C.id', 'HB.id'])
                ->orderBy('C.id', 'ASC')
                ->paginate($models['numberRecord']);
    }
}
