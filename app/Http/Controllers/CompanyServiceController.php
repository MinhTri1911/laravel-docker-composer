<?php

/**
 * File company service controller
 *
 * @package App\Http\Controllers
 * @author Rikkei.trihnm
 * @date 2018/07/11
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\CompanyServiceBusiness;
use App\Business\CompanyBusiness;
use App\Common\Constant;
use Validator;

class CompanyServiceController extends Controller
{
    private $_companyServiceBusiness;
    private $_companyBusiness;

    public function __construct(CompanyServiceBusiness $companyService, CompanyBusiness $company)
    {
        $this->_companyServiceBusiness = $companyService;
        $this->_companyBusiness = $company;
    }

    /**
     * Show popup add service for all ship
     * @param Illuminate\Http\Request request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        if (!$request->ajax()) {
            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('error.500'));
        }

        $currencyId = $this->_companyBusiness->getCompanyCurrencyId($request->get('current-url'));
        $services = $this->_companyServiceBusiness->showAllService($currencyId);

        $view = view('company.component.detail.popup-add-service-for-all-ship', ['services' => $services])->render();

        return $this->returnJson(Constant::HTTP_CODE_SUCCESS, '', ['view' => $view]);
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('error.500'));
        }

        $validator = Validator::make($request->all(), [
            'service-id' => 'required|numeric',
            'start-date' => 'required|date_format:Y/m/d|after_or_equal:now',
            'end-date' => 'required|date_format:Y/m/d|after:start-date',
        ]);

        if ($validator->fails()) {
            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, $validator->errors());
        }

        \DB::beginTransaction();
        try {
            $currencyId = $this->_companyBusiness->getCompanyCurrencyId($request->get('current-url'));
            $checkExists = $this->_companyServiceBusiness->checkServiceId($request->get('service-id'), $currencyId);

            if (!$checkExists) {
                return $this->returnJson(Constant::HTTP_CODE_ERROR_500, [
                    'service-id' => [trans('validation.exists', ['attribute' => trans('company.lbl_service_name')])],
                ]);
            }

            $this->_companyServiceBusiness->createContractCompany(
                1,
                $request->get('service-id'),
                $request->get('start-date'),
                $request->get('end-date'),
                $currencyId
            );

            // return response()->json([
            //     'aa' => $this->_companyServiceBusiness->createContractCompany(
            //         1,
            //         $request->get('service-id'),
            //         $request->get('start-date'),
            //         $request->get('end-date'),
            //         $currencyId
            //     )
            // ]);

            \DB::commit();
       } catch (\Exception $e) {
           \DB::rollback();
            dd($e);
       }

    }
}
