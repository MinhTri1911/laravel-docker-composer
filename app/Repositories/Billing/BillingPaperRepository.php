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
        // Select history usage billing
        $historyUsage = DB::raw('(SELECT DISTINCT SHU.id, SHU.ship_id, SHU.billed_flag, SHU.total_amount_billing, SHU.total_money
                                  FROM t_history_usage AS SHU
                                      INNER JOIN t_detail_history_usage AS SDHU ON SDHU.history_usage_id= SHU.id
                                  ) AS history_usage');

        // Select history billed
        $historyBilling = DB::raw("(SELECT SHB.company_id, SHB.id AS history_billing_id, SHB.reason_reject, SHB.approved_flag, SHB.payment_deadline_no,
                                        SBM.name_jp AS method_name_jp, SBM.charge AS charge_delivery, SCR.rate, SHB.delivered_flag,
                                        SHB.payment_due_date, SHB.total_amount_billing, SHB.total_money
                                    FROM t_history_billing AS SHB
                                      INNER JOIN m_billing_method AS SBM ON SBM.id = SHB.billing_method_id 
                                          AND SBM.currency_id = SHB.currency_id 
                                          AND SBM.del_flag = " . Constant::DELETE_FLAG_FALSE 
                                  . " INNER JOIN m_currency AS SCR ON SCR.id = SHB.currency_id 
                                          AND SCR.del_flag = " . Constant::DELETE_FLAG_FALSE 
                                . " WHERE SHB.payment_actual_date IS NULL
                                      AND (SHB.delivered_flag =  " . Constant::DELIVERY_FLAG_FALSE 
                                      . " OR (SHB.delivered_flag  = " . Constant::DELIVERY_FLAG_TRUE 
                                         . " AND month(SHB.claim_date) = " . (integer)date('m') 
                                        . " AND year(SHB.claim_date) = " . (integer)date('Y') ."))
                                    ) AS HB");

        return DB::table('m_company AS C')
            ->select(DB::raw("C.id AS company_id,
                                C.name_jp AS company_name,
                                C.ope_person_name_1,
                                C.ope_phone_1,
                                C.ope_email_1,
                                HB.history_billing_id,
                                HB.approved_flag,
                                HB.reason_reject,
                                CASE 
                                    WHEN HB.history_billing_id IS NULL OR HB.approved_flag = 3 THEN CR.rate
                                    ELSE HB.rate
                                END AS rate,
                                MAX(history_usage.billed_flag) AS billed_flag,
                                CASE 
                                    WHEN HB.history_billing_id IS NULL OR HB.approved_flag = 3 THEN C.payment_deadline_no
                                    ELSE HB.payment_deadline_no
                                END AS payment_deadline_no,
                                CASE 
                                    WHEN HB.history_billing_id IS NULL OR HB.approved_flag = 3 THEN BM.name_jp
                                    ELSE HB.method_name_jp
                                END AS method_name,
                                CASE 
                                    WHEN HB.history_billing_id IS NULL OR HB.approved_flag = 3 THEN BM.charge
                                    ELSE HB.charge_delivery
                                END AS charge_delivery,
                                SUM(
                                    CASE 
                                        WHEN history_usage.billed_flag = 0 THEN history_usage.total_amount_billing
                                        WHEN history_usage.billed_flag = 1 THEN HB.total_amount_billing
                                    END
                                ) AS total_amount_billing,
                                SUM(
                                    CASE 
                                        WHEN history_usage.billed_flag = 0 THEN history_usage.total_money
                                        WHEN history_usage.billed_flag = 1 THEN HB.total_money
                                    END
                                ) AS total_money,
                                CASE 
                                    WHEN C.month_billing IS NULL OR C.month_billing = '' THEN BM.month_billing
                                    ELSE C.month_billing
                                END AS month_billing,
                                CASE 
                                    WHEN HB.history_billing_id IS NULL OR HB.approved_flag = 3 THEN 1
                                    WHEN HB.delivered_flag = 0 THEN 2
                                    WHEN HB.delivered_flag = 1 THEN 3
                                END AS status"))
            ->join('m_billing_method AS BM', function ($join) {
                $join->on('BM.id', '=', 'C.billing_method_id')
                    ->on('BM.currency_id', '=', 'C.currency_id')
                    ->where('BM.del_flag', '=', Constant::DELETE_FLAG_FALSE);
            })
            ->join('m_ship AS S', 'S.company_id', '=', 'C.id')
            ->join('m_currency AS CR', function ($join) {
                $join->on('CR.id', '=', 'C.currency_id')
                    ->where('CR.del_flag', '=', Constant::DELETE_FLAG_FALSE);
            })
            ->join($historyUsage, function ($join) {
                $join->on('history_usage.ship_id', '=', 'S.id');
            })
             ->leftJoin($historyBilling, function ($join) {
                $join->on('HB.company_id', '=', 'C.id');
            })
            ->whereRaw("(? IS NULL OR C.name_jp LIKE ?)", [$models['companyName'], '%' . $models['companyName'] . '%'])
            ->whereRaw("(? = 0 OR HB.approved_flag = ?)", [$models['approve'], $models['approve']])
            ->where(function ($query) use ($models) {
                $query->whereRaw('(? = 0 AND C.payment_deadline_no >= ? AND C.payment_deadline_no <= ?)'
                    , [$models['status'], $models['minMonth'], $models['maxMonth']])
                    ->orWhereRaw('(? = 1 AND HB.company_id IS NULL AND C.payment_deadline_no >= ? AND C.payment_deadline_no <= ?)'
                        , [$models['status'], $models['minMonth'], $models['maxMonth']])
                    ->orWhereRaw('(? = 2 AND HB.delivered_flag = 0 AND HB.approved_flag = ? AND HB.payment_due_date >= ? AND HB.payment_due_date <= ?)'
                        , [$models['status'], Constant::STATUS_APPROVED, $models['beginDate'], $models['endDate']])
                    ->orWhereRaw('(? = 3 AND HB.delivered_flag = 1 AND HB.approved_flag = ? AND HB.payment_due_date >= ? AND HB.payment_due_date <= ?)'
                        , [$models['status'], Constant::STATUS_APPROVED, $models['beginDate'], $models['endDate']]);
            })
            ->groupBy(['C.id', 'HB.history_billing_id'])
            ->orderBy('C.id', 'ASC')
            ->paginate($models['numberRecord']);
    }

    /**
     * Get information billing paper by company Id
     *
     * @access public
     * @param int $companyId Company Id
     * @return mixed Illuminate\Support\Collection
     */
    public function getBillingPaperByCompanyId($companyId)
    {
        $historyUsage = DB::raw('(SELECT DISTINCT SHU.id, SHU.ship_id, SHU.billed_flag, SHU.total_amount_billing, SHU.total_money
                                  FROM t_history_usage AS SHU
                                      INNER JOIN t_detail_history_usage AS SDHU ON SDHU.history_usage_id= SHU.id
                                  WHERE SHU.billed_flag = 0
                                  ) AS history_usage');

        return DB::table('m_company AS C')
            ->select(DB::raw("C.id AS company_id,
                                C.name_jp AS company_name,
                                C.payment_deadline_no,
                                C.ope_company_id,
                                C.billing_day_no,
                                C.billing_method_id,
                                C.currency_id,
                                BM.charge AS charge_delivery,
                                BM.method,
                                HB.id AS history_billing_id,
                                HB.approved_flag,
                                CR.rate,
                                MAX(history_usage.billed_flag) AS billed_flag,
                                SUM(history_usage.total_amount_billing) AS total_amount_billing,
                                SUM(history_usage.total_money) AS total_money,
                                '' AS status,
                                CASE 
                                    WHEN C.month_billing IS NULL OR C.month_billing = '' THEN BM.month_billing
                                    ELSE C.month_billing
                                END AS month_billing"))
            ->join('m_billing_method AS BM', function ($join) {
                $join->on('BM.id', '=', 'C.billing_method_id')
                    ->on('BM.currency_id', '=', 'C.currency_id')
                    ->where('BM.del_flag', '=', Constant::DELETE_FLAG_FALSE);
            })
            ->join('m_ship AS S', 'S.company_id', '=', 'C.id')
            ->join('m_currency AS CR', function ($join) {
                $join->on('CR.id', '=', 'C.currency_id')
                    ->where('CR.del_flag', '=', Constant::DELETE_FLAG_FALSE);
            })
            ->join($historyUsage, function ($join) {
                $join->on('history_usage.ship_id', '=', 'S.id');

            })
            ->leftJoin('t_history_billing AS HB', function ($join) {
                $join->on('HB.company_id', '=', 'C.id')
                    ->whereNull('HB.payment_actual_date')
                    ->whereraw('MONTH(HB.claim_date) = ?', [(integer)date('m)')])
                    ->whereraw('YEAR(HB.claim_date) = ?', [(integer)date('Y)')]);
            })
            ->where("C.id", '=', $companyId)
            ->where("history_usage.billed_flag", '=', Constant::BILLED_FLAG_FALSE)
            ->whereRaw("(HB.id IS NULL OR HB.approved_flag = ?)", [Constant::STATUS_REJECT_APPROVE])
            ->groupBy(['C.id', 'HB.id'])
            ->get();
    }

    /**
     * Get list history usage no create billing by company id
     *
     * @access public
     * @param int $companyId Company Id
     * @return mixed Illuminate\Support\Collection
     */
    public function getListHistoryUsageByCompanyId($companyId)
    {
        return DB::table('m_company AS C')
            ->select(DB::raw("C.id AS company_id,
                                C.name_jp AS company_name,
                                C.payment_deadline_no,
                                C.ope_company_id,
                                C.billing_day_no,
                                C.billing_method_id,
                                C.currency_id,
                                BM.charge AS charge_delivery,
                                BM.method,
                                CR.rate,
                                HU.billed_flag,
                                HU.id AS history_usage_id,
                                DHU.id AS detail_history_usage_id,
                                SUM(HU.total_amount_billing) AS total_amount_billing,
                                SUM(HU.total_money) AS total_money,
                                CASE 
                                    WHEN C.month_billing IS NULL OR C.month_billing = '' THEN BM.month_billing
                                    ELSE C.month_billing
                                END AS month_billing"))
            ->join('m_currency AS CR', function ($join) {
                $join->on('CR.id', '=', 'C.currency_id')
                    ->where('CR.del_flag', '=', Constant::DELETE_FLAG_FALSE);
            })
            ->join('m_billing_method AS BM', function ($join) {
                $join->on('BM.id', '=', 'C.billing_method_id')
                    ->on('BM.currency_id', '=', 'C.currency_id')
                    ->where('BM.del_flag', '=', Constant::DELETE_FLAG_FALSE);
            })
            ->join('m_ship AS S', 'S.company_id', '=', 'C.id')
            ->join('t_history_usage AS HU', function ($join) {
                $join->on('HU.ship_id', '=', 'S.id');
            })
            ->join('t_detail_history_usage AS DHU', function ($join) {
                $join->on('DHU.history_usage_id', '=', 'HU.id');
            })
            ->where("C.id", '=', $companyId)
            ->where("HU.billed_flag", '=', Constant::BILLED_FLAG_FALSE)
            ->get();
    }

    /**
     * Create database create billing paper
     *
     * @access public
     * @param object $billingPaper Billing object
     * @return mixed Illuminate\Support\Collection
     */
    public function insertHistoryBilling($billingPaper)
    {
        $arrInsert = [
            'company_id' => $billingPaper->company_id,
            'claim_date' => date('Y-m-d'),
            'currency_id' => $billingPaper->currency_id,
            'billing_method_id' => $billingPaper->billing_method_id,
            'payment_deadline_no' => $billingPaper->payment_deadline_no,
            'payment_due_date' => $billingPaper->payment_due_date,
            'billing_day_no' => $billingPaper->billing_day_no,
            'ope_company_id' => $billingPaper->ope_company_id,
            'remark' => $billingPaper->remark,
            'pdf_original_link' => $billingPaper->url_pdf,
            'total_money' => $billingPaper->total_money,
            'total_amount_billing' => $billingPaper->total_amount_billing,
            'reason_reject' => "{ 'history_usage_id' : '" . $billingPaper->history_usage_id . "' }",
            'approved_flag' => Constant::STATUS_WAITING_APPROVE,
            'created_by' => $billingPaper->user_login_id,
            'created_at' => date('Y-m-d H:i:s')
        ];

        return DB::table('t_history_billing')->insert($arrInsert);
    }

    /**
     * Update database create billing paper
     *
     * @access public
     * @param object $billingPaper Billing object
     * @return mixed Illuminate\Support\Collection
     */
    public function updateHistoryBilling($billingPaper)
    {
        $arrUpdate = [
            'company_id' => $billingPaper->company_id,
            'claim_date' => date('Y-m-d'),
            'currency_id' => $billingPaper->currency_id,
            'billing_method_id' => $billingPaper->billing_method_id,
            'payment_deadline_no' => $billingPaper->payment_deadline_no,
            'payment_due_date' => $billingPaper->payment_due_date,
            'billing_day_no' => $billingPaper->billing_day_no,
            'ope_company_id' => $billingPaper->ope_company_id,
            'remark' => $billingPaper->remark,
            'pdf_original_link' => $billingPaper->url_pdf,
            'total_money' => $billingPaper->total_money,
            'total_amount_billing' => $billingPaper->total_amount_billing,
            'reason_reject' => "{ 'history_usage_id' : '" . $billingPaper->history_usage_id . "' }",
            'approved_flag' => Constant::STATUS_WAITING_APPROVE,
            'updated_by' => $billingPaper->user_login_id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return DB::table('t_history_billing')
            ->where('id', '=', $billingPaper->history_billing_id)
            ->update($arrUpdate);

    }

    /**
     * Get billing paper delivery by company id
     *
     * @access public
     * @param int $companyId Company Id
     * @return mixed Illuminate\Support\Collection
     */
    public function getBillingPaperDeliveryByCompanyId($companyId)
    {
        return DB::table('m_company AS C')
            ->select(DB::raw("C.id AS company_id,
                                C.name_jp AS company_name,
                                C.ope_person_name_1,
                                C.ope_phone_1,
                                C.ope_email_1,
                                HB.ope_company_id,
                                HB.billing_method_id,
                                HB.currency_id,
                                BM.name_jp,
                                BM.method,
                                CR.rate,
                                HB.id AS history_billing_id,
                                HB.delivered_flag,
                                HB.pdf_original_link,
                                CR.name_jp AS currency_name"))
            ->join('t_history_billing AS HB', 'HB.company_id', '=', 'C.id')
            ->join('m_currency AS CR', function ($join) {
                $join->on('CR.id', '=', 'HB.currency_id')
                    ->where('CR.del_flag', '=', Constant::DELETE_FLAG_FALSE);
            })
            ->join('m_billing_method AS BM', function ($join) {
                $join->on('BM.id', '=', 'HB.billing_method_id')
                    ->on('BM.currency_id', '=', 'HB.currency_id')
                    ->where('BM.del_flag', '=', Constant::DELETE_FLAG_FALSE);
            })
            ->where("C.id", '=', $companyId)
            ->where("HB.approved_flag", '=', Constant::STATUS_APPROVED)
            ->whereRaw("(HB.delivered_flag = ? OR (HB.delivered_flag  = ? AND month(HB.claim_date) = ? AND year(HB.claim_date) = ?))",
                [Constant::DELIVERY_FLAG_FALSE, Constant::DELIVERY_FLAG_TRUE, (integer)date('m'), (integer)date('Y')])
            ->get();
    }

    /**
     * Update Flag delivered
     *
     * @access public
     * @param object $billingPaper object History billing
     * @return mixed Illuminate\Support\Collection
     */
    public function updateFlagDelivered($billingPaper)
    {
        $arrUpdate = [
            'delivered_flag' => Constant::DELIVERY_FLAG_TRUE,
            'updated_by' => $billingPaper->user_login_id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return DB::table('t_history_billing')
            ->where('id', '=', $billingPaper->history_billing_id)
            ->update($arrUpdate);

    }
}
