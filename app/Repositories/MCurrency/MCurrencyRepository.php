<?php

/**
 * Spot management Repository
 *
 * @package App\Repositories\Spot
 * @author Rikkei.DatPDT
 * @date 2018/07/19
 */

namespace App\Repositories\MCurrency;

use App\Repositories\EloquentRepository;
use App\Models\MCurrency;
use Illuminate\Support\Facades\DB;

class MCurrencyRepository extends EloquentRepository implements MCurrencyInterface 
{

    /**
     * Set model ship for interface
     *
     * @return string \App\Models\MCurrency
     */
    public function getModel() {
        return MCurrency::class;
    }

    /**
     * Select MCurrency by currency id
     * @access public
     * @param int $currency_id
     * @return mixed Illuminate\Support\Collection
     */
    public function getMCurrencyByCurrencyId($currency_id) {

        return DB::table('m_currency')->select([
                            'm_currency.code'
                        ])
                        ->where('m_currency.id', $currency_id)
                        ->where('m_currency.del_flag', 0)
                        ->first();
    }
    
    /**
     * Function check exits currency by currency id
     * @access public
     * @param int $currency_id
     * @return boolen
    */
    public function checkExits($currency_id) {
        return $this->_model->where('id', $currency_id)->exists();
    }
}
