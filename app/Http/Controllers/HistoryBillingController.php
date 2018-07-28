<?php
/**
 * History billing controller
 *
 * @package App\Http\Controllers
 * @author Rikkei.Quangpm
 * @date 2018/06/27
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryBillingController extends Controller
{
    const screenID = 'SBA0003';

    /**
     * Show history billing
     * 
     * @access public
     * @return view
     */
    public function index()
    {
        $model = [];

        //Set data selectbox nation
        $model['nation'] = [ 0 => 'Japan',
                             1 => 'English'
                         ];

        //Set data selectbox currency
        $model['currency'] = [ 0 => 'JPY',
                               1 => 'USD'
                             ];

        //Set data selectbox status
        $model['status'] = [ 0 => 'すべて',
                               1 => '承認済み',
                               2 => '承認待ち',
                               3 => '拒絶'
                             ];

        //Set data number of record to display
        $model['numberRecord'] = [ 15 => '15',
                                   25 => '25',
                                   50 => '50'
                                ];

        return view('billing.history-billing', ['model' => $model]);
    }
}