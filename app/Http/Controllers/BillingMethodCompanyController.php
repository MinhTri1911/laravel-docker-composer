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
use App\Http\Requests\BillingMethodRequest;

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
            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('error.500'));
        }

        // Get currency id of company
        $currencyId = $this->_companyBusiness->getCompanyCurrencyId($request->get('company-id'));

        // Get billing method have same currency id of company
        $billings = $this->_billingMethodBusiness->getAllBillingMethodForCompany($currencyId);

        // Render view for show popup
        $view = view('company.component.detail.popup-setting-billing-method', ['billings' => $billings, 'id' => $id])->render();

        return $this->returnJson(Constant::HTTP_CODE_SUCCESS, '', [
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
    public function update(BillingMethodRequest $request)
    {
        if (!$request->ajax()) {
            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('error.500'));
        }

        \DB::beginTransaction();
        try {
            // Update billing method for company
            $this->_companyBusiness->updateBillingMethod($request->get('company-id'), $request->get('billing-method-id'));
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();

            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('error.500'));
        }

        return $this->returnJson(Constant::HTTP_CODE_SUCCESS, '', [
            'code' => Constant::HTTP_CODE_SUCCESS,
            'billingId' => $request->get('billing-method-id'),
            'newShowUrl' => route('billing.method.show', $request->get('billing-method-id')),
        ]);
    }
}
