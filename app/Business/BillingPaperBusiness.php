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
use \Illuminate\Support\Facades\Lang;
use App\Repositories\Billing\BillingPaperInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Common\RenderPDF as PDFRender;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
     * @param BillingInterface $billingPaperInterface billing paper interface
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
        $models = $this->_initConditionScreen([]);

        $conditionSearch = [
            'companyName' => null,
            'status' => 0,
            'approve' => 0,
            'startYear' => date('Y'),
            'startMonth' => (integer)date('m'),
            'endYear' => date('Y'),
            'endMonth' => (integer)date('m'),
            'numberRecord' => Constant::ARY_PAGINATION_PER_PAGE[10],
        ];
        $listSearch = $this->searchBillingPaper($conditionSearch);
        $models['resultSearch'] = $listSearch['resultSearch'];

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
        $monthNow = date_create(date('Y-m') . '-01');

        // Date of input search
        $startDate = date_create($conditionSearch['startYear'] . '-' . $conditionSearch['startMonth'] . '-1');
        $endDate = date_create($conditionSearch['endYear'] . '-' . $conditionSearch['endMonth'] . '-1');
        $endDayTime = strtotime(date_format($endDate, "Y-m-d") . ' +' . 1 . ' month -1 days');

        // Interval input search
        $minMonth = date_diff($startDate, $monthNow);
        $maxMonth = date_diff($endDate, $monthNow);

        // Set min/max deadline month no
        $conditionSearch['minMonth'] = $startDate >= $monthNow ? $minMonth->format('%m') : '-1';
        $conditionSearch['maxMonth'] = $endDate >= $monthNow ? $maxMonth->format('%m') : '-1';

        // Set start/end deadline date
        $conditionSearch['beginDate'] = date_format($startDate, "Y-m-d");
        $conditionSearch['endDate'] = date('Y-m-d', $endDayTime);

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
        $models['statusSelector'] = [0 => 'すべて',
            1 => '未作成',
            2 => '発行待ち',
            3 => '発行済'
        ];

        // Set data selectbox status approve
        $models['statusApproveSelector'] = [0 => 'すべて',
            1 => '承認待ち',
            2 => '承認済み',
            3 => '却下'
        ];

        // Set data number of record to display
        $models['numberRecord'] = Constant::ARY_PAGINATION_PER_PAGE;

        // Set data combobox year
        $models['year'] = ['start' => (date('Y') - 5),
            'end' => (date('Y') + 5)
        ];

        return $models;
    }

    /**
     * Get list search billing
     *
     * @access private
     * @param array $conditionSearch Condition search
     * @return object $result
     */
    private function _getListSearchBilling($conditionSearch)
    {

        // Get list search billing
        $listSearchBilling = $this->_billingPaperRepository->getListSearchBilling($conditionSearch);

        $monthNowInt = (integer)date('m'); // Current month
        $monthNow = date('Y-m') . '-01'; // Date 1 of current month

        // Process display data
        foreach ($listSearchBilling as $billing) {

            // Check month billing and handle data for display
            $listMonthBilling = explode(',', $billing->month_billing);
            $isBilling = $this->_handleDataBilling($billing, $listMonthBilling, $monthNowInt, $monthNow);

            // Remove object if no billing
            if ($isBilling === null) {
                unset($billing);

            } else {
                // Set text column money in screen
                $billing->total_money_yen = number_format($billing->total_money, 2);

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
            }
        }

        return $listSearchBilling;
    }

    /**
     * Create data for display or prepare create billing paper
     *
     * @access private
     * @param object $billing Object billing paper
     * @param arrray $listMonthBilling Object billing paper
     * @param int $monthNowInt Current month
     * @param Date $monthNow Date 1 of current month
     * @return null|object
     */
    private function _handleDataBilling($billing, $listMonthBilling, $monthNowInt, $monthNow)
    {
        foreach ($listMonthBilling as $montBilling) {

            // Month billing is current month: Billing paper create or waitng delivery or Delivered
            if ($monthNowInt == (integer)trim($montBilling)
                || $billing->status == Constant::STATUS_BILLING_WAITING_DELIVERY
                || ($billing->status == Constant::STATUS_BILLING_DELIVERED)) {

                // Set payment deadline
                $monthChange = $billing->payment_deadline_no + 1;
                $monthDeadline = strtotime(date('Y-m-d', strtotime($monthNow)) . ' +' . $monthChange . ' month -1 days');

                $billing->payment_deadline_month = date('Y/m', $monthDeadline);
                $billing->payment_due_date = date('Y-m-d', $monthDeadline);

                // Set total money
                if ($billing->approved_flag === null || $billing->approved_flag == Constant::STATUS_REJECT_APPROVE) {
                    // Set money for insert
                    $billing->total_amount_billing = $billing->total_amount_billing * 1.08 + $billing->charge;
                    $billing->total_money = $billing->total_money * 1.08 + $billing->charge;
                }

                return $billing;
            }
        }

        return null;
    }

    /**
     * Create billing paper
     *
     * @access public
     * @param object $model object create billing paper
     * @return array $result
     */
    public function createBillingPaper($model)
    {
        try {

            // Get data billing paper
            $billingPaperDatabase = $this->_billingPaperRepository->getBillingPaperByCompanyId($model['companyId']);

            // Validate billing paper and set total money billing
            $billingPaper = $this->_validateBillingPaper($billingPaperDatabase);
            if (gettype($billingPaper) == 'array' && isset($billingPaper['error_message'])) {
                return $billingPaper;
            }

            // Get list history usage
            $listHistoryUsageDB = $this->_billingPaperRepository->getListHistoryUsageByCompanyId($model['companyId']);

            // Get list history usage billing
            $arrHistoryUsageDB = $listHistoryUsageDB->toArray();
            $arrHistoryUsageId = array_column($arrHistoryUsageDB, 'history_usage_id');
            $billingPaper->history_usage_id = implode(', ', $arrHistoryUsageId);

            // Create pdf billing paper
            $billingPaper->url_pdf = $this->_createPdfBillingPaper($billingPaper);
            if ($billingPaper->url_pdf === null) {
                return [
                    'error_message' => Lang::get('billing.message.not_found_data')
                ];
            }

            // Set data create billing
            $billingPaper->remark = $model['remark'];
            $billingPaper->user_login_id = Auth::id();

            // Begin transaction
            DB::beginTransaction();

            // Register database
            $this->_registerDatabaseCreate($billingPaper);

            // Commit transaction
            DB::commit();

            return true;
        } catch (Exception $e) {

            // Rollback transaction
            DB::rollBack();

            return [
                'error_message' => Lang::get('common-message.error.E002')
            ];
        }
    }

    /**
     * Validate billing paper and set total money billing
     *
     * @access private
     * @param object $billingPaperDatabase Object billing paper
     * @return object|array
     */
    private function _validateBillingPaper($billingPaperDatabase)
    {
        // Check exist billing paper
        if (count($billingPaperDatabase) == 0) {
            return [
                'error_message' => Lang::get('billing.message.not_found_data')
            ];
        }

        $billingPaperData = $billingPaperDatabase[0]; // Set object billing paper
        $monthNowInt = (integer)date('m'); // Current month
        $monthNow = date('Y-m') . '-01'; // Date 1 of current month

        // Check month billing and handle data for create billing paper
        $listMonthBilling = explode(',', $billingPaperData->month_billing);
        $billingPaper = $this->_handleDataBilling($billingPaperData, $listMonthBilling, $monthNowInt, $monthNow);

        // Check month billing fail
        if ($billingPaper === null) {
            return [
                'error_message' => Lang::get('billing.message.not_found_data')
            ];
        }

        return $billingPaper;
    }

    /**
     * Create pdf billing paper
     *
     * @access private
     * @param object $billingPaper Object billing paper
     * @return null|url $urlPdf
     */
    private function _createPdfBillingPaper($billingPaper)
    {
        $urlPdf = '';

        return $urlPdf;
    }

    /**
     * Register database create billing paper
     *
     * @access private
     * @param object $billingPaper Object billing paper
     * @return bool
     */
    private function _registerDatabaseCreate($billingPaper)
    {
        // Create new history billing
        if ($billingPaper->approved_flag === null) {
            return $this->_billingPaperRepository->insertHistoryBilling($billingPaper);
        } // Update history billing
        elseif ($billingPaper->approved_flag === Constant::STATUS_REJECT_APPROVE) {
            return $this->_billingPaperRepository->updateHistoryBilling($billingPaper);
        }

        return false;
    }

    /**
     * Delivery billing paper
     *
     * @access public
     * @param object $model object delivery billing paper
     * @return array $result
     */
    public function deliveryBillingPaper($model)
    {
        try {
            $result = [];

            // Get data billing paper
            $billingPaperDatabase = $this->_billingPaperRepository->getBillingPaperDeliveryByCompanyId($model['companyId']);

            if (count($billingPaperDatabase) == 0) {
                return [
                    'error_message' => Lang::get('billing.message.not_found_data')
                ];
            }

            $billingPaper = $billingPaperDatabase[0];
            $billingPaper->user_login_id = Auth::id();

            // Method billing is send mail
            if ($billingPaper->method == Constant::BILLING_METHOD_MAIL) {
                $this->_sendMailDelivery($billingPaper);
                $result['billing_method'] = $billingPaper->method;
            }

            // Method billing is Print PDF
            // Create and save pdf billing paper file
            if ($billingPaper->method != Constant::BILLING_METHOD_MAIL) {
                $result = $this->_createPdfDelivery($billingPaper);
            }

            if ($billingPaper->delivered_flag == Constant::DELIVERY_FLAG_FALSE) {
                // Begin transaction
                DB::beginTransaction();

                // Update Flag delivered
                $this->_billingPaperRepository->updateFlagDelivered($billingPaper);

                // Commit transaction
                DB::commit();
            }

            return $result;
        } catch (Exception $e) {

            // Rollback transaction
            DB::rollBack();

            return [
                'error_message' => Lang::get('common-message.error.E002')
            ];
        }
    }

    /**
     * Create and save pdf billing paper file
     *
     * @access private
     * @param object $billingPaper Object billing paper
     * @return bool
     */
    private function _createPdfDelivery($billingPaper)
    {
        $result = [];
        $result['billing_method'] = $billingPaper->method;

        // Clear cache
        ob_clean();
        flush();

        // File name
        $pdfFileName = $billingPaper->company_id . '_' . $billingPaper->company_name . '_' . date('YmdHis');
        // Path folder pdf
        $pdfPathFile = public_path() . '/Billing_Paper/' . date('Ym') . '/';

        $result['pdf_full_path'] = $pdfPathFile . $pdfFileName;
        $result['pdf_path'] = 'Billing_Paper/' . date('Ym') . '/' . $pdfFileName . '.pdf';

        // Check exist and create folder
        if (!file_exists($pdfPathFile)) {
            mkdir($pdfPathFile, 0777, true);
        }

        // Save file csv
        PDFRender::$pdfFileName = $result['pdf_full_path'];
        PDFRender::exportPDFWithView('billing.paper-billing-pdf', ['user' => 'QuangPM'], 'save');

        return $result;
    }

    /**
     * Send mail billing paper
     *
     * @access private
     * @param object $billingPaper Object billing paper
     * @return bool
     */
    private function _sendMailDelivery($billingPaper)
    {
        // Not yet delivery
        if ($billingPaper->delivered_flag == Constant::DELIVERY_FLAG_FALSE) {
            return true;
        } // Delivered
        elseif ($billingPaper->delivered_flag == Constant::DELIVERY_FLAG_TRUE) {
            return true;
        }

        return true;
    }

    /**
     * Get data csv
     *
     * @access pubic
     * @param array $conditionSearch Condition search billing paper
     * @return bool
     */
    public function exportBillingPaper($conditionSearch)
    {
        try {

            $result = [];
            $fileName = 'billingpaper.csv';

            // Add headers for each column in the CSV download
            $headers = [
                '会社名', // company name
                'その月の請求総額', // total money
                '支払予定年月',  // payment_due_date
                '支払方法（現金/手形）', // method_name
                '窓口1 担当者名', // ope_person_name_1
                '窓口1 電話番号', // ope_phone_1
                '窓口1 メールアドレス', // ope_email_1
                '状態', // Status
                '承認' // Staus approve
            ];

            // Get data search
            $listSearch = $this->searchBillingPaper($conditionSearch);
            $result['resultSearch'] = $listSearch['resultSearch'];
            $list = $result['resultSearch']->items();

            // Create data csv array
            $arrListCsv = [];
            $arrListCsv[] = $headers;
            foreach ($list as $row) {
                $array = [];
                $array[] = $row->company_name;
                $array[] = $row->total_money;
                $array[] = $row->payment_due_date;
                $array[] = $row->method_name;
                $array[] = $row->ope_person_name_1;
                $array[] = $row->ope_phone_1;
                $array[] = $row->ope_email_1;
                $array[] = $row->statusString;
                $array[] = $row->approveString;
                $arrListCsv[] = $array;
            }

            // Create new spreadsheet
            $spreadSheet = new Spreadsheet();
            $objWorksheet = $spreadSheet->getActiveSheet();
            foreach ($arrListCsv as $index => $row) {
                $objWorksheet->fromArray(
                    $row, NULL, 'A' . $index);
            }

            // Header
            header('Content-Description: File Transfer');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Content-Disposition: attachment; filename=' . $fileName);
            header('Expires: 0');
            header('Pragma: no-cache');
            // force download  
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            ob_clean();
            flush();

            $objWriter = new Csv($spreadSheet);
            $objWriter->save('php://output');

            exit();

        } catch (Exception $ex) {
            return [
                'error_message' => Lang::get('common-message.error.E002')
            ];
        }
    }
}
