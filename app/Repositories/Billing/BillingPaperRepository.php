<?php

/**
 * Billing Paper management Repository
 *
 * @package App\Repositories\Billing
 * @author Rikkei.Quangpm
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

        $billingCreate =  DB::table('m_company AS C')
            ->select(DB::raw("C.id AS company_id,
                                C.name_jp AS company_name,
                                C.ope_person_name_1,
                                C.ope_phone_1,
                                C.ope_email_1,
                                C.payment_deadline_no,
                                MAX(history_usage.billed_flag) AS billed_flag,
                                HB.approved_flag,
                                HB.reason_reject,
                                HB.payment_due_date,
                                HB.id AS history_billing_id,
                                CR.rate,
                                BM.name_jp AS method_name,
                                BM.charge AS charge_delivery,
                                SUM(history_usage.total_amount_billing) AS total_amount_billing,
                                SUM(history_usage.total_money) AS total_money,
                                1 AS status"))
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
                    ->whereRaw('YEAR(HB.claim_date) = ? AND MONTH(HB.claim_date) = ?'
                            , [(integer)date('Y'), (integer)date('m')])
                    ->where(function ($query) {
                        $query->where('HB.approved_flag', '=', Constant::STATUS_WAITING_APPROVE)
                            ->orWhere('HB.approved_flag', '=', Constant::STATUS_REJECT_APPROVE);
                    });
            })
            ->whereRaw("(? IS NULL OR C.name_jp LIKE ?)", [$models['companyName'], '%' . $models['companyName'] . '%'])
            ->where('history_usage.billed_flag', '=', Constant::BILLED_FLAG_FALSE)
            ->whereRaw("(? = 0 OR HB.approved_flag = ?)", [$models['approve'], $models['approve']])
            ->where(function ($query) use ($models) {
                $query->whereRaw('? = 0', [$models['approve']])
                    ->orWhereRaw('(? = 2 AND HB.approved_flag = ?)', [$models['approve'], Constant::STATUS_WAITING_APPROVE])
                    ->orWhereRaw('(? = 3 AND HB.approved_flag = ?)', [$models['approve'], Constant::STATUS_REJECT_APPROVE]);
            })
            ->where(function ($query) use ($models) {
                $query->whereRaw('? = 0', [$models['status']])
                    ->orWhereRaw('(? = 1 AND (HB.company_id IS NULL OR HB.approved_flag = ?))', [$models['status'], Constant::STATUS_REJECT_APPROVE]);
            })
            ->whereRaw("(C.payment_deadline_no >= ? AND C.payment_deadline_no <= ?)",
                    [$models['minMonth'], $models['maxMonth']])
            ->whereRaw("(CASE 
                            WHEN C.month_billing IS NULL OR C.month_billing = '' THEN BM.month_billing 
                            ELSE C.month_billing
                        END LIKE ?)", [ "%" . date('m') . "%"])
            ->groupBy(['C.id', 'HB.id']);

        $billingApproved =  DB::table('m_company AS C')
            ->select(DB::raw("C.id AS company_id,
                                C.name_jp AS company_name,
                                C.ope_person_name_1,
                                C.ope_phone_1,
                                C.ope_email_1,
                                C.payment_deadline_no,
                                history_usage.billed_flag,
                                HB.approved_flag,
                                HB.reason_reject,
                                HB.payment_due_date,
                                HB.id AS history_billing_id,
                                CR.rate,
                                BM.name_jp AS method_name,
                                BM.charge AS charge_delivery,
                                HB.total_amount_billing AS total_amount_billing,
                                HB.total_money AS total_money,
                                CASE 
                                    WHEN HB.delivered_flag = 0 THEN 2
                                    WHEN HB.delivered_flag = 1 THEN 3
                                END AS status"))
            ->join('m_ship AS S', 'S.company_id', '=', 'C.id')
            ->join($historyUsage, function ($join) {
                $join->on('history_usage.ship_id', '=', 'S.id');
            })
             ->join('t_history_billing AS HB', function ($join) {
                $join->on('HB.company_id', '=', 'C.id');
            })
            ->join('m_billing_method AS BM', function ($join) {
                $join->on('BM.id', '=', 'HB.billing_method_id')
                    ->on('BM.currency_id', '=', 'HB.currency_id')
                    ->where('BM.del_flag', '=', Constant::DELETE_FLAG_FALSE);
            })
            ->join('m_currency AS CR', function ($join) {
                $join->on('CR.id', '=', 'HB.currency_id')
                    ->where('CR.del_flag', '=', Constant::DELETE_FLAG_FALSE);
            })
            ->whereRaw("(? IS NULL OR C.name_jp LIKE ?)", [$models['companyName'], "%" . $models['companyName'] . "%"])
            ->where('history_usage.billed_flag', '=', Constant::BILLED_FLAG_TRUE)
            ->where('HB.approved_flag', '=', Constant::STATUS_APPROVED)
            ->whereRaw("(? = 0 OR ? = 1)", [$models['approve'], $models['approve']])
            ->whereNull('HB.payment_actual_date')
            ->where(function ($query) use ($models) {
                $query->whereRaw('? = 0', [$models['status']])
                    ->orWhereRaw('(? = 2 AND HB.delivered_flag = ?)', [$models['status'], Constant::DELIVERY_FLAG_FALSE])
                    ->orWhereRaw('(? = 3 AND HB.delivered_flag = ?)', [$models['status'], Constant::DELIVERY_FLAG_TRUE]);
            })
            ->whereRaw("(HB.payment_due_date >= ? AND HB.payment_due_date <= ?)",
                    [$models['beginDate'], $models['endDate']]);

        $query = $billingCreate->union($billingApproved);
        $querySql = $query->toSql();
        return DB::table(DB::raw("($querySql order by company_name DESC) as tbl"))
                ->mergeBindings($query)
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
     * @param int $historyBillingId History billing Id
     * @return mixed Illuminate\Support\Collection
     */
    public function getBillingPaperDeliveryByHistoryBillingId($historyBillingId)
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
                                HB.payment_deadline_no,
                                HB.payment_due_date,
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
            ->where("HB.id", '=', $historyBillingId)
            ->where("HB.approved_flag", '=', Constant::STATUS_APPROVED)
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
            'payment_due_date' => $billingPaper->payment_due_date,
            'updated_by' => $billingPaper->user_login_id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return DB::table('t_history_billing')
            ->where('id', '=', $billingPaper->history_billing_id)
            ->update($arrUpdate);

    }
}
