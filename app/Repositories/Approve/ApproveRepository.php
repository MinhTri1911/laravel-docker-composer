<?php

/**
 * Approve interface
 *
 * @package App\Repositories\Approve
 * @author Rikkei.DungLV
 * @date 2018/07/11
 */

namespace App\Repositories\Approve;

use Illuminate\Support\Facades\DB;
use App\Common\Constant;

class ApproveRepository implements ApproveInterface
{
    /**
     * Get list contract with condition config define by index of array 
     * 'company' to get list contract from list company, 'limit' to limit 
     * record per page of query, 'user' to filter user created request approve,
     * 'date' return date send request, when create then compare created_at, when 
     * update then compare updated_at column base on date_from and date_to format
     * Avaliable index array: "company", "limit", "user", "date:date_from,date_to"
     * 
     * @access public
     * @param array $paramCondition 
     * @return Illuminate\Support\Collection
     */
    public function getListContract($paramCondition = [])
    {
        // Query get contract
        $contracts = DB::table('m_contract')
                ->join('m_ship', function($join) {
                    $join->on('m_ship.id', '=', 'm_contract.ship_id')
                        ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_service', function($join) {
                    $join->on('m_service.id', '=', 'm_contract.service_id')
                        ->where('m_service.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                // Check company sync to ship
                ->join('m_company', function($join) use ($paramCondition) {
                    if (isset($paramCondition['company']) && count($paramCondition['company']) > 0) {
                        $join->on('m_ship.company_id', '=', 'm_company.id')
                            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE)
                            ->whereIn('m_company.id', $paramCondition['company']);
                        unset($paramCondition['company']);
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
                            ->where('m_currency.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_ship_classification', function($join) {
                    $join->on('m_ship.classification_id', '=', 'm_ship_classification.id')
                            ->where('m_ship_classification.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_ship_type', function($join) {
                    $join->on('m_ship.type_id', '=', 'm_ship_type.id')
                            ->where('m_ship_type.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('t_user_login', function($join) {
                    $join->whereRaw("(m_contract.updated_by IS NULL AND m_contract.created_by = t_user_login.id) OR m_contract.updated_by = t_user_login.id")
                            ->where('t_user_login.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->select([
                    "m_contract.id as contract_id",
                    "m_contract.revision_number as contract_revision_number",
                    "m_contract.start_date as contract_start_date",
                    "m_contract.end_date as contract_end_date",
                    "m_contract.status as contract_status",
                    "m_contract.approved_flag as contract_approved_flag",
                    "m_contract.reason_reject as contract_reason_reject",
                    "m_contract.created_at as contract_created_at",
                    "m_contract.created_by as contract_created_by",
                    "m_contract.updated_at as contract_updated_at",
                    "m_contract.updated_by as contract_updated_by",
                    "m_contract.remark as contract_remark",
                    "m_contract.deleted_at as contract_deleted_at",
                    "m_contract.pending_at as contract_pending_at",
                    "m_ship.name as contract_ship_name",
                    "m_ship.id as contract_ship_id",
                    "m_service.id as contract_service_id",
                    "m_service.name_jp as contract_service_name",
                    "m_company.name_jp as contract_company_name",
                    "t_user_login.name as contract_user_name",
                    "t_user_login.id as contract_user_id",
                ]);
        
        // Check if want to limit page
        $limit = null;
        if (isset($paramCondition['limit'])) {
            $limit = $paramCondition['limit'];
            unset($paramCondition['limit']);
        }
        
        $idContract = null;
        if (isset($paramCondition['idContract'])) {
            $idContract = $paramCondition['idContract'];
            unset($paramCondition['idContract']);
        }
        
        // Remove condition if not in query string sql
        $paramCondition = $this->removeConfigConditionNotFilter($paramCondition);

        // Check date to
        if (isset($paramCondition['date'])) {
            $date_from = $paramCondition['date']['date_from']??null;
            $date_to = $paramCondition['date']['date_to']??null;
            
            $contracts->whereRaw("((m_contract.updated_at IS NULL AND (? IS NULL OR m_contract.created_at >= ?) AND (? IS NULL OR m_contract.created_at <= ?)) 
                        OR ((? IS NULL OR m_contract.updated_at >= ?) AND (? IS NULL OR m_contract.updated_at <= ?)))", 
                        [$date_from, $date_from, $date_to, $date_to, $date_from, $date_from, $date_to, $date_to ]
                    );
            unset($paramCondition['date']);
        }
       
        // Check if filter user
        if (isset($paramCondition['user'])) {
            $user = $paramCondition['user']??null;
            $contracts->where("t_user_login.name", "LIKE", '%'.$user.'%');
           unset($paramCondition['user']);
        }
        
        // Check if conditon to filter
        if (!is_null($paramCondition) && count($paramCondition) > 0) {
            $contracts->where($paramCondition);
        }
        
        // If get single contract
        if (!is_null($idContract)) {
            if (is_array($idContract) && count($idContract) > 0) {
                return $contracts
                    ->whereIn('m_contract.id', $idContract)
                    ->get();
            }
            
            return $contracts
                ->where('m_contract.id', $idContract)
                ->get();
        }
        
        // Paginate with limit
        if (!is_null($limit))
            return $contracts->paginate($limit);
        
        return $contracts->get();
    }

    /* 
     * Handle remove index from condition don't use in clause condition of query SQL
     * 
     * @access public
     * @param Array $paramCondition
     * @return Array
     */
    public function removeConfigConditionNotFilter($paramCondition = null)
    {
        if (isset($paramCondition['type'])) {
            unset($paramCondition['type']);
        }
        
        if (isset($paramCondition['status'])) {
            unset($paramCondition['status']);
        
        }    
        
        return $paramCondition;
        
    }
    
    /**
     * Get list spot with condition config define by index of array 
     * 'company' to get list contract from list company, 'limit' to limit 
     * record per page of query, 'user' to filter user created request approve,
     * 'date' return date send request, when create then compare created_at, when 
     * update then compare updated_at column base on date_from and date_to format
     * Avaliable index array: "company", "limit", "user", "date:date_from,date_to", "idSpot"
     * 
     * @access public
     * @param array $paramCondition 
     * @return Illuminate\Support\Collection
     */
    public function getListSpot($paramCondition = [])
    {
        // Query get contract
        $spots = DB::table('t_ship_spot')
                ->join('m_ship', function($join) {
                    $join->on('m_ship.id', '=', 't_ship_spot.ship_id')
                        ->where('m_ship.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_spot', function($join) {
                    $join->on('m_spot.id', '=', 't_ship_spot.spot_id')
                        ->where('m_spot.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                // Check company sync to ship
                ->join('m_company', function($join) use ($paramCondition) {
                    if (isset($paramCondition['company']) && count($paramCondition['company']) > 0) {
                        $join->on('m_ship.company_id', '=', 'm_company.id')
                            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE)
                            ->whereIn('m_company.id', $paramCondition['company']);
                        unset($paramCondition['company']);
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
                            ->where('m_currency.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_ship_classification', function($join) {
                    $join->on('m_ship.classification_id', '=', 'm_ship_classification.id')
                            ->where('m_ship_classification.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_ship_type', function($join) {
                    $join->on('m_ship.type_id', '=', 'm_ship_type.id')
                            ->where('m_ship_type.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('t_user_login', function($join) {
                    $join->whereRaw("(t_ship_spot.updated_by IS NULL AND t_ship_spot.created_by = t_user_login.id) OR t_ship_spot.updated_by = t_user_login.id")
                            ->where('t_user_login.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->select([
                    "t_ship_spot.id as spot_id",
                    "t_ship_spot.month_usage as spot_month_usage",
                    "t_ship_spot.amount_charge as spot_amount_charge",
                    "t_ship_spot.remark as spot_remark",
                    "t_ship_spot.approved_flag as spot_approved_flag",
                    "t_ship_spot.reason_reject as spot_reason_reject",
                    "t_ship_spot.created_at as spot_created_at",
                    "t_ship_spot.created_by as spot_created_by",
                    "t_ship_spot.updated_at as spot_updated_at",
                    "t_ship_spot.updated_by as spot_updated_by",
                    "t_ship_spot.del_flag as spot_del_flag",
                    "m_ship.name as spot_ship_name",
                    "m_ship.id as spot_ship_id",
                    "m_spot.id as spot_spot_id",
                    "m_spot.name_jp as spot_spot_name",
                    "m_company.name_jp as spot_company_name",
                    "t_user_login.name as spot_user_name",
                    "t_user_login.id as spot_user_id",
                    "m_currency.id as spot_currency_id",
                    "m_currency.name_jp as spot_currency_name",
                ]);
        
        // Check if want to limit page
        $limit = null;
        if (isset($paramCondition['limit'])) {
            $limit = $paramCondition['limit'];
            unset($paramCondition['limit']);
        }
        
        $idSpot = null;
        if (isset($paramCondition['idSpot'])) {
            $idSpot = $paramCondition['idSpot'];
            unset($paramCondition['idSpot']);
        }
        
        // Remove condition if not in query string sql
        $paramCondition = $this->removeConfigConditionNotFilter($paramCondition);
        
        // Check date to
        if (isset($paramCondition['date'])) {
            $date_from = $paramCondition['date']['date_from']??null;
            $date_to = $paramCondition['date']['date_to']??null;
            
            $spots->whereRaw("((m_contract.updated_at IS NULL AND (? IS NULL OR m_contract.created_at >= ?) AND (? IS NULL OR m_contract.created_at <= ?)) 
                        OR ((? IS NULL OR m_contract.updated_at >= ?) AND (? IS NULL OR m_contract.updated_at <= ?)))", 
                        [$date_from, $date_from, $date_to, $date_to, $date_from, $date_from, $date_to, $date_to ]
                    );
            unset($paramCondition['date']);
        }
       
        // Check if filter user
        if (isset($paramCondition['user'])) {
            $user = $paramCondition['user']??null;
            $spots->where("t_user_login.name", "LIKE", '%'.$user.'%');
           unset($paramCondition['user']);
        }
        
        // Check if conditon to filter
        if (!is_null($paramCondition) && count($paramCondition) > 0) {
            $spots->where($paramCondition);
        }
        
        // If get single contract
        if (!is_null($idSpot)) {
            if (is_array($idSpot) && count($idSpot) > 0) {
                return $spots
                    ->whereIn('t_ship_spot.id', $idSpot)
                    ->get();
            }
            return $spots
                    ->where('t_ship_spot.id', $idSpot)
                    ->get();
        }
        
        // Paginate with limit
        if (!is_null($limit)) {
            return $spots->paginate($limit);
        }
        
        return $spots->get();
    }
    
    /**
     * Get list contract with condition config define by index of array 
     * 'company' to get list contract from list company, 'limit' to limit 
     * record per page of query, 'user' to filter user created request approve,
     * 'date' return date send request, when create then compare created_at, when 
     * update then compare updated_at column base on date_from and date_to format
     * Avaliable index array: "company", "limit", "user", "date:date_from,date_to"
     * 
     * @access public
     * @param array $paramCondition 
     * @return Illuminate\Support\Collection
     */
    public function getListBilling($paramCondition = [])
    {
        // Query get contract
        $billings = DB::table('t_history_billing')
                // Check company sync to ship
                ->join('m_company', function($join) use ($paramCondition) {
                    if (isset($paramCondition['company']) && count($paramCondition['company']) > 0) {
                        $join->on('t_history_billing.company_id', '=', 'm_company.id')
                            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE)
                            ->whereIn('m_company.id', $paramCondition['company']);
                        unset($paramCondition['company']);
                    } else {
                        $join->on('t_history_billing.company_id', '=', 'm_company.id')
                            ->where('m_company.del_flag', Constant::DELETE_FLAG_FALSE);
                    }
                })
                ->join('m_nation', function($join) {
                    $join->on('m_company.nation_id', '=', 'm_nation.id')
                            ->where('m_nation.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('m_currency', function($join) {
                    $join->on('m_company.currency_id', '=', 'm_currency.id')
                            ->where('m_currency.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->join('t_user_login', function($join) {
                    $join->whereRaw("(t_history_billing.updated_by IS NULL AND t_history_billing.created_by = t_user_login.id) OR t_history_billing.updated_by = t_user_login.id")
                            ->where('t_user_login.del_flag', Constant::DELETE_FLAG_FALSE);
                })
                ->select([
                    "t_history_billing.id as billing_id",
                    "t_history_billing.claim_date as billing_claim_date",
                    "t_history_billing.payment_due_date as billing_payment_due_date",
                    "t_history_billing.payment_deadline_no as billing_payment_deadline_no",
                    "t_history_billing.payment_actual_date as billing_payment_actual_date",
                    "t_history_billing.total_amount_billing as billing_total_amount_billing",
                    "t_history_billing.approved_flag as billing_approved_flag",
                    "t_history_billing.reason_reject as billing_reason_reject",
                    "t_history_billing.created_at as billing_created_at",
                    "t_history_billing.created_by as billing_created_by",
                    "t_history_billing.updated_at as billing_updated_at",
                    "t_history_billing.updated_by as billing_updated_by",
                    "t_history_billing.pdf_original_link as billing_pdf_original_link",
                    "m_company.name_jp as billing_company_name",
                    "t_user_login.name as billing_user_name",
                    "t_user_login.id as billing_user_id",
                ]);
        
        // Check if want to limit page
        $limit = null;
        if (isset($paramCondition['limit'])) {
            $limit = $paramCondition['limit'];
            unset($paramCondition['limit']);
        }
        
        $idBilling = null;
        if (isset($paramCondition['idBilling'])) {
            $idBilling = $paramCondition['idBilling'];
            unset($paramCondition['idBilling']);
        }
        
        // Remove condition if not in query string sql
        $paramCondition = $this->removeConfigConditionNotFilter($paramCondition);
        
        // Check date to
        if (isset($paramCondition['date'])) {
            $date_from = $paramCondition['date']['date_from']??null;
            $date_to = $paramCondition['date']['date_to']??null;
            
            $billings->whereRaw("((t_history_billing.updated_at IS NULL AND (? IS NULL OR t_history_billing.created_at >= ?) AND (? IS NULL OR t_history_billing.created_at <= ?)) 
                        OR ((? IS NULL OR t_history_billing.updated_at >= ?) AND (? IS NULL OR t_history_billing.updated_at <= ?)))", 
                        [$date_from, $date_from, $date_to, $date_to, $date_from, $date_from, $date_to, $date_to ]
                    );
            unset($paramCondition['date']);
        }
       
        // Check if filter user
        if (isset($paramCondition['user'])) {
            $user = $paramCondition['user']??null;
            $billings->where("t_user_login.name", "LIKE", '%'.$user.'%');
           unset($paramCondition['user']);
        }
        
        // Check if conditon to filter
        if (!is_null($paramCondition) && count($paramCondition) > 0) {
            $billings->where($paramCondition);
        }
        
        // If get single contract
        if (!is_null($idBilling)) {
            if (is_array($idBilling) && count($idBilling) > 0) {
                return $billings
                    ->whereIn('t_history_billing.id', $idBilling)
                    ->get();
            }
            return $billings
                    ->where('t_history_billing.id', $idBilling)
                    ->get();
        }
        
        // Paginate with limit
        if (!is_null($limit)) {
            return $billings->paginate($limit);
        }
        
        return $billings->get();
    }
}
