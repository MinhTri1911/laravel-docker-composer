<?php
/**
 * Create billing paper controller
 *
 * @package App\Http\Controllers
 * @author Rikkei.Quangpm
 * @date 2018/06/19
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\BillingPaperBusiness;
use App\Common\Constant;
use App\Common\RenderPDF as PDFRender;
use \Illuminate\Support\Facades\Lang;

class BillingPaperController extends Controller
{
    // ID Screen
    const screenID = 'SBA0001';

    // Object handle business
    private $_billingPaperBusiness = null;

    /**
     * Function construct
     *
     * @access public
     * @param BillingPaperBusiness $billingPaperBusiness
     * @return void
     */
    public function __construct(BillingPaperBusiness $billingPaperBusiness)
    {
        $this->_billingPaperBusiness = $billingPaperBusiness;
    }

    /**
     * Show page index - create billing paper
     *
     * @access public
     * @return view
     */
    public function index()
    {

        $models = $this->_billingPaperBusiness->initScreen();

        return view('billing.create-billing-paper', [
            'model' => $models,
            'paginator' => $models['resultSearch'],
            'url' => route('billing.create.billing.paper') . '?page='
        ]);
    }

    /**
     * Preview billing paper
     *
     * @access public
     * @return view
     */
    public function previewBillingPaper()
    {
        PDFRender::$pdfFileName = "関する基CMAXS";
        return PDFRender::exportPDFWithView('billing.paper-billing-pdf', ['user' => 'QuangPM'], 'stream');
    }

    /**
     * Search billing paper
     *
     * @access public
     * @param Request $request request
     * @return view
     */
    public function searchBillingPaper(Request $request)
    {

        $paginationView = $this->_refreshSearch($request->conditionSearch);

        return response()->json([
            'code' => Constant::HTTP_CODE_SUCCESS,
            'html' => $paginationView,
        ]);
    }

    /**
     * Create billing paper
     *
     * @access public
     * @param Request $request request
     * @return view
     */
    public function createBillingPaper(Request $request)
    {
        // Check empty companyId
        if (empty($request->createBillingPaper['companyId'])) {
            return response()->json([
                'code' => Constant::HTTP_CODE_ERROR_404,
                'title' => Lang::get('billing.title_popup_create'),
                'message' => Lang::get('billing.message.choose_row')
            ]);
        }

        // Create billing paper
        $resultCreateBilling = $this->_billingPaperBusiness->createBillingPaper($request->createBillingPaper);

        // Refresh data search
        $paginationView = $this->_refreshSearch($request->conditionSearch);

        // Return error code 500
        if (gettype($resultCreateBilling) == 'array' && isset($resultCreateBilling['error_message'])) {
            return response()->json([
                'code' => Constant::HTTP_CODE_ERROR_500,
                'message' => $resultCreateBilling['error_message'],
                'title' => Lang::get('billing.title_popup_create'),
                'html' => $paginationView,
            ]);

        } else {
            // Return when success
            return response()->json([
                'code' => Constant::HTTP_CODE_SUCCESS,
                'message' => Lang::get('billing.message.create_billing_ok'),
                'title' => Lang::get('billing.title_create_billing_paper'),
                'html' => $paginationView,
            ]);
        }
    }

    /**
     * Delivery billing paper
     *
     * @access public
     * @param Request $request request
     * @return view
     */
    public function deliveryBillingPaper(Request $request)
    {

        // Check empty companyId
        if (empty($request->deliveryBillingPaper['historyBillingId'])) {
            return response()->json([
                'code' => Constant::HTTP_CODE_ERROR_404,
                'title' => Lang::get('billing.title_popup_delivery'),
                'message' => Lang::get('billing.message.choose_row')
            ]);
        }

        // Delivery billing paper
        $resultDeliveryBillingPaper = $this->_billingPaperBusiness->deliveryBillingPaper($request->deliveryBillingPaper);

        // Refresh data search
        $paginationView = $this->_refreshSearch($request->conditionSearch);

        // Return error code 500
        if (gettype($resultDeliveryBillingPaper) == 'array' && isset($resultDeliveryBillingPaper['error_message'])) {

            return response()->json([
                'code' => Constant::HTTP_CODE_ERROR_500,
                'message' => $resultDeliveryBillingPaper['error_message'],
                'title' => Lang::get('billing.title_popup_delivery'),
                'html' => $paginationView,
            ]);
        } else {

            // Check method delivery
            if ($resultDeliveryBillingPaper['billing_method'] != Constant::BILLING_METHOD_MAIL) {
                return response()->json([
                    'code' => Constant::HTTP_CODE_SUCCESS,
                    'pdf_url' => $resultDeliveryBillingPaper['pdf_path'],
                    'html' => $paginationView,
                ]);

            } else {
                // Return when send mail
                return response()->json([
                    'code' => Constant::HTTP_CODE_SUCCESS,
                    'message' => Lang::get('billing.message.delivery_billing_ok'),
                    'title' => Lang::get('billing.title_popup_delivery'),
                    'html' => $paginationView,
                ]);
            }
        }
    }

    /**
     * Export billing paper
     *
     * @access public
     * @param Request $request request
     * @return view
     */
    public function exportBillingPaper(Request $request)
    {
        // Export billing paper
        $resultExport = $this->_billingPaperBusiness->exportBillingPaper($request->conditionSearch);

        // Return error code 500
        if (isset($resultExport['error_message'])) {

            return response()->json([
                'code' => Constant::HTTP_CODE_ERROR_500,
                'message' => $resultExport['error_message'],
                'title' => Lang::get('billing.title_popup_create')
            ]);
        } else {

            return response()->stream($resultExport['file'], 200, $resultExport['headers']);
        }
    }

    /**
     * Export billing paper
     *
     * @access private
     * @param array $conditionSearch Condition search
     * @return view
     */
    private function _refreshSearch($conditionSearch)
    {
        // Refresh data search
        $resultSearch = $this->_billingPaperBusiness->searchBillingPaper($conditionSearch);

        // Render data paginate after search
        return view('billing.component.table.billing-paper', [
            'model' => $resultSearch,
            'paginator' => $resultSearch['resultSearch'],
            'url' => route('billing.search.billing.paper') . '?page='
        ])->render();
    }
}
