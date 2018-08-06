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
use \Illuminate\Support\Facades\Lang;

class TaxController extends Controller
{
    use RolesController;

    // ID Screen
    const screenID = 'SMC0001';

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
        // Check permission view
//        $this->checkPermission(Constant::ALLOW_BILLING_VIEW, Constant::IS_CHECK_SCREEN);

        $models = $this->_billingPaperBusiness->initScreen();

        return view('tax.list-master', [
            'model' => $models,
            'paginator' => $models['resultSearch'],
            'url' => route('tax.index') . '?page='
        ]);
    }

}
