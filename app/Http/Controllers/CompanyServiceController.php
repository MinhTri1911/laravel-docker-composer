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
use App\Http\Requests\CompanyServiceRequest;

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
     * Function get all service of company
     * @param Illuminate\Http\Request request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('error.500'));
        }

        $services = $this->_companyServiceBusiness->getAllServiceOfCompany($request->get('company-id'));
        $view = view('company.component.detail.popup-delete-service-in-all-ship', ['services' => $services])->render();

        return $this->returnJson(Constant::HTTP_CODE_SUCCESS, '', [
            'view' => $view,
        ]);
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

        $currencyId = $this->_companyBusiness->getCompanyCurrencyId($request->get('company-id'));
        $services = $this->_companyServiceBusiness->showAllService($currencyId);

        $view = view('company.component.detail.popup-add-service-for-all-ship', ['services' => $services])->render();

        return $this->returnJson(Constant::HTTP_CODE_SUCCESS, '', ['view' => $view]);
    }

    /**
     * Function add service for all ship
     * @param Illuminate\Http\Request request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(CompanyServiceRequest $request)
    {
        if (!$request->ajax()) {
            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('error.500'));
        }

        \DB::beginTransaction();
        try {
            $currencyId = $this->_companyBusiness->getCompanyCurrencyId($request->get('company-id'));
            $checkExists = $this->_companyServiceBusiness->checkServiceId($request->get('service-id'), $currencyId);

            if (!$checkExists) {
                return $this->returnJson(Constant::HTTP_CODE_ERROR_500, [
                    'service-id' => [trans('validation.exists', ['attribute' => trans('company.lbl_service_name')])],
                ]);
            }

            $this->_companyServiceBusiness->createContractCompany(
                $request->get('company-id'),
                $request->get('service-id'),
                $request->get('start-date'),
                $request->get('end-date'),
                $currencyId
            );

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();

            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('error.500'));
        }

        return $this->returnJson(Constant::HTTP_CODE_SUCCESS);
    }

    /**
     * Function delete service
     * @param Illuminate\Http\Request request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request)
    {
        if (!$request->ajax()) {
            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('error.500'));
        }

        \DB::beginTransaction();
        try {

            $this->_companyServiceBusiness->deleteServiceInCompany($request->get('service-ids'), $request->get('company-id'));
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();

            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('common.validate_error_exists'));
        }

        return $this->returnJson(Constant::HTTP_CODE_SUCCESS);
    }

    /**
     * Show popup confirm delete service in all ship
     * @param Illuminate\Http\Request request
     * @param string serviceName
     * @param int serviceId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function confirmDeleteServiceInAllShip(Request $request, $serviceName, $serviceId)
    {
        if (!$request->ajax()) {
            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('error.500'));
        }

        $view = view('company.component.detail.popup-confirm-delete-service-in-all-ship', compact('serviceName', 'serviceId'))
            ->render();

        return $this->returnJson(Constant::HTTP_CODE_SUCCESS, '', ['view' => $view]);
    }

    /**
     * Function delete all service
     * @param Illuminate\Http\Request request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAll(Request $request)
    {
        if (!$request->ajax()) {
            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('error.500'));
        }

        \DB::beginTransaction();
        try {

            $this->_companyServiceBusiness->deleteAllService($request->get('company-id'));
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();

            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('common.validate_error_exists'));
        }

        return $this->returnJson(Constant::HTTP_CODE_SUCCESS);
    }
}
