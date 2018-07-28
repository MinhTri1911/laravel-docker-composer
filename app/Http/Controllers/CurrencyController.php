<?php

/**
 * File currency controller
 *
 * @package App\Http\Controllers
 * @author Rikkei.Trihnm
 * @date 2018/07/27
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\CurrencyBusiness;
use App\Common\Constant;

class CurrencyController extends Controller
{
    private $currencyBusiness;

    public function __construct(CurrencyBusiness $currencyBusiness)
    {
        $this->currencyBusiness = $currencyBusiness;
    }

    /**
     * Function search currency
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        try {
            $data = $this->currencyBusiness->searchCurrencyByIdOrCode([
                'currency-id' => $request->get('currency-id'),
                'currency-code' => $request->get('currency-code')
            ]);

            $view = view('common.table-currency-search', ['currency' => $data])->render();

            return $this->returnJson(Constant::HTTP_CODE_SUCCESS, '', ['view' => $view]);
        } catch (\Exception $e) {

            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, ['error' => 'Seach currency error']);
        }
    }
}
