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
        // 1.3 init list company
        $companies = $this->companyBusiness->initListCompany();

        // paginate ajax
        if ($request->ajax()) {
            return response()->json([
                'code' => 200,
                'table' => view('company.component.list.table-tbody-company', ['companies' => $companies])->render(),
                'paginate' => view('company.component.paginate.default', ['paginator' => $companies, 'type' => 0])->render(),
            ]);
        }

        return view('company.list', compact('companies'));
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

        $data = $request->only('group', 'load');
        // 2 search company
        $companies = $this->companyBusiness->searchCompany($data['group'], $data['load']);

        if ($data['group'] != config('company.group_company') && $data['group'] != config('company.group_service')) {
            $data['group'] = config('company.group_company');
        }

        if (!in_array($data['load'], config('pagination.paginate_value'))) {
            $data['load'] = config('pagination.default');
        }

        $tableview = !$data['group']
            ? view('company.component.list.table-group-company', ['companies' => $companies])->render()
            : view('company.component.list.table-group-service', ['companies' => $companies])->render();
        $paginationView = view('company.component.paginate.default', ['paginator' => $companies, 'type' => 0])->render();

        return response()->json([
            'code' => 200,
            'table' => $tableview,
            'paginate' => $paginationView,
        ]);
    }

    /**
     *
     */
    public function filterCompany(Request $request)
    {
        // if (!$request->ajax()) {
        //     return response()->json(['code' => 500]);
        // }

        $data = $request->only([
            'group-type',
            'paginate-record',
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

        // 2 search company
        $companies = $this->companyBusiness->filterCompany($data, $data['group-type'], $data['paginate-record']);

        if ($data['group-type'] != config('company.group_company') && $data['group-type'] != config('company.group_service')) {
            $data['group-type'] = config('company.group_company');
        }

        if (!in_array($data['paginate-record'], config('pagination.paginate_value'))) {
            $data['paginate-record'] = config('pagination.default');
        }

        $tableview = !$data['group-type']
            ? view('company.component.list.table-tbody-company', ['companies' => $companies])->render()
            : view('company.component.list.table-tbody-service', ['companies' => $companies])->render();
        $url = route('company.filter', $data) . '&page=';
        $paginationView = view('company.component.paginate.default', ['paginator' => $companies, 'url' => $url, 'type' => 1])->render();

        return response()->json([
            'code' => 200,
            'table' => $tableview,
            'paginate' => $paginationView,
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
