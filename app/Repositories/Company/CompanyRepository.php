<?php

/**
* File Company controller
*
* @package App\Repositories\Company
* @author tri_hnm
* @date 2018/06/19
*/

namespace App\Repositories\Company;

use App\Repositories\EloquentRepository;
use App\Models\MCompany;

class CompanyRepository extends EloquentRepository implements CompanyInterface
{
    /**
     * Function get path model
     * @return Type string model
     */
    public function getModel()
    {
        return MCompany::class;
    }

    public function getListCompanyComon()
    {
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

                'm_service.id as service_id', // demo

                'm_nation.name_jp as nation_jp',
                'm_nation.name_en as nation_en'
            ])
            ->join('m_company_operation', 'm_company.ope_company_id', 'm_company_operation.id')
            ->join('m_nation', 'm_nation.id', 'm_company.nation_id')
            ->join('m_ship','m_ship.company_id', 'm_company.id')
            ->join('m_contract', 'm_ship.id', 'm_contract.ship_id')
            ->join('m_service', 'm_contract.service_id', 'm_service.id')
            ->where('m_contract.status', 0)
            // ->where('m_contract.approved_flag', 1)
            ->where('m_service.del_flag', 0)
            ->where('m_nation.del_flag', 0)
            ->where('m_ship.del_flag', 0)
            ->where('m_company.del_flag', 0)
            ->where('m_company_operation.del_flag', 0);
    }

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
            ->where('m_company.head_office_address', 'LIKE', '%' . $param['filter-address'] . '%')
            ->where('m_company_operation.name', 'LIKE', '%' . $param['filter-company-operation'] . '%')
            ->where('m_company.ope_person_name_1', 'LIKE', '%' . $param['filter-company-ope-person-name-1'] . '%')
            ->where('m_company.ope_email_1', 'LIKE', '%' . $param['filter-company-ope-person-email-1'] . '%')
            ->where('m_company.ope_phone_1', 'LIKE', '%' . $param['filter-company-ope-person-phone-1'] . '%')
            ->where('m_company.ope_person_name_2', 'LIKE', '%' . $param['filter-company-ope-person-name-2'] . '%')
            ->where('m_company.ope_email_2', 'LIKE', '%' . $param['filter-company-ope-person-email-2'] . '%')
            ->where('m_company.ope_phone_2', 'LIKE', '%' . $param['filter-company-ope-person-phone-2'] . '%')
            ->where(function ($query) use ($param) {
                return $query->where('m_service.name_jp', 'LIKE', '%' . $param['filter-service'] . '%')
                    ->orWhere('m_service.name_en', 'LIKE', '%' . $param['filter-service'] . '%');
            });
    }
}
