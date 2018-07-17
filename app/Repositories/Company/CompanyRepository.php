<?php

/**
 * File company repository
 *
 * Handle eloquent query builder company
 * @package App\Repositories\Company
 * @author Rikkei.trihnm
 * @date 2018/06/19
 */

namespace App\Repositories\Company;

use App\Repositories\EloquentRepository;
use App\Models\MCompany;

class CompanyRepository extends EloquentRepository implements CompanyInterface
{
    /**
     * Function get path model
     * @access public
     * @return string model
     */
    public function getModel()
    {
        return MCompany::class;
    }

    /**
     * Function get list company common
     * @access public
     * @param int groupType company = 0/ service = 1
     * @return mixed
     */
    public function getListCompanyCommon($groupType = 0)
    {
        // Check group type and set subquery for count total license
        if (!$groupType) {
            $subQuery = '(select count(contract.id) as count , company.id
                FROM m_company as company
                JOIN m_ship as ship ON ship.company_id = company.id
                JOIN m_contract as contract ON ship.id = contract.ship_id
                WHERE contract.status = 0 AND ship.del_flag = 0 AND company.del_flag = 0 AND contract.approved_flag = 1
                group by company.id
            ) as sumTotalLicense';
        } else {
            $subQuery = '(select count(service.id) as count , service.id
                FROM m_company as company
                JOIN m_ship as ship ON ship.company_id = company.id
                JOIN m_contract as contract ON ship.id = contract.ship_id
                JOIN m_service as service on service.id = contract.service_id
                WHERE contract.status = 0 AND ship.del_flag = 0 AND company.del_flag = 0 AND contract.approved_flag = 1
                group by service.id
            ) as sumTotalLicense';
        }

        return $this->select([
                'm_company.id',
                'm_company.name_jp',
                'm_company.name_en',
                'm_company.head_office_address',
                'm_company_operation.name as ope_company_name',
                'm_company.ope_person_name_1',
                'm_company.ope_email_1',
                'm_company.ope_phone_1',
                'm_company.ope_person_name_2',
                'm_company.ope_email_2',
                'm_company.ope_phone_2',
                'm_service.name_jp as service_name_jp',
                'm_service.name_en as service_name_en',
                \DB::raw('COUNT(m_service.id) as license'),
                'm_service.id as service_id',
                'm_nation.name_jp as nation_jp',
                'm_nation.name_en as nation_en',
                'sumTotalLicense.count as total_license'
            ])
            ->join('m_company_operation', 'm_company.ope_company_id', 'm_company_operation.id')
            ->join('m_nation', 'm_nation.id', 'm_company.nation_id')
            ->join('m_ship','m_ship.company_id', 'm_company.id')
            ->join('m_contract', 'm_ship.id', 'm_contract.ship_id')
            ->join('m_service', 'm_contract.service_id', 'm_service.id')
            ->join(\DB::raw($subQuery), function($join) use ($groupType) {
                $join->on('sumTotalLicense.id', '=', $groupType ? 'm_service.id' : 'm_company.id');
            })
            ->where('m_contract.status', 0)
            ->where('m_contract.approved_flag', 1)
            ->where('m_service.del_flag', 0)
            ->where('m_nation.del_flag', 0)
            ->where('m_ship.del_flag', 0)
            ->where('m_company.del_flag', 0)
            ->where('m_company_operation.del_flag', 0);
    }

    /**
     * Function make condition for search company
     * @access public
     * @param array param
     * @return mixed
     */
    public function conditionSearchCompany($param)
    {
        return $this->where(function ($query) use ($param) {
                return $query->where('m_company.name_jp', 'LIKE', '%' . $param['filter-company'] . '%')
                    ->orWhere('m_company.name_en', 'LIKE', '%' . $param['filter-company'] . '%');
            })
            ->where(function ($query) use ($param) {
                return $query->where('m_nation.name_jp', 'LIKE', '%' .$param['filter-nation'] . '%')
                    ->orWhere('m_nation.name_en', 'LIKE', '%' . $param['filter-nation'] . '%');
            })
            ->where(function ($query) use ($param) {
                if ($param['filter-address']) {
                    return $query->where('m_company.head_office_address', 'LIKE', '%' . $param['filter-address'] . '%');
                }
            })
            ->where('m_company_operation.name', 'LIKE', '%' . $param['filter-company-operation'] . '%')
            ->where('m_company.ope_person_name_1', 'LIKE', '%' . $param['filter-company-ope-person-name-1'] . '%')
            ->where('m_company.ope_email_1', 'LIKE', '%' . $param['filter-company-ope-person-email-1'] . '%')
            ->where(function ($query) use ($param) {
                if ($param['filter-company-ope-person-phone-1']) {
                    return $query->where('m_company.ope_phone_1', 'LIKE', '%' . $param['filter-company-ope-person-phone-1'] . '%');
                }
            })
            ->where(function ($query) use ($param) {
                if ($param['filter-company-ope-person-name-2']) {
                    return $query->where('m_company.ope_person_name_2', 'LIKE', '%' . $param['filter-company-ope-person-name-2'] . '%');
                }
            })
            ->where(function ($query) use ($param) {
                if ($param['filter-company-ope-person-email-2']) {
                    return $query->where('m_company.ope_email_2', 'LIKE', '%' . $param['filter-company-ope-person-email-2'] . '%');
                }
            })
            ->where(function ($query) use ($param) {
                if ($param['filter-company-ope-person-phone-2']) {
                    return $query->where('m_company.ope_phone_2', 'LIKE', '%' . $param['filter-company-ope-person-phone-2'] . '%');
                }
            })
            ->where(function ($query) use ($param) {
                return $query->where('m_service.name_jp', 'LIKE', '%' . $param['filter-service'] . '%')
                    ->orWhere('m_service.name_en', 'LIKE', '%' . $param['filter-service'] . '%');
            });
    }

    /**
     * Function get detail group company/ service
     * @access public
     * @param int id
     * @param int type group detail company = 0/ group detail service = 1
     * @return Collection
     */
    public function getDetailByGroup($id, $type = 0)
    {
        return $this->select([
                'm_company.id as company_id',
                'm_company.name_jp as company_jp',
                'm_company.name_en as company_en',
                'm_service.id as service_id',
                'm_service.name_jp as service_jp',
                'm_service.name_en as service_en',
                'm_ship.name as ship_name',
                'm_contract.start_date as contract_start_date',
            ])
            ->join('m_ship', 'm_ship.company_id', 'm_company.id')
            ->join('m_contract', 'm_ship.id', 'm_contract.ship_id')
            ->join('m_service', 'm_service.id', 'm_contract.service_id')
            ->where(!$type ? 'm_company.id' : 'm_service.id', $id)
            ->where('m_contract.status', 0)
            ->where('m_contract.approved_flag', 1)
            ->where('m_service.del_flag', 0)
            ->where('m_ship.del_flag', 0)
            ->where('m_company.del_flag', 0)
            ->groupBy([
                !$type ? 'm_service.id' : 'm_company.id',
                'm_ship.id',
            ])
            ->get();
    }
}
