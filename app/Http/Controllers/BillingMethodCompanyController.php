<?php

/**
 * File billing method controller
 *
 * @package App\Http\Controllers
 * @author Rikkei.trihnm
 * @date 2018/07/10
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\CompanyBusiness;
use App\Business\BillingMethodBusiness;
use App\Common\Constant;

class BillingMethodCompanyController extends Controller
{
    private $_billingMethodBusiness;
    private $_companyBusiness;

    public function __construct(BillingMethodBusiness $billingMethod, CompanyBusiness $company)
    {
        $this->_billingMethodBusiness = $billingMethod;
        $this->_companyBusiness = $company;
    }

    /**
     * Show popup setting billing method
     * @param Illuminate\Http\Request request
     * @param int id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request, $id)
    {
        if (!$request->ajax()) {
            return response()->json(['code' => Constant::HTTP_CODE_ERROR_500]);
        }

        $currencyId = $this->_companyBusiness->getCompanyCurrencyId($request->get('current-url'));dd($this->_companyBusiness->getCompanyCurrencyId($request->get('current-url')));
        $billings = $this->_billingMethodBusiness->getAllBillingMethodForCompany($currencyId);
        $view = view('company.component.detail.popup-setting-billing-method', ['billings' => $billings, 'id' => $id])->render();

        return response()->json([
            'code' => Constant::HTTP_CODE_SUCCESS,
            'view' => $view,

            'demo' => $request->fullUrl(),
        ]);
    }

    /**
     * Update setting billing method for company
     * @param Illuminate\Http\Request request
     * @param int id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['code' => Constant::HTTP_CODE_ERROR_500]);
        }

        $validation = $this->_billingMethodBusiness->checkBillingMethodExists($request->get('billing-method-id'));
        $currencyId = $this->_companyBusiness->getCompanyCurrencyId($request->get('current-url'));
        $validation = $this->_billingMethodBusiness->compareCurrencyId($request->get('billing-method-id'), $currencyId);

        if (!$validation) {
            return response()->json([
                'code' => Constant::HTTP_CODE_ERROR_500,
                'message' => '',
            ]);
        }

        \DB::beginTransaction();
        try {
            $this->_companyBusiness->updateBillingMethod($request->get('current-url'), $request->get('billing-method-id'));
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new Exception("Error Processing Update", Constant::HTTP_CODE_ERROR_500);
        }

        return response()->json([
            'code' => Constant::HTTP_CODE_SUCCESS,
            'billingMethodNameJP' => $request->get('billing-method-name-jp'),
            'billingMethodNameEN' => $request->get('billing-method-name-en'),
        ]);
    }
}
