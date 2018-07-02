<?php
/**
 * Create Statistic Billing controller
 *
 * @package App\Http\Controllers
 * @author quangpm
 * @date 2018/06/28
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticBillingController extends Controller
{
    const screenID = 'SBA0004';

    /**
     * Show page index - statistic billing
     * 
     * @access public
     * @return view
     */
    public function index()
    {
        $model = [];

        //Set data selectbox objectStatistic
        $model['objectStatistic'] = [ 0 => 'システム',
                                      1 => '会社'
                                ];

        //Set data year
        $model['year'] = [ 2016 => '2016',
                           2017 => '2017',
                           2018 => '2018',
                           2019 => '2019',
                           2020 => '2020',
                         ];

        //Set data number of record to display
        $model['numberRecord'] = [ 15 => '15',
                                   25 => '25',
                                   50 => '50'
                                ];

        return view('billing.statistic-billing', ['model' => $model]);
    }
}