<?php
/**
 * Create billing paper controller
 *
 * @package App\Http\Controllers
 * @author Rikkei.quangpm
 * @date 2018/06/19
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\BillingPaperBusiness;
use App\Common\Constant;
use App\Common\RenderPDF as PDFRender;

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
        $this->_billingPaperBusiness =  $billingPaperBusiness;
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
     * @return view
     */
    public function searchBillingPaper(Request $request)
    {

        $models = $this->_billingPaperBusiness->searchBillingPaper($request->conditionSearch);

        // Render data paginate after search
        $paginationView = view('billing.component.table.billing-paper', [
            'model' => $models,
            'paginator' => $models['resultSearch'],
            'url' => route('billing.search.billing.paper') . '?page='
        ])->render();

        return response()->json([
            'code' => Constant::HTTP_CODE_SUCCESS,
            'html' => $paginationView,
        ]);
    }
}
