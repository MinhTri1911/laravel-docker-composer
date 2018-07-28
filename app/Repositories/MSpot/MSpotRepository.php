<?php

/**
 * Spot management Repository
 *
 * @package App\Repositories\Spot
 * @author Rikkei.DatPDT
 * @date 2018/07/19
 */

namespace App\Repositories\MSpot;

use App\Repositories\EloquentRepository;
use App\Models\MSpot;
use Illuminate\Support\Facades\DB;
use App\Common\Constant;

class MSpotRepository extends EloquentRepository implements MSpotInterface
{
    /**
     * Set model ship for interface
     *
     * @return string \App\Models\MSpot
     */
    public function getModel() {
        return MSpot::class;
    }

    /**
     * Select MSpot by currency id
     * @access public
     * @param int $currency_id
     * @return mixed Illuminate\Support\Collection
     */
    public function getMSpotByCurrencyId($currency_id) {
        return DB::table('m_spot')->select([
                'm_spot.id',
                'm_spot.name_en',
                'm_spot.name_jp',
                'm_spot.charge'
            ])
            ->where('m_spot.del_flag', 0)
            ->where('m_spot.currency_id', $currency_id)
            ->get();
    }

    /**
     * Select charge by spot id and currency id
     * @access public
     * @param int $currency_id
     * @param int $spot_id
     * @return mixed Illuminate\Support\Collection
     */
    public function getCharge($currency_id, $spot_id) {

        return DB::table('m_spot')->select([
                'm_spot.charge'
            ])
            ->where('m_spot.del_flag', 0)
            ->where('m_spot.currency_id', $currency_id)
            ->where('m_spot.id', $spot_id)
            ->first();
    }

    /**
     * Function check exits spot by $spot_id
     * @access public
     * @param int $spot_id
     * @return boolen
    */
    public function checkExits($spot_id) {
        return $this->_model->where('id', $spot_id)->exists();
    }

    /**
     * Function get exists spot with same currency with company
     * @param int $companyId
     * @param array $types
     * @param array $columns
     * @return Collection
     */
    public function getExistsSpotTypeWithCurrency(
        $companyId,
        $types = [Constant::SPOT_TYPE_REGISTER, Constant::SPOT_TYPE_CREATE_DATA],
        $columns = ['*']
    ) {
        return $this->select($columns)
            ->join('m_company', 'm_company.currency_id', 'm_spot.currency_id')
            ->where('m_company.id', $companyId)
            ->whereIn('type', $types)
            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE)
            ->where('m_spot.del_flag', Constant::DELETE_FLAG_FALSE)
            ->get();
    }
}
