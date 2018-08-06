<?php

/**
 * File contract business
 *
 * Handle business related to spot
 * @package App\Business
 * @author Rikkei.DatPDT
 * @date 2018/07/10
 */

namespace App\Business;

use App\Repositories\Ship\ShipInterface;
use App\Repositories\MSpot\MSpotInterface;
use App\Repositories\MCurrency\MCurrencyInterface;
use App\Repositories\TShipSpot\TShipSpotInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Common\Constant;
use App\Traits\CommonArray;

class SpotBusiness
{
    use CommonArray;

    protected $_shipInterface;
    protected $_mSpotInterface;
    protected $_mCurrency;
    protected $_tShipSpotInterface;

    public function __construct(
        ShipInterface $shipInterface,
        MSpotInterface $mSpotInterface,
        MCurrencyInterface $mCurrency,
        TShipSpotInterface $tShipSpotInterface
    )
    {
        $this->_shipInterface = $shipInterface;
        $this->_mSpotInterface = $mSpotInterface;
        $this->_mCurrency = $mCurrency;
        $this->_tShipSpotInterface = $tShipSpotInterface;
    }

    /**
     * Business create spot
     * @access public
     * @param array request
     * @return true/false
     */
    public function createSpot($request)
    {
        try {
            DB::beginTransaction();
            $date = substr($request->dateStart, 0, 8) . '01';
            $data = [];
            $data['ship_id'] = $request->shipId;
            $data['spot_id'] = $request->spotId;
            $data['month_usage'] = str_replace('/', '-', $date);
            $data['amount_charge'] = $request->amountCharge;
            $data['currency_id'] = $request->currencyId;
            $data['remark'] = $request->remark;
            $this->_tShipSpotInterface->createTShipSpotByCurrencyId($data);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            Log::info($ex);
            DB::rollBack();
            return false;
        }
    }

    /**
     * Business init create
     * @access public
     * @param int idShip
     * @return mixed Illuminate\Support\Collection
     */
    public function initCreate($idShip)
    {
        try {
            $data['ship'] = $this->_shipInterface->getIdShip($idShip);
            if ($data['ship'] == null) {
                return abort(Constant::HTTP_CODE_ERROR_404);
            }
            $currency_id = $data['ship']->currency_id;
            $data['spotName'] = $this->_mSpotInterface->getMSpotByCurrencyId($currency_id);
            if ($data['spotName'] == null) {
                return abort(Constant::HTTP_CODE_ERROR_404);
            }
            $data['spotNameSelect'] = array_column($data['spotName']->toArray(), 'name_jp', 'id');
            $data['amountCharge'] = $data['spotName'][0]->charge . '.00';
            $data['currencyCode'] = $this->_mCurrency->getMCurrencyByCurrencyId($currency_id);
            return $data;
        } catch (Exception $ex) {
            Log::info($ex);
            return abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0009']);
        }
    }

    /**
     * Business get amount charge
     * @access public
     * @param int idShip
     * @param int currency_id
     * @return mixed Illuminate\Support\Collection
     */
    public function getCharge($currency_id, $spot_id)
    {
        try {
            $amountCharge = $this->_mSpotInterface->getCharge($currency_id, $spot_id);
            return $amountCharge->charge;
        } catch (Exception $ex) {
            Log::info($ex);
            return abort(Constant::HTTP_CODE_ERROR_500, Constant::ID_SCREEN['SMB0009']);
        }
    }

    /**
     * Function check exists spot with currency
     * @param int companyId
     * @param array spotIds
     * @return boolean
     */
    public function checkExistsSpotWithCurrency($companyId, $spotIds)
    {
        // Check company is int and spot is array
        if (!is_numeric($companyId) || !is_array($spotIds)) {
            return false;
        }

        if (empty($spotIds)) {
            return true;
        }

        $spots = $this->_mSpotInterface->getExistsSpotTypeWithCurrency($companyId, [
            Constant::SPOT_TYPE_CREATE_DATA, Constant::SPOT_TYPE_REGISTER
        ], ['m_spot.id']);
        $spotsExists = array_column($spots->toArray(), 'id');

        return $this->checkArrayExists($spotIds, $spotsExists);
    }

    /**
     * Get edit spot data
     *
     * @param int $spotId
     * @return array
     */
    public function getEditShipSpotData($spotId)
    {
        return $this->_tShipSpotInterface->getEditShipSpotData($spotId);
    }

    /**
     * Update ship spot
     *
     * @param mixed $shipSpot Laravel collection
     * @param mixed $request
     * @return bool
     */
    public function updateShipSpot($shipSpot, $request)
    {
        $updateData = $this->_getUpdateSpotData($shipSpot, $request);

        return $this->_tShipSpotInterface->updateShipSpot($shipSpot->id, $updateData);
    }

    /**
     * Get update ship spot data
     *
     * @access private
     * @param mixed $shipSpot
     * @param array $request
     * @return array
     */
    private function _getUpdateSpotData($shipSpot, $request)
    {
        $date = substr($request->dateStart, 0, 8) . '01'; // TODO need check

        $rejectReason = [
            'spot_id' => $request->spotId,
            'month_usage' => str_replace('/', '-', $date),
            'amount_charge' => str_replace(',', '', $request->amountCharge),
            'remark' => $request->remark,
            'spot_name' => $request->spotName,
            'updated_by' => auth()->id(),
            'updated_by_name' => auth()->user()->name
        ];

        return [
            'reason_reject' => json_encode($rejectReason),
            'approved_flag' => Constant::STATUS_WAITING_APPROVE,
            'updated_at' => $this->_getUpdatedAt($shipSpot),
            'updated_by' => auth()->id()
        ];
    }

    /**
     * Get update at date time
     *
     * @param mixed $shipSpot
     * @return false|null|string
     */
    private function _getUpdatedAt($shipSpot)
    {
        if ($shipSpot->approved_flag === Constant::STATUS_REJECT_APPROVE && $shipSpot->updated_at === null) {
            return null;
        }

        return date('Y-m-d H:i:s');
    }
}
