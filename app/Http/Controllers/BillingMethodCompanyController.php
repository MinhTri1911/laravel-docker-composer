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
            return $this->_errorJson(trans('error.500'));
        }

        // Get currency id of company
        $currencyId = $this->_companyBusiness->getCompanyCurrencyId($request->get('current-url'));

        // Get billing method have same currency id of company
        $billings = $this->_billingMethodBusiness->getAllBillingMethodForCompany($currencyId);

        // Render view for show popup
        $view = view('company.component.detail.popup-setting-billing-method', ['billings' => $billings, 'id' => $id])->render();

        return response()->json([
            'code' => Constant::HTTP_CODE_SUCCESS,
            'view' => $view,
        ]);
    }

    /**
     * Update setting billing method for company
     * @param Illuminate\Http\Request request
     * @param int id
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return $this->_errorJson(trans('error.500'));
        }

        // Check the billing method id is exists in database
        $validationExists = $this->_billingMethodBusiness->checkBillingMethodExists($request->get('billing-method-id'));

        // Get currency id of company
        $currencyId = $this->_companyBusiness->getCompanyCurrencyId($request->get('current-url'));

        // Check currency id of billing method is match with currency id of company
        $validationMatch = $this->_billingMethodBusiness->compareCurrencyId($request->get('billing-method-id'), $currencyId);

        // Return error if validation fail
        if (!$validationExists || !$validationMatch) {
            $this->_errorJson(trans('error.e009_not_exists_master', ['field' => trans('company.lbl_billing_method_name')]));
        }

        \DB::beginTransaction();
        try {
            // Update billing method for company
            $this->_companyBusiness->updateBillingMethod($request->get('current-url'), $request->get('billing-method-id'));
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();

            return $this->_errorJson(trans('error.500'));
        }

        return response()->json([
            'code' => Constant::HTTP_CODE_SUCCESS,
            'billingId' => $request->get('billing-method-id'),
            'newShowUrl' => route('billing.method.show', $request->get('billing-method-id')),
        ]);
    }

    private function _errorJson($message)
    {
        return response()->json([
            'code' => Constant::HTTP_CODE_ERROR_500,
            'message' => $message,
        ]);
    }
}
