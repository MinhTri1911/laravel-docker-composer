<?php

/**
 * Ship management Controller
 *
 * @package App\Http\Controllers
 * @author Rikkei.QuyenL
 * @date 2018/07/05
 */

namespace App\Http\Controllers;

use Exception;
use App\Common\Constant;
use App\Business\ShipBusiness;
use App\Http\Requests\ShipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ShipController CM_DD_SMB0001 ship management
 */
class ShipController extends Controller
{
    // Call roles trait to handel check permission
    use RolesController;

    /**
     * @var ShipBusiness
     */
    private $_shipBusiness;

    /**
     * ShipController constructor
     *
     * @param ShipBusiness $shipBusiness
     * @access public
     * @return void
     */
    public function __construct(ShipBusiness $shipBusiness)
    {
        $this->_shipBusiness = $shipBusiness;
    }

    /**
     * CM_DD_SMB0001 show list ship
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        // Check permission
        $this->checkPermission(Constant::ALLOW_SHIP_VIEW, Constant::IS_CHECK_SCREEN);

        // Get sort request data
        $data = [
            'companyId' => $request->get('company-id'),
            'field' => $request->get('field'),
            'orderBy' => $request->get('orderBy'),
            'perPage' => $request->get('load')
        ];

        // Handle and get list ship data
        $shipData = $this->_shipBusiness->getListShip($data['field'], $data['perPage'], $data['orderBy'], $data['companyId']);

        // Check ajax request
        if ($request->ajax()) {
            return response()->json([
                'code' => Constant::HTTP_CODE_SUCCESS,
                // Send list ship table data to view
                'table' => view('ship.component.list.table-data', ['ships' => $shipData]
                )->render(),
                'paginate' => view('ship.component.paginate', [
                    'pagination' => $shipData,
                    'url' => route('ship.index') . '?page=',
                    'companyId' => $data['companyId'],
                ])->render(),
                'perPage' => $request->get('load'),
            ]);
        }

        // Create view data
        $viewData = [
            'ships' => $shipData,
            'url' => route('ship.index') . '?page=',
            'companyId' => $data['companyId'],
            // Get back button route and send to view
            'backButton' => !$request->has('company-id')
                ? route('company.index')
                : route('company.show', ['id' => $data['companyId']])
        ];
        return view('ship.list', $viewData);
    }

    /**
     * Filter list ship by column and load filter result
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function filterShip(Request $request)
    {
        // Check permission
        $this->checkPermission(Constant::ALLOW_SHIP_VIEW, Constant::IS_CHECK_SCREEN);

        // Check ajax error request
        if (!$request->ajax()) {
            return response()->json(['code' => Constant::HTTP_CODE_ERROR_500]);
        }

        // Get data for filter
        $filters = $request->only([
            'filter-ship-name',
            'filter-company',
            'filter-classification',
            'filter-ship-type',
            'filter-imo-number',
            'filter-ship-nation',
            'filter-service-name'
        ]);

        // Set data field column to order by
        $filters['field'] = $request->get('field');
        $filters['orderBy'] = $request->get('orderBy');
        $filters['load'] = $request->get('load');
        $filters['companyId'] = $request->get('company-id');

        // Get data filter company
        $ships = $this->_shipBusiness->filterCompany($filters, $filters['load'],
            [
                'field' => $filters['field'],
                'orderBy' => $filters['orderBy'],
            ],
            $filters['companyId']
        );
        $ships->companyId = $filters['companyId'];

        // Check total record per page, if it not have set default it
        if (!in_array($filters['load'], Constant::ARY_PAGINATION_PER_PAGE)) {
            $data['load'] = Constant::PAGINATION_PER_PAGE;
        }

        // Render data result after filter
        $viewData = view('ship.component.list.table-data', ['ships' => $ships])->render();

        // Render data pagination after filter
        $paginationView = view('ship.component.paginate',
            [
                'pagination' => $ships,
                'url' => route('ship.filter', $filters) . '&page=',
                'companyId' => $filters['companyId'],
            ]
        )->render();

        return response()->json([
            'code' => Constant::HTTP_CODE_SUCCESS,
            'table' => $viewData,
            'paginate' => $paginationView,
        ]);
    }

    /**
     * Show create ship view
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCreate(Request $request)
    {
        // Check permission
        $this->checkPermission(Constant::ALLOW_SHIP_CREATE, Constant::IS_CHECK_SCREEN);

        // Initial create ship view data
        $companyId = $request->get('company-id');
        $viewData = $this->_shipBusiness->getViewData($companyId);

        return view('ship.create', compact('viewData'));
    }

    /**
     * Create ship
     *
     * @param ShipRequest $request
     * @return mixed
     */
    public function create(ShipRequest $request)
    {
        $this->checkPermission(Constant::ALLOW_SHIP_CREATE, Constant::IS_CHECK_SCREEN);

        // Get validated request data
        $validatedData = $request->validated();

        // Begin transaction
        DB::beginTransaction();

        try {
            // Insert ship
            $this->_shipBusiness->createShip($validatedData);
            DB::commit();

            // Redirect to list ship screen
            return redirect()->route('ship.index');

        } catch (Exception $e) {
            // Rollback the transaction
            DB::rollBack();

            // Redirect error page
            return abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0008']);
        }
    }

    /**
     * Check exist ship name or imo number
     *
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function checkExistCreateShipData(Request $request)
    {
        if ($request->ajax()) {
            // Get status
            $statusShipName = $this->_shipBusiness->checkExistShipName($request->get('shipName'));
            $statusImoNumber = $this->_shipBusiness->checkExistShipImoNumber($request->get('imoNumber'));

            $messages = [];
            if ($statusShipName === true) {
                $messages[] = trans('common-message.warning.W004', ['attribute' => trans('ship.lbl_title_ship_name')]);
            }

            if ($statusImoNumber === true) {
                $messages[] = trans('common-message.warning.W004', ['attribute' => trans('ship.lbl_title_imo_number')]);
            }

            return response()->json([
                'code' => Constant::HTTP_CODE_SUCCESS,
                'html' => !empty($messages)
                    ? $warningHtml = view('common.warning', ['warningMessages' => $messages])->render()
                    : ''
            ]);
        }

        return false;
    }

    /**
     * Check exist ship name or imo number
     *
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function checkExistEditShipData(Request $request)
    {
        if ($request->ajax()) {
            // Get status
            $statusShipName = $this->_shipBusiness->checkExistShipName($shipName = $request->get('shipName'));
            $statusImoNumber = $this->_shipBusiness->checkExistShipImoNumber($imoNumber = $request->get('imoNumber'));

            // Check exist ship id
            $ship = $this->_shipBusiness->getEditShipData($request->get('shipId'));
            if (!empty($ship)) {
                $messages = [];
                if ($ship->name == $shipName && $ship->imo_number == $imoNumber) {
                    $messages = '';
                } else {
                    if ($ship->name != $shipName) {
                        if ($statusShipName === true) {
                            $messages[] = trans(
                                'common-message.warning.W004',
                                ['attribute' => trans('ship.lbl_title_ship_name')]
                            );
                        }
                    }
                    if ($ship->imo_number != $imoNumber) {
                        if ($statusImoNumber === true) {
                            $messages[] = trans(
                                'common-message.warning.W004',
                                ['attribute' => trans('ship.lbl_title_imo_number')]
                            );
                        }
                    }
                }
                // Render html warning messages
                return response()->json([
                    'code' => Constant::HTTP_CODE_SUCCESS,
                    'html' => !empty($messages)
                        ? view('common.warning', ['warningMessages' => $messages])->render()
                        : ''
                ]);
            }

            // Return not found if ship id invalid
            return response()->json([
                'code' => Constant::HTTP_CODE_ERROR_404,
                'html' => ''
            ]);
        }

        return false;
    }

    /**
     * Show form edit Ship
     *
     * @param null|int $shipId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEdit($shipId = null)
    {
        // Check permission
        $this->checkPermission(Constant::ALLOW_SHIP_EDIT, Constant::IS_CHECK_SCREEN);

        // Get edit ship data by id
        $ship = $this->_shipBusiness->getEditShipData($shipId);

        if (!empty($ship)) {
            // Initial edit ship view data
            $viewData = $this->_shipBusiness->getViewData();
            $viewData['ship'] = $ship;

            return view('ship.edit', compact('viewData'));
        }

        return abort(Constant::HTTP_CODE_ERROR_404, trans('common-message.error.E001'));
    }

    /**
     * Handle edit ship by id
     *
     * @param null|int $shipId
     * @param ShipRequest $request
     * @return mixed \Illuminate\Http\RedirectResponse|void
     */
    public function edit($shipId = null, ShipRequest $request)
    {
        // Check permission
        $this->checkPermission(Constant::ALLOW_SHIP_EDIT, Constant::IS_CHECK_SCREEN);

        // Check exist ship id
        $ship = $this->_shipBusiness->getEditShipData($shipId);

        if (!empty($ship)) {
            $validatedData = $request->validated();
            DB::beginTransaction();

            try {
                // Update ship
                $this->_shipBusiness->updateShip($shipId, $validatedData);
                DB::commit();

                // Redirect to detail contract screen
                return redirect()->route('ship.contract.detail', ['id' => $shipId]);

            } catch (Exception $e) {
                // Rollback the transaction
                DB::rollBack();

                return abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0003']);
            }
        }

        return abort(Constant::HTTP_CODE_ERROR_404, trans('common-message.error.E001'));
    }
}
