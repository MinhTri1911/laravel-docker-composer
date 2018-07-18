<?php

/**
 * Create billing paper bussiness
 * Handle business Billing paper screen
 *
 * @package App\Business;
 * @author Rikkei.quangpm
 * @date 2018/07/11
*/

namespace App\Business;

use App\Common\Constant;
use Illuminate\Support\Facades\DB;
use App\Repositories\Billing\BillingPaperInterface;

/**
 * Class BillingPaperBusiness Handle business related billing paper
 */
class BillingPaperBusiness 
{

    // Business billing paper
    private $_billingPaperRepository;

    /**
     * BillingPaperBusiness constructor.
     *
     * @access public
     * @param BillingInterface $billingInterface
     * @return void
     */
    public function __construct(BillingPaperInterface $billingPaperInterface)
    {
        $this->_billingPaperRepository = $billingPaperInterface;
    }

    /**
     * Initial screen billing paper
     * 
     * @access public
     * @return array $models
     */
    public function initScreen()
    {
        $models = [];

        $models = $this->_initConditionScreen($models);

        $conditionSearch = [
            'companyName' => NULL,
            'status' => 0,
            'approve' => 0,
            'minMonth' => 0,
            'maxMonth' => 0,
            'numberRecord' => Constant::ARY_PAGINATION_PER_PAGE[1],
        ];
        $models['resultSearch'] = $this->_getListSearchBilling($conditionSearch);

        return $models;
    }

    /**
     * Search billing paper
     * 
     * @access public
     * @param array $conditionSearch condition search
     * @return array $models
     */
    public function searchBillingPaper($conditionSearch)
    {
        // Get min and max deadline month no
        $monthNow = date_create(date('Y-m') . '-1');

        // Date of input search
        $startDate = date_create($conditionSearch['startYear'] . '-' . $conditionSearch['startMonth'] . '-1');
        $endDate = date_create($conditionSearch['endYear'] . '-' . $conditionSearch['endMonth'] . '-1');

        // Interval input search
        $minMonth = date_diff($startDate, $monthNow);
        $maxMonth = date_diff($endDate, $monthNow);

        // Set min/max deadline month no
        $conditionSearch['minMonth'] = $minMonth->format('%m');
        $conditionSearch['maxMonth'] = $maxMonth->format('%m');

        $models['resultSearch'] = $this->_getListSearchBilling($conditionSearch);

        return $models;
    }

    /**
     * Initial control on screen
     * 
     * @access private
     * @param array $models model of screen
     * @return array $models
     */
    private function _initConditionScreen($models)
    {
        // Set data selectbox status
        $models['statusSelector'] = [ 0 => 'すべて',
                                     1 => '未作成',
                                     2 => '発行待ち',
                                     3 => '発行済'
                                ];

        // Set data selectbox status approve
        $models['statusApproveSelector'] = [ 0 => 'すべて',
                                            1 => '承認待ち',
                                            2 => '承認済み',
                                            3 => '却下'
                                       ];

        // Set data number of record to display
        $models['numberRecord'] = Constant::ARY_PAGINATION_PER_PAGE;

        // Set data combobox year
        $models['year'] = [ 'start' => (date('Y') - 5),
                           'end' => (date('Y') + 5)
                        ];

        return $models;
    }

    /**
     * Get list search billing
     * 
     * @param array $conditionSearch
     * @return array $result
     */
    private function _getListSearchBilling($conditionSearch)
    {
        // Get list search billing
        $listSearchBilling = $this->_billingPaperRepository->getListSearchBilling($conditionSearch);

        // Process display data
        $monthNowInt = (integer)date('m');
        $monthNow = date('Y-m') . '-01';
        foreach($listSearchBilling as $billing) {

            // Check month billing
            $listMonthBilling = explode(',', $billing->month_billing);
            $isBilling = 0;
            foreach ($listMonthBilling as $montBilling) {

                // Month billing is current month 
                if ($monthNowInt == (integer)trim($montBilling)) {
                    $isBilling = 1;

                    // Set payment deadline date
                    $monthChange = $billing->payment_deadline_no;
                    $monthDeadline = strtotime(date('Y-m-d', strtotime($monthNow)) . ' +' .$monthChange .' month');

                    $billing->payment_deadline_date = date('Y/m', $monthDeadline);

                    // Set total money
                    if ($billing->history_billing_id === null) {
                        $billing->total_money_yen = number_format($billing->total_money * 1.08 + $billing->charge, 2);
                    } else {
                        $billing->total_money_yen = number_format($billing->total_money, 2);
                    }

                    // Set text status billing paper
                    // Case waiting approve
                    if ($billing->approved_flag == Constant::STATUS_WAITING_APPROVE
                        || $billing->approved_flag == Constant::STATUS_REJECT_APPROVE) {
                        $billing->statusString = '';
                    } else {
                        $billing->statusString = Constant::ARR_BILLING_PAPER_STATUS[$billing->status];
                    }

                    // Set text status approve
                    // Case no create billing and approved
                    if ($billing->approved_flag === null) {
                        $billing->approveString = '';
                    } else {
                        
                        $billing->approveString = Constant::APPROVED_O[$billing->approved_flag];
                    }

                    break;
                }
            }

            // Remove object if no billing
            if ($isBilling == 1) {
                unset($billing);
            }
            
        }

        return $listSearchBilling;
    }
}
