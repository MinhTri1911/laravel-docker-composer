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
use App\Common\Constant;

class MCurrencyRepository extends EloquentRepository implements MCurrencyInterface
{

    /**
     * Set model ship for interface
     *
     * @return string \App\Models\MCurrency
     */
    public function getModel()
    {
        return MCurrency::class;
    }

    /**
     * Select MCurrency by currency id
     * @access public
     * @param int $currency_id
     * @return mixed Illuminate\Support\Collection
     */
    public function getMCurrencyByCurrencyId($currency_id)
    {
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
    public function checkExits($currency_id)
    {
        return $this->_model->where('id', $currency_id)->exists();
    }

    /**
     * Function get all currency
     *
     * @param array $columns
     * @return Collection
     */
    public function getAllCurrency($columns = ['*'])
    {
        return $this->where('del_flag', Constant::DELETE_FLAG_FALSE)->get($columns);
    }

    /**
     * Function get currency by id or code
     *
     * @param int $id
     * @param string $code
     * @param array $columns
     * @return Collection
     */
    public function getCurrencyByIdOrCode($id, $code, $columns = ['*'])
    {
        return $this->select($columns)
            ->where('del_flag', Constant::DELETE_FLAG_FALSE)
            ->where(function ($query) use ($id) {
                if ($id) {
                    return $query->where('id', $id);
                }
            })
            ->where(function ($query) use ($code) {
                if ($code) {
                    return $query->where('code', 'LIKE', "%$code%");
                }
            })
            ->get();
    }
}
