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
        return DB::table('m_company AS C')

                ->select(DB::raw("'C.id,',
                                'C.name_jp,',
                                'C.name_jp,',
                                'C.payment_deadline_no,',
                                'C.ope_person_name_1,',
                                'C.ope_phone_1,',
                                'C.ope_email_1,',
                                'BM.name_jp,',
                                'BM.charge,',
                                'SUM(HU.total_money) AS total_money,',
                                'HB.id AS history_billing_id,',
                                'HB.approved_flag,',
                                'HB.updated_at,',
                                'HB.reason_reject,',
                                'CR.name_jp',
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
                        ->where('BM.currency_id', '=', 'C.currency_id')
                        ->where('BM.del_flag', '=', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_ship AS S', 'S.company_id', '=','C.id')
                ->join('m_currency AS CR', function($join) {
                    $join->on('CR.id', '=', 'C.currency_id')
                        ->where('CR.del_flag', '=', Constant::DELETE_FLAG_FALSE);
                })
                ->join('t_history_usage AS HU', 'HU.ship_id', '=','S.id')
                ->join('t_detail_history_usage AS DHU', 'DHU.history_usage_id', '=','HU.id')
                ->join('t_history_billing AS HB', function($join) {
                    $join->on('HB.company_id', '=', 'C.id')
                        ->where('HB.payment_actual_date', 'IS', NULL)
                        ->whereRaw('MONTH(HB.claim_date) = ?',[(integer)date('m)')])
                        ->whereRaw('YEAR(HB.claim_date) = ?', [(integer)date('Y)')]);
                })
                ->whereRaw("(? IS NULL OR C.name_jp = ?)", [$models['companyName'], $models['companyName']])
                ->whereRaw("(? = 0 "
                        . "OR (? = 1 AND HB.company_id IS NOT NULL) "
                        . "OR (? = 2 AND HB.delivered_flag = ?) "
                        . "OR (? = 3 AND HB.delivered_flag = ?))"
                        , [$models['status'], $models['status'], $models['status'], Constant::DELIVERY_FLAG_FALSE
                            , $models['status'], Constant::DELIVERY_FLAG_FALSE])
                ->whereRaw("(C.payment_deadline_no >= ? AND C.payment_deadline_no <= ?)"
                        , [$models['minMonth'], $models['maxMonth']])
//                ->toSQL();
                ->get();
    }
    
}
