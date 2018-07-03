<?php
/**
* File Company controller
*
* @package App\Http\Controllers
* @author tri_hnm
* @date 2018/06/19
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\CompanyBusiness;

class CompanyController extends Controller
{
    private $companyBusiness;

    /**
     * Function construct
     * @return void
     */
    public function __construct(CompanyBusiness $companyBusiness)
    {
        $this->companyBusiness = $companyBusiness;
    }

    /**
     * Show list company
     * @return view
     */
    public function index(Request $request)
    {
        // get data for SMA0001 sheet define handle index => 3 sort data
        $data = [
            'field' => $request->field,
            'sortBy' => $request->sortBy,
        ];
        // SMA0001 sheet define handle index => 1.3 init list company
        $companies = $this->companyBusiness->initListCompany($data['field'], $data['sortBy']);

        // SMA0001 sheet define handle index => 1.3 init list company paginate ajax
        if ($request->ajax()) {
            return response()->json([
                'code' => 200,
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
     * @param Illuminate\Http\Request request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchCompany(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['code' => 500]);
        }

        $data = [
            'group' => $request->group,
            'load' => $request->load,
            'field' => $request->field,
            'sortBy' => $request->sortBy,
        ];
        // SMA0001 sheet define  handle index => 2 search company
        $companies = $this->companyBusiness->searchCompany($data['group'], $data['load'], $data['field'], $data['sortBy']);

        if ($data['group'] != config('company.group_company') && $data['group'] != config('company.group_service')) {
            $data['group'] = config('company.group_company');
        }

        if (!in_array($data['load'], config('pagination.paginate_value'))) {
            $data['load'] = config('pagination.default');
        }

        $tableview = !$data['group']
            ? view('company.component.list.table-group-company', ['companies' => $companies])->render()
            : view('company.component.list.table-group-service', ['companies' => $companies])->render();
        // SMA0001 sheet define  handle index => 2 search company pagination
        $paginationView = view('company.component.paginate.default', [
            'paginator' => $companies,
            'url' => route('company.search', $data) . '&page=',
        ])->render();

        return response()->json([
            'code' => 200,
            'table' => $tableview,
            'paginate' => $paginationView,
            'typeRender' => 'search',
        ]);
    }

    /**
     * Filter list company by group and load result
     * @param Illuminate\Http\Request request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filterCompany(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['code' => 500]);
        }

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

        $data['field'] = $request->field;
        $data['sortBy'] = $request->sortBy;
        $data['group'] = $request->group;
        $data['load'] = $request->load;

        // SMA0001 sheet define  handle index => 2 filter company
        $companies = $this->companyBusiness->filterCompany($data, $data['group'], $data['load'], [
            'field' => $data['field'],
            'sortBy' =>  $data['sortBy'],
        ]);

        if ($data['group'] != config('company.group_company') && $data['group'] != config('company.group_service')) {
            $data['group'] = config('company.group_company');
        }

        if (!in_array($data['load'], config('pagination.paginate_value'))) {
            $data['load'] = config('pagination.default');
        }

        $tableview = !$data['group']
            ? view('company.component.list.table-tbody-company', ['companies' => $companies])->render()
            : view('company.component.list.table-tbody-service', ['companies' => $companies])->render();
        // SMA0001 sheet define  handle index => 6 filter company pagination
        $paginationView = view('company.component.paginate.default', [
            'paginator' => $companies,
            'url' => route('company.filter', $data) . '&page=',
        ])->render();

        return response()->json([
            'code' => 200,
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
        return view('company.create');
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
     * @param Illuminate\Http\Request request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detail(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['code' => 500]);
        }

        $data = $request->all();

        if (empty($data['detail-type']) || $data['detail-type'] == 0) {
            $view = view('company.component.list.popup-detail-company')->render();
        } else {
            $view = view('company.component.list.popup-detail-service')->render();
        }

        return response()->json(['view' => $view, 'code' => 200]);
    }

    /**
     * Show detail company
     * @param int id
     * @return view
     */

    public function show(Request $request, $id)
    {
        return view('company.detail');
    }

    /**
     * Show popup setting billing method
     * @param Illuminate\Http\Request request
     * @param Type number id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPopupSettingBillingMethod(Request $request, $id)
    {
        if (!$request->ajax()) {
            return response()->json(['code' => 500]);
        }

        $view = view('company.component.detail.popup-setting-billing-method')->render();

        return response()->json([
            'code' => 200,
            'view' => $view,
        ]);
    }

    /**
     * Show popup add service for all ship
     * @param Illuminate\Http\Request request
     * @param Type number id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPopupAddServiceForAllShip(Request $request, $id)
    {
        if (!$request->ajax()) {
            return response()->json(['code' => 500]);
        }

        $view = view('company.component.detail.popup-add-service-for-all-ship')->render();

        return response()->json([
            'code' => 200,
            'view' => $view,
        ]);
    }

    /**
     * Show popup delete service in all ship
     * @param Illuminate\Http\Request request
     * @param Type number id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPopupDeleteServiceInAllShip(Request $request, $id)
    {
        if (!$request->ajax()) {
            return response()->json(['code' => 500]);
        }

        $view = view('company.component.detail.popup-delete-service-in-all-ship')->render();

        return response()->json([
            'code' => 200,
            'view' => $view,
        ]);
    }

    /**
     * Show popup confirm delete service in all ship
     * @param Illuminate\Http\Request request
     * @param Type var serviceName
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPopupConfirmDeleteServiceInAllShip(Request $request, $serviceName)
    {
        if (!$request->ajax()) {
            return response()->json(['code' => 500]);
        }

        $view = view('company.component.detail.popup-confirm-delete-service-in-all-ship', compact('serviceName'))->render();

        return response()->json([
            'code' => 200,
            'view' => $view,
        ]);
    }
}
