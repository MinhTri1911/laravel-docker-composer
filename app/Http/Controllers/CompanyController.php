<?php

/**
 * File company controller
 *
 * @package App\Http\Controllers
 * @author Rikkei.Trihnm
 * @date 2018/06/19
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\CompanyBusiness;
use App\Common\Constant;
use App\Http\Requests\ConfirmPasswordRequest;

class CompanyController extends Controller
{
    private $_companyBusiness;

    /**
     * Function construct
     * @access public
     * @return void
     */
    public function __construct(CompanyBusiness $companyBusiness)
    {
        $this->_companyBusiness = $companyBusiness;
    }

    /**
     * Show list company
     * @access public
     * @param Illuminate\Http\Request request
     * @return View, \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        // Get data for sort data
        $data = [
            'field' => $request->field, // field to order by
            'sortBy' => $request->sortBy, // ordery by
        ];

        // Init list company
        $companies = $this->_companyBusiness->initListCompany($data['field'], $data['sortBy']);

        // Paginate list company ajax
        if ($request->ajax()) {
            return response()->json([
                'code' => Constant::HTTP_CODE_SUCCESS,
                'table' => view('company.component.list.table-tbody-company', ['companies' => $companies])->render(),
                'paginate' => view('company.component.paginate.default', [
                    'paginator' => $companies,
                    'url' => route('company.index') . '?page=',
                ])->render(),
                'typeRender' => 'filter',
            ]);
        }

        return view('company.list', ['companies' => $companies, 'url' => route('company.index') . '?page=',]);
    }

    /**
     * Search list company by group and load result
     * @access public
     * @param Illuminate\Http\Request request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchCompany(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['code' => Constant::HTTP_CODE_ERROR_500]);
        }

        // Set data group by, load result, order by, filed column to order by
        $data = [
            'group' => $request->group,
            'load' => $request->load,
            'field' => $request->field,
            'sortBy' => $request->sortBy,
            'showType' => in_array($request->showType, [Constant::SHOW_ACTIVE, Constant::SHOW_NOT_ACTIVE])
                ? $request->showType
                : Constant::SHOW_ACTIVE,
        ];

        // Get data search company
        $companies = $this->_companyBusiness->searchCompany(
            $data['group'],
            $data['load'],
            $data['field'],
            $data['sortBy'],
            $data['showType']
        );

        // Check exists group type if not set default is group company
        if ($data['group'] != config('company.group_company') && $data['group'] != config('company.group_service')) {
            $data['group'] = config('company.group_company');
        }

        // Check exists data load result if not set default is 10
        if (!in_array($data['load'], config('pagination.paginate_value'))) {
            $data['load'] = config('pagination.default');
        }

        // Render data after search by group company or group service
        $tableview = !$data['group']
            ? view('company.component.list.table-group-company', ['companies' => $companies])->render()
            : view('company.component.list.table-group-service', ['companies' => $companies])->render();

        // Render data paginate after search
        $paginationView = view('company.component.paginate.default', [
            'paginator' => $companies,
            'url' => route('company.search', $data) . '&page=',
        ])->render();

        return response()->json([
            'code' => Constant::HTTP_CODE_SUCCESS,
            'table' => $tableview,
            'paginate' => $paginationView,
            'typeRender' => 'search',
        ]);
    }

    /**
     * Filter list company by group and load result
     * @access public
     * @param Illuminate\Http\Request request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filterCompany(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['code' => Constant::HTTP_CODE_ERROR_500]);
        }

        // Get data for filter
        $data = $request->only([
            'filter-company',
            'filter-service',
            'filter-nation',
            'filter-address',
            'filter-company-operation',
            'filter-company-ope-person-name-1',
            'filter-company-ope-person-email-1',
            'filter-company-ope-person-phone-1',
            'filter-company-ope-person-name-2',
            'filter-company-ope-person-email-2',
            'filter-company-ope-person-phone-2',
        ]);

        // Set data field column to order by
        $data['field'] = $request->field;

        // Set data order by
        $data['sortBy'] = $request->sortBy;

        // Set data group by
        $data['group'] = $request->group;

        // Set data load result
        $data['load'] = $request->load;

        // Set data load result
        $data['showType'] = in_array($request->showType, [Constant::SHOW_ACTIVE, Constant::SHOW_NOT_ACTIVE])
            ? $request->showType
            : Constant::SHOW_ACTIVE;

        // Get data filter company
        $companies = $this->_companyBusiness->filterCompany($data, $data['group'], $data['load'], [
            'field' => $data['field'],
            'sortBy' =>  $data['sortBy'],
            'showType' => $data['showType'],
        ]);

        // Check group type is exists if not set default is group company
        if ($data['group'] != config('company.group_company') && $data['group'] != config('company.group_service')) {
            $data['group'] = config('company.group_company');
        }

        // Check load result is exists if not set default is 10
        if (!in_array($data['load'], config('pagination.paginate_value'))) {
            $data['load'] = config('pagination.default');
        }

        // Render data result after filter
        $tableview = !$data['group']
            ? view('company.component.list.table-tbody-company', ['companies' => $companies])->render()
            : view('company.component.list.table-tbody-service', ['companies' => $companies])->render();

        // Render data pagination after filter
        $paginationView = view('company.component.paginate.default', [
            'paginator' => $companies,
            'url' => route('company.filter', $data) . '&page=',
        ])->render();

        return response()->json([
            'code' => Constant::HTTP_CODE_SUCCESS,
            'table' => $tableview,
            'paginate' => $paginationView,
            'typeRender' => 'filter',
        ]);
    }

    /**
     * Show page create company
     * @return view
     */
    public function create()
    {
        try {
            $data = $this->_companyBusiness->initCreateCompany();

            return view('company.create', [
                'companyOpe' => $data['companyOpe'],
                'nations' => $data['nations'],
                'currency' => $data['currency'],
                'billingMethod' => $data['billingMethod'],
                'shipTypes' => $data['shipTypes'],
                'classificationies' => $data['classificationies'],
            ]);
        } catch (\Exception $e) {
            abort(500);
        }
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Show page edit company
     * @param Type number id
     * @return view
     */
    public function edit($id)
    {
        return view('company.edit');
    }

    /**
     * Show popup detail grouping by company or service
     * @access public
     * @param Illuminate\Http\Request request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detail(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['code' => Constant::HTTP_CODE_ERROR_500]);
        }

        // Get all parameter
        $data = $request->all();

        // Get data detail by group company or group service
        $detailGroup = $this->_companyBusiness->getDetailGroup($request->id, empty($data['detail-type']) ? 0 : $data['detail-type']);

        // Check detail type exists if not set default is detail group company
        if (empty($data['detail-type']) || !$data['detail-type'] || $data['detail-type'] != 1) {
            $view = view('company.component.list.popup-detail-company', compact('detailGroup'))->render();
        } else {
            $view = view('company.component.list.popup-detail-service', compact('detailGroup'))->render();
        }

        return response()->json(['view' => $view, 'code' => Constant::HTTP_CODE_SUCCESS]);
    }

    /**
     * Show detail company
     * @param int id
     * @return view
     */
    public function show(Request $request, $id)
    {
        try {
            $data = $this->_companyBusiness->getDetailCompany($id);
        } catch (\Exception $e) {
            return abort('NotFound');
        }

        return view('company.detail', [
                'company' => $data['company'],
                'nation' => $data['nation'],
                'companyOperation' => $data['companyOperation'],
                'billingMethod' => $data['billingMethod'],
                'currency' => $data['currency'],
        ]);
    }

    /**
     * Function delete company
     * @param Illuminate\Http\Request request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(ConfirmPasswordRequest $request)
    {
        if (!$request->ajax()) {
            $this->returnJson(Constant::HTTP_CODE_ERROR_500, trans('error.500'));
        }

        \DB::beginTransaction();
        try {

            // Delete company
            $this->_companyBusiness->deleteCompany($request->get('company-id'));
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();

            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, [$e->getMessage()]);
        }

        return $this->returnJson(Constant::HTTP_CODE_SUCCESS);
    }

    /**
     * Function check name company
     *
     * @param Request $request
     * @return Response
     */
    public function checkName(Request $request)
    {
        if (!$request->ajax()) {
            return $this->returnJson(Constant::HTTP_CODE_SUCCESS, trans('error.500'));
        }

        $checkExists = $this->_companyBusiness->checkExistsByName($request->get('name'), $request->get('type'));

        return $this->returnJson(Constant::HTTP_CODE_SUCCESS, ['error' => [
                'status' => $checkExists,
            ]
        ]);
    }
}
