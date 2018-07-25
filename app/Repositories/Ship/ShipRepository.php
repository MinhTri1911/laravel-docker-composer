<?php

/**
 * Ship management Repository
 *
 * @package App\Repositories\Ship
 * @author Rikkei.QuyenL
 * @date 2018/07/05
 */

namespace App\Repositories\Ship;

use App\Repositories\EloquentRepository;
use App\Models\MShip;
use Illuminate\Support\Facades\DB;
use App\Common\Constant;

class ShipRepository extends EloquentRepository implements ShipInterface
{
    /**
     * Set model ship for interface
     *
     * @return string \App\Models\MShip
     */
    public function getModel()
    {
        return MShip::class;
    }

    /**
     * Get detail ship by id
     *
     * @access public
     * @param int $idShip
     * @return mixed Illuminate\Support\Collection
     */
    public function getShip($idShip = null, $param = [])
    {
        // Check exists param id ship
        $queryShip = DB::table('m_ship')
                ->join('m_company', function($join) {
                    if (isset($param['company']) && count($param['company']) > 0) {
                        $join->on('m_ship.company_id', '=', 'm_company.id')
                            ->whereIn('m_company.id', $param['company'])
                            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE);
                    } else {
                        $join->on('m_ship.company_id', '=', 'm_company.id')
                            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE);
                    }
                })
                ->join('m_nation', function($join) {
                    $join->on('m_ship.nation_id', '=', 'm_nation.id')
                            ->where('m_nation.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_currency', function($join) {
                    $join->on('m_company.currency_id', '=', 'm_currency.id')
                            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_ship_classification', function($join) {
                    $join->on('m_ship.classification_id', '=', 'm_ship_classification.id')
                            ->where('m_ship_classification.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_ship_type', function($join) {
                    $join->on('m_ship.type_id', '=', 'm_ship_type.id')
                            ->where('m_ship_type.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->select([
                    "m_ship.id as ship_id",
                    "m_ship.name as ship_name",
                    "m_ship.imo_number as ship_imo_number",
                    "m_ship.mmsi_number as ship_mmsi_number",
                    "m_ship.register_number as ship_register_number",
                    "m_ship.width as ship_width",
                    "m_ship.height as ship_height",
                    "m_ship.water_draft as ship_water_draft",
                    "m_ship.total_weight_ton as ship_total_weight_ton",
                    "m_ship.total_ton as ship_weight_ton",
                    "m_ship.member_number as ship_member_number",
                    "m_ship.remark as ship_remark",
                    "m_ship.url_1 as ship_url_1",
                    "m_ship.url_2 as ship_url_2",
                    "m_ship.url_3 as ship_url_3",
                    "m_company.name_jp as company_name",
                    "m_nation.name_jp as nation_name",
                    "m_ship_classification.name_jp as ship_classify",
                    "m_ship_type.type as ship_type"
                ])
                ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE);

        if (empty($idShip) || is_null($idShip)) {
            return $queryShip->get();
        }

        return $queryShip->where([
                            'm_ship.id' => $idShip
                        ])
                        ->first();
    }

    /**
     * Get contract of ship
     *
     * @access public
     * @param int $idShip
     * @param int|array $idContract
     * @return mixed Illuminate\Support\Collection
     */
    public function getContract($idShip = null, $idContract = '')
    {
        // Query get contract
        $contract = DB::table('m_contract')
                ->join('m_ship', function($join) {
                    $join->on('m_ship.id', '=', 'm_contract.ship_id')
                    ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_service', function($join) {
                    $join->on('m_service.id', '=', 'm_contract.service_id')
                    ->where('m_service.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->select([
                    "m_contract.id as contract_id",
                    "m_contract.revision_number as contract_revision_number",
                    "m_contract.start_date as contract_date_start",
                    "m_contract.end_date as contract_date_end",
                    "m_contract.status as contract_status",
                    "m_contract.approved_flag as contract_approved_flag",
                    "m_contract.reason_reject as contract_reason_reject",
                    "m_contract.created_at as contract_created_at",
                    "m_contract.updated_at as contract_updated_at",
                    "m_contract.approved_flag as contract_approved_flag",
                    "m_service.id as service_id",
                    "m_service.name_jp as service_name",
                ])
                ->whereIn('approved_flag', [
                    Constant::STATUS_APPROVED,
                    Constant::STATUS_WAITING_APPROVE,
                    Constant::STATUS_REJECT_APPROVE]);

        // Check if get all contract inside all ship
        if (empty($idShip) || is_null($idShip)) {
            if (!empty($idContract) && !is_null($idContract)) {
                if (is_array($idContract))
                    return $contract
                                    ->whereIn('m_contract.id', $idContract)
                                    ->get();
                return $contract
                                ->where('m_contract.id', $idContract)
                                ->first();
            }

            return $contract->get();
        }

        // If get contract inside a ship
        if (!empty($idContract) && !is_null($idContract)) {
            if (is_array($idContract))
                return $contract
                                ->whereIn('m_contract.id', $idContract)
                                ->where('m_ship.id', $idShip)
                                ->get();
            return $contract
                            ->where('m_contract.id', $idContract)
                            ->where('m_ship.id', $idShip)
                            ->first();
        }

        return $contract
                        ->where('m_ship.id', $idShip)
                        ->get();
    }

    /**
     * Get contract activating of ship
     *
     * @access public
     * @param int $idShip
     * @param array $idContract
     * @return mixed Illuminate\Support\Collection
     */
    public function getContractActive($idShip = null, $idContract = [])
    {
        // Query get contract
        $contract = DB::table('m_contract')
                ->join('m_ship', function($join) {
                    $join->on('m_ship.id', '=', 'm_contract.ship_id')
                    ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_service', function($join) {
                    $join->on('m_service.id', '=', 'm_contract.service_id')
                    ->where('m_service.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->select([
                    "m_contract.id as contract_id",
                    "m_contract.revision_number as contract_revision_number",
                    "m_contract.start_date as contract_date_start",
                    "m_contract.end_date as contract_date_end",
                    "m_contract.status as contract_status",
                    "m_contract.approved_flag as contract_approved_flag",
                    "m_contract.created_at as contract_created_at",
                    "m_contract.updated_at as contract_updated_at",
                    "m_service.id as service_id",
                    "m_service.name_jp as service_name",
                ])
                ->whereIn('approved_flag', [Constant::STATUS_APPROVED, Constant::STATUS_WAITING_APPROVE, Constant::STATUS_REJECT_APPROVE])
                ->whereIn('status', [Constant::STATUS_CONTRACT_ACTIVE, Constant::STATUS_CONTRACT_PENDING]);

        // Check if get all contract inside all ship
        if (empty($idShip) || is_null($idShip)) {
            if (!empty($idContract) && !is_null($idContract)) {
                return $contract
                                ->whereIn('m_contract.id', $idContract)
                                ->get();
            }

            return $contract->get();
        }

        // If get contract inside a ship
        if (!empty($idContract) && !is_null($idContract)) {
            return $contract
                            ->whereIn('m_contract.id', $idContract)
                            ->where('m_ship.id', $idShip)
                            ->get();
        }

        return $contract
                        ->where('m_ship.id', $idShip)
                        ->get();
    }

    /**
     * Handle Update contract base on ID and Data update
     *
     * @access public
     * @param int|array $id
     * @param array $data
     */
    public function updateContract($id, $data) {
        if(is_null($id) || is_null($data)) {
            return false;
        }

        if (is_array($id)) {
            return DB::table('m_contract')
                ->whereIn('id', $id)
                ->update($data);
        }

        return DB::table('m_contract')
                ->where('id', $id)
                ->update($data);
    }

    /**
     * Get spot of ship by id ship
     *
     * @access public
     * @param int $idShip
     * @param int $idSpot
     * @return mixed Illuminate\Support\Collection
     */
    public function getSpot($idShip = null, $idSpot = null, $limit = null) {
        $spot = DB::table('t_ship_spot')
                ->join('m_ship', function($join) use ($idShip) {
                    $join->on('m_ship.id', '=', 't_ship_spot.ship_id')
                    ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_spot', function($join) {
                    $join->on('m_spot.id', '=', 't_ship_spot.spot_id')
                    ->where('m_spot.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->select([
                    "t_ship_spot.id as spot_id",
                    "m_spot.name_jp as spot_name",
                    "m_spot.charge as spot_master_charge",
                    "t_ship_spot.month_usage as spot_month_usage",
                    "t_ship_spot.amount_charge as spot_amount_charge",
                    "t_ship_spot.approved_flag as spot_approved_flag",
                    "t_ship_spot.reason_reject as spot_reason_reject",
                    "t_ship_spot.created_at as spot_created_at",
                    "t_ship_spot.updated_at as spot_updated_at",
                ])
                ->where('t_ship_spot.del_flag', Constant::DELETE_FLAG_FALSE);

        // Check exists param id ship
        if (empty($idShip) || is_null($idShip)) {
            if (!empty($idSpot) && !is_null($idSpot))
                return $spot->where(['t_ship_spot.id' => $idSpot])->first();

            if (!is_null($limit)) {
                return $spot->paginate($limit);
            }
            return $spot->get();
        }

        if (!empty($idSpot) && !is_null($idSpot))
            return $spot->where([
                                't_ship_spot.id' => $idSpot,
                                'm_ship.id' => $idShip])
                            ->first();
        if (!is_null($limit)) {
            return $spot->where('m_ship.id', $idShip)->paginate($limit);
        }

        return $spot->get();
    }

    /**
     * Function get common list ship query
     *
     * @param int $companyId default null
     * @return mixed Illuminate\Support\Collection
     */
    public function getCommonListShipQuery($companyId = null)
    {
        $query = $this->select([
            'm_ship.id',
            'm_ship.name',
            'm_ship_type.type',
            'm_ship.imo_number',
            'm_nation.name_jp AS nation_name_jp',
            'm_nation.name_en AS nation_name_en',
            'm_service.name_jp AS service_name_jp',
            'm_service.name_en AS service_name_en',
            'm_ship_classification.name_jp AS ship_classification_name_jp',
            'm_ship_classification.name_en AS ship_classification_name_en',
            'm_company.name_jp AS company_name_jp',
            'm_company.name_en AS company_name_en',
            'm_contract.status',
            'm_contract.approved_flag'
        ])
            // Left join with m_contract
            ->leftJoin('m_contract', 'm_contract.ship_id', '=', 'm_ship.id')

            // Left join with m_service
            ->leftJoin('m_service', 'm_contract.service_id', '=', 'm_service.id')

            // Inner join with m_ship_type
            ->join('m_ship_type', 'm_ship.type_id', '=', 'm_ship_type.id')

            // Inner join with m_company
            ->join('m_company', 'm_ship.company_id', '=', 'm_company.id')

            // Inner join with m_ship_classification
            ->join('m_ship_classification', 'm_ship.classification_id', '=', 'm_ship_classification.id')

            // Inner join with m_nation
            ->join('m_nation', 'm_nation.id', '=', 'm_ship.nation_id')

            // Conditions
            ->where('m_ship.del_flag', 0)
            ->where('m_company.del_flag', 0)
            ->where(function ($query) {
                $query->where('m_service.del_flag', 0)
                    ->orWhereNull('m_contract.id');
            });

        // 1.4 Initial list ship when access from detail company
        if (!empty($companyId)) {
            $query->where('m_ship.company_id', $companyId);
        }

        return $query;
    }

    /**
     * Function make condition for search company
     *
     * @param array $param filter keyword conditions
     * @return mixed Illuminate\Support\Collection
     */
    public function conditionSearchShip($param)
    {
        return $this->where(function ($query) use ($param) {
            // Filer by ship name
            return $query->where('m_ship.name', 'LIKE', '%' . $param['filter-ship-name'] . '%');
        })
            // Filter by company name JP or company name ENG
            ->where(function ($query) use ($param) {
                return $query->where('m_company.name_jp', 'LIKE', '%' . $param['filter-company'] . '%')
                    ->orWhere('m_company.name_en', 'LIKE', '%' . $param['filter-company'] . '%');
            })

            // Filter by ship classification name
            ->where(function ($query) use ($param) {
                return $query->where('m_ship_classification.name_jp', 'LIKE', '%' . $param['filter-classification'] . '%')
                    ->orWhere('m_ship_classification.name_en', 'LIKE', '%' . $param['filter-classification'] . '%');
            })

            // Filter by type of ship
            ->where('m_ship_type.type', 'LIKE', '%' . $param['filter-ship-type'] . '%')

            // Filter by type of ship
            ->where('m_ship.imo_number', 'LIKE', '%' . $param['filter-imo-number'] . '%')

            // Filter by ship nation name
            ->where(function ($query) use ($param) {
                return $query->where('m_nation.name_jp', 'LIKE', '%' . $param['filter-ship-nation'] . '%')
                    ->orWhere('m_nation.name_en', 'LIKE', '%' . $param['filter-ship-nation'] . '%');
            })

            // Filter by service name
            ->where(function ($query) use ($param) {
                return $query->where('m_service.name_jp', 'LIKE', '%' . $param['filter-service-name'] . '%')
                    ->orWhere('m_service.name_en', 'LIKE', '%' . $param['filter-service-name'] . '%');
            });
    }

    /**
     * Function get list ship by companyId
     * @access public
     * @param int companyId
     * @return mixed
     */
    public function getListShip($companyId = 0)
    {

        $query = DB::table('m_ship')->select([
            'm_ship.id',
            'm_ship.name'
        ]);

        if ($companyId != null || $companyId != '') {

            $query = $query
                    ->join('m_company', 'm_company.id', 'm_ship.company_id')
                    ->where('m_company.del_flag', 0)
                    ->where('m_ship.del_flag', 0)
                    ->where('m_company.id', $companyId);
        } else {
            $query = $query->where('m_ship.del_flag', 0);
        }

        return $query->get();
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
    public function searchListShip($companyId, $shipId, $shipName)
    {

        if ($shipName != null) {
            $shipName = "%" . $shipName . "%";
        }

        $query = DB::table('m_ship')->select([
            'm_ship.id',
            'm_ship.name'
        ]);

        if ($companyId != null || $companyId != '') {

            $query = $query
                    ->join('m_company', 'm_company.id', 'm_ship.company_id')
                    ->where('m_company.del_flag', 0)
                    ->where('m_ship.del_flag', 0)
                    ->where('m_company.id', $companyId);

            if ($shipId != null) {
                $query = $query->where('m_ship.id', $shipId);
            }

            if ($shipName != null) {
                $query = $query->whereRaw('m_ship.name LIKE ?', $shipName);
            }
        } else {
            $query = $query->where('m_ship.del_flag', 0);

            if ($shipId != null) {
                $query = $query->where('m_ship.id', $shipId);
            }

            if ($shipName != null) {
                $query = $query->whereRaw('m_ship.name LIKE ?', $shipName);
            }
        }

        return $query->get();
    }

    /**
     * Get detail ship by id
     *
     * @access public
     * @param int $idShip
     * @return mixed Illuminate\Support\Collection
    */
    public function getIdShip($idShip = null)
    {
        return DB::table('m_ship')->select([
                   'm_ship.id',
                   'm_ship.name',
                   'm_company.currency_id',
                   'm_currency.code'
                ])
                ->join('m_company', 'm_company.id','m_ship.company_id')
                ->join('m_currency', 'm_currency.id','m_company.currency_id')
                ->where('m_company.del_flag', 0)
                ->where('m_currency.del_flag', 0)
                ->where('m_ship.del_flag', 0)
                ->where('m_ship.id', $idShip)
                ->first();
    }

    /**
     * Function get ship by company id
     * @param int companyId
     * @param array columns
     * @return array
     */
    public function getShipByCompanyId($companyId, $columns)
    {
        $columns = is_array($columns) ? $columns : [$columns];

        return $this->select($columns)
            ->where('company_id', $companyId)
            ->get()
            ->toArray();
    }

    /**
     * Function delete ships by ids
     * @param array ids
     * @param array data
     * @return boolean
     */
    public function updateDeleteShipWattingApprove($ids, $data)
    {
        $data = is_array($data) ? $data : [$data];

        return $this->multiUpdate($ids, $data);
    }

    /**
     * Function select ship not have service by company id and service id
     * @param int companyId
     * @param int serviceId
     * @param array columnsSelect
     * @return array
     */
    public function selectShipNotHaveService($companyId, $serviceId, $columnsSelect = ['*'])
    {
        return $this->select($columnsSelect)
            ->join('m_company', function ($join) {
                $join->on('m_company.id', 'm_ship.company_id');
                $join->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE);
            })
            ->leftJoin('m_contract', function ($join) use ($serviceId) {
                $join->on('m_contract.ship_id', '=', 'm_ship.id');
                $join->where('m_contract.service_id', $serviceId);
            })
            ->where('m_company.id', $companyId)
            ->whereNull('m_contract.id')
            ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE)
            ->get()
            ->toArray();
    }

    /**
     * Get operation company
     *
     * @access public
     * @return array
     */
    public function getListCompany()
    {
        return DB::table('m_company')->select([
            'm_company.id',
            'm_company.name_en',
            'm_company.name_jp'
        ])
            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE)
            ->get()
            ->toArray();
    }

    /**
     * Check exist company id
     *
     * @param int $companyId
     * @return bool
     */
    public function checkExistCompany($companyId)
    {
        return DB::table('m_company')->select(['m_company.id'])
            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE)
            ->where('m_company.id', $companyId)
            ->exists();
    }

    /**
     * Get list nation
     *
     * @access public
     * @return array
     */
    public function getListNation()
    {
        return DB::table('m_nation')->select([
            'm_nation.id',
            'm_nation.name_en',
            'm_nation.name_jp'
        ])
            ->where('m_nation.del_flag', Constant::DELETE_FLAG_FALSE)
            ->get();
    }

    /**
     * Check exist nation id
     *
     * @param int $nationId
     * @return bool
     */
    public function checkExistNation($nationId)
    {
        return DB::table('m_nation')->select(['m_nation.id'])
            ->where('m_nation.del_flag', Constant::DELETE_FLAG_FALSE)
            ->where('m_nation.id', $nationId)
            ->exists();
    }

    /**
     * Get list classification
     *
     * @access public
     * @return array
     */
    public function getListClassification()
    {
        return DB::table('m_ship_classification')->select([
            'm_ship_classification.id',
            'm_ship_classification.name_en',
            'm_ship_classification.name_jp'
        ])
            ->where('m_ship_classification.del_flag', Constant::DELETE_FLAG_FALSE)
            ->get()
            ->toArray();
    }

    /**
     * Check exist classification id
     *
     * @param int $classificationId
     * @return bool
     */
    public function checkExistClassification($classificationId)
    {
        return DB::table('m_ship_classification')->select(['m_ship_classification.id'])
            ->where('m_ship_classification.del_flag', Constant::DELETE_FLAG_FALSE)
            ->where('m_ship_classification.id', $classificationId)
            ->exists();
    }

    /**
     * Get ship type
     *
     * @access public
     * @return array
     */
    public function getListShipType()
    {
        return DB::table('m_ship_type')->select([
            'm_ship_type.id',
            'm_ship_type.type'
        ])
            ->where('m_ship_type.del_flag', Constant::DELETE_FLAG_FALSE)
            ->get()
            ->toArray();
    }

    /**
     * Check exist ship type id
     *
     * @param int $shipTypeId
     * @return bool
     */
    public function checkExistShipType($shipTypeId)
    {
        return DB::table('m_ship_type')->select(['m_ship_type.id'])
            ->where('m_ship_type.del_flag', Constant::DELETE_FLAG_FALSE)
            ->where('m_ship_type.id', $shipTypeId)
            ->exists();
    }

    /**
     * Insert ship to database
     *
     * @param array $data insert data
     * @return bool
     */
    public function createShip($data)
    {
        return $this->insert($data);
    }
}
