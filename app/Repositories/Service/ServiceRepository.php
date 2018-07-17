<?php

/**
 * File company repository
 *
 * Handle eloquent query builder company
 * @package App\Repositories\Company
 * @author Rikkei.trihnm
 * @date 2018/06/19
 */

namespace App\Repositories\Service;

use App\Repositories\EloquentRepository;
use App\Models\MService;
use Illuminate\Support\Facades\DB;

class ServiceRepository extends EloquentRepository implements ServiceInterface {

    /**
     * Function get path model
     * @access public
     * @return string model
     */
    public function getModel() {
        return MService::class;
    }

    /**
     * Function get list service by currencyId
     * @access public
     * @param int currencyId
     * @return mixed
     */
    public function getListService($currencyId) {

        return DB::table('m_service')->select([
                            'm_service.id',
                            'm_service.name_jp',
                            't_price_service.charge_register',
                            't_price_service.charge_create_data'
                        ])
                        ->join('t_price_service', 't_price_service.service_id', 'm_service.id')
                        ->where('m_service.del_flag', 0)
                        ->where('t_price_service.del_flag', 0)
                        ->where('t_price_service.currency_id', $currencyId)
                        ->get();
    }

    /**
     * Function get list service by currencyId and ShipId
     * @access public
     * @param int currencyId
     * @param int shipId
     * @return mixed
     */
    public function getListServiceByShipId($currencyId, $shipId) {

        return DB::table('m_service')->select([
                            'm_service.id',
                            'm_service.name_jp',
                            't_price_service.charge_register',
                            't_price_service.charge_create_data'
                        ])
                        ->join('t_price_service', 't_price_service.service_id', 'm_service.id')
                        ->where('m_service.del_flag', 0)
                        ->where('t_price_service.del_flag', 0)
                        ->where('t_price_service.currency_id', $currencyId)
                        ->whereRaw("m_service.id NOT IN (SELECT m_contract.service_id FROM m_contract WHERE m_contract.ship_id =  ? )", [$shipId])
                        ->get();
    }

    /**
     * Function search list service
     * @access public
     * @param int currencyId
     * @param int shipId
     * @param int idServiceSearch
     * @param string nameServiceSearch
     * @return mixed
     */
    public function searchListService($currencyId, $shipId, $idServiceSearch, $nameServiceSearch) {

        if ($nameServiceSearch != null) {
            $nameServiceSearch = "%" . $nameServiceSearch . '%';
        }

        $query = DB::table('m_service')->select([
                    'm_service.id',
                    'm_service.name_jp',
                    't_price_service.charge_register',
                    't_price_service.charge_create_data'
                ])
                ->join('t_price_service', 't_price_service.service_id', 'm_service.id')
                ->where('m_service.del_flag', 0)
                ->where('t_price_service.del_flag', 0)
                ->where('t_price_service.currency_id', $currencyId);

        // Search by id service
        if ($idServiceSearch != null) {
            $query = $query->where('m_service.id', $idServiceSearch);
        }

        // Search by name service 
        if ($nameServiceSearch != null) {
            $query = $query->whereRaw("m_service.name_jp  LIKE ? ", [$nameServiceSearch]);
        }

        // Search by shipId
        if ($shipId != null || $shipId != '') {
            $query = $query->whereRaw("m_service.id NOT IN (SELECT m_contract.service_id FROM m_contract WHERE m_contract.ship_id =  ? )", [$shipId]);
        }

        return $query->get();
    }

    /**
     * Function check exits service by idService
     * @access public
     * @param int $idService
     * @return boolen
     */
    public function checkExits($idService) {
        return $this->_model->where('id', $idService)->exists();
    }
}
