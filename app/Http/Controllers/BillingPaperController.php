<?php
/**
 * Create billing paper controller
 *
 * @package App\Http\Controllers
 * @author quangpm
 * @date 2018/06/19
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\RenderPDF as PDFRender;

class BillingPaperController extends Controller
{
    const screenID = 'SBA0001';

    /**
     * Show page index - create billing paper
     * 
     * @access public
     * @return view
     */
    public function index()
    {
        $model = [];

        //Set data selectbox status
        $model['statusSelector'] = [ 0 => 'すべて',
                                     1 => '請求書未作成',
                                     2 => '請求書発行待ち',
                                     3 => '請求書発行済'
                                ];

        //Set data selectbox status approve
        $model['statusApproveSelector'] = [ 0 => 'すべて',
                                            1 => '承認待ち',
                                            2 => '承認済み',
                                            3 => '却下'
                                       ];

        //Set data number of record to display
        $model['numberRecord'] = [ 15 => '15',
                                   25 => '25',
                                   50 => '50'
                                ];

        $model['year'] = [ 'start' => 1990,
                           'end' => (date('Y') + 10)
                        ];

        return view('billing.create-billing-paper', ['model' => $model]);
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
}
