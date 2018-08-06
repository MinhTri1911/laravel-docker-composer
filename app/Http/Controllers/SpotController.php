<?php

/**
 * File Spot controller
 *
 * @package App\Http\Controllers
 * @author Rikkei.DatPDT
 * @date 2018/07/19
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\SpotBusiness;
use App\Business\ShipBusiness;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Requests\SpotRequest;
use App\Http\Requests\SpotUpdateRequest;
use App\Common\Constant;

/**
 * Class SpotController
 */
class SpotController extends Controller
{
    /**
     * SpotBusiness
     *
     * @var $_spotBusiness
     */
    private $_spotBusiness;

    /**
     * ShipBusiness
     *
     * @var $_shipBusiness
     */
    private $_shipBusiness;

    /**
     * SpotController constructor.
     *
     * @param SpotBusiness $spotBusiness
     * @param ShipBusiness $shipBusiness
     */
    public function __construct(SpotBusiness $spotBusiness, ShipBusiness $shipBusiness)
    {
        $this->_spotBusiness = $spotBusiness;
        $this->_shipBusiness = $shipBusiness;
    }

    /**
     * Show page init create spot
     *
     * @param string|int $idShip
     * @return mixed \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function initCreate($idShip = '')
    {
        try {
            $data = $this->_spotBusiness->initCreate($idShip);
            return view('spot.create', $data);
        } catch (Exception $ex) {
            Log::info($ex);
            return abort('NotFound');
        }
    }

    /**
     * Ajax search amount  by idSpot
     *
     * @param Request $request
     * @return mixed amountCharge
     */
    public function searchAmount(Request $request)
    {
        try {
            $currency_id = $request->get('currencyId');
            $spot_id = $request->get('spotId');
            return $this->_spotBusiness->getCharge($currency_id, $spot_id);
        } catch (Exception $ex) {
            Log::info($ex);
            return abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0009']);
        }
    }

    /**
     * Handel create spot
     *
     * @param SpotRequest $request
     * @return mixed \Illuminate\Http\RedirectResponse|void
     */
    public function create(SpotRequest $request)
    {
        try {
            $isCreate = $this->_spotBusiness->createSpot($request);
            if ($isCreate) {
                return redirect()->route('ship.contract.detail', $request->shipId);
            }
            return abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0009']);
        } catch (Exception $ex) {
            Log::info($ex);
            return abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0009']);
        }
    }

    /**
     * Show edit spot view
     *
     * @param null|int $shipId
     * @param null|int $spotId
     * @return mixed \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEdit($shipId = null, $spotId = null)
    {
        // Check exist ship and spot id
        $ship = $this->_shipBusiness->getEditShipData($shipId);
        $shipSpot = $this->_spotBusiness->getEditShipSpotData($spotId);

        if (!empty($ship) && !empty($shipSpot)) {
            $data = $this->_spotBusiness->initCreate($shipId);
            $data['spot'] = $shipSpot;

            return view('spot.edit', $data);
        }

        return abort(Constant::HTTP_CODE_ERROR_404, trans('common-message.error.E001'));
    }

    /**
     * Update spot data
     *
     * @param null|int $shipId
     * @param null|int $shipSpotId
     * @param SpotUpdateRequest $request
     * @return mixed \Illuminate\Http\RedirectResponse|void
     */
    public function edit($shipId = null, $shipSpotId = null, SpotUpdateRequest $request)
    {
        // Check exist ship and spot id
        $ship = $this->_shipBusiness->getEditShipData($shipId);
        $shipSpot = $this->_spotBusiness->getEditShipSpotData($shipSpotId);

        if (!empty($ship) && !empty($shipSpot)) {
            DB::beginTransaction();

            try {
                // Update spot
                $this->_spotBusiness->updateShipSpot($shipSpot, $request);
                DB::commit();

                // Redirect to contract detail screen
                return redirect()->route('ship.contract.detail', ['id' => $shipId]);

            } catch (Exception $e) {
                // Rollback the transaction
                DB::rollBack();

                return abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0010']);
            }
        }

        return abort(Constant::HTTP_CODE_ERROR_404, trans('common-message.error.E001'));
    }
}
