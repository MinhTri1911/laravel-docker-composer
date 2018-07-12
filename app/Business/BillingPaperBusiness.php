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
        ];
        $models['resultSearch'] = $this->_getListSearchBilling($conditionSearch);

        return $models;
    }

    /**
     * Get list search billing
     * 
     * @param type $conditionSearch
     * @return array $result
     */
    private function _getListSearchBilling($conditionSearch)
    {
        $listSearchBilling = [];

        $listSearchBilling = $this->_billingPaperRepository->getListSearchBilling($conditionSearch);

        foreach($listSearchBilling as $billing) {
//            $listMonthBilling
        }

        return $listSearchBilling;
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
                                            1 => '承認済み',
                                            2 => '承認待ち',
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
}
