<?php

/**
* File Company controller
* Handle business related to company
* @package App\Repositories\Company
* @author tri_hnm
* @date 2018/06/19
*/

namespace App\Business;

use App\Repositories\Company\CompanyInterface;

class CompanyBusiness
{

    /**
    * Type of user
    */
    protected $type;


    private $_key;


    public $name;

    protected $companyRepository;

    public function __construct(CompanyInterface $companyInterface)
    {
        $this->companyRepository = $companyInterface;
    }

    public function initListCompany()
    {
        return $this->companyRepository->select([
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
            ->where('m_company_operation.del_flag', 0)
            ->groupBy([
                'm_company.id',
                'm_service.id',
            ])
            ->paginate(config('pagination.default'));
    }

    public function searchCompany($groupType = 0, $pagination = 10)
    {
        if ($groupType != config('company.group_company') && $groupType != config('company.group_service')) {
            $groupType = config('company.group_company');
        }

        if (!in_array($pagination, config('pagination.paginate_value'))) {
            $pagination = config('pagination.default');
        }

        return $this->companyRepository->select([
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
            'm_service.id as service_id',
            \DB::raw('COUNT(m_service.id) as license'),
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
        ->where('m_company_operation.del_flag', 0)
        ->groupBy([
            !$groupType ? 'm_company.id' : 'm_service.id',
            !$groupType ? 'm_service.id' : 'm_company.id',
        ])
        ->paginate($pagination);
    }

    public function filterCompany($param, $groupType = 0, $pagination = 10)
    {
        dd(isset($param['filter-company']) ? $param['filter-company'] : '' );
        if ($groupType != config('company.group_company') && $groupType != config('company.group_service')) {
            $groupType = config('company.group_company');
        }

        if (!in_array($pagination, config('pagination.paginate_value'))) {
            $pagination = config('pagination.default');
        }

        return $this->companyRepository->select([
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
            ->where('m_company_operation.del_flag', 0)
            ->where(function ($query) use ($param) {
                return $query->where('m_company.name_jp', 'LIKE', '%' . isset($param['filter-company']) ? $param['filter-company'] : '' . '%')
                    ->orWhere('m_company.name_en', 'LIKE', '%' . isset($param['filter-company']) ? $param['filter-company'] : '' . '%');
            })
            ->where(function ($query) use ($param) {
                return $query->where('m_nation.name_jp', 'LIKE', '%' . isset($param['filter-nation']) ? $param['filter-nation'] : '' . '%')
                ->orWhere('m_nation.name_en', 'LIKE', '%' . isset($param['filter-nation']) ? $param['filter-nation'] : '' . '%');
            })
            ->where('m_company.head_office_address', 'LIKE', '%' . isset($param['filter-address']) ? $param['filter-address'] : '' . '%')
            ->where('m_company_operation.name', 'LIKE', '%' . isset($param['filter-company-operation']) ?  $param['filter-company-operation'] : '' . '%')
            ->where('m_company.ope_person_name_1', 'LIKE', '%' . isset($param['filter-company-operation']) ?  $param['filter-company-ope-person-name-1'] : '' . '%')
            // ->where('m_company.ope_email_1', 'LIKE', '%' . $param['filter-company-ope-person-email-1'] . '%')
            // ->where('m_company.ope_phone_1', 'LIKE', '%' . $param['filter-company-ope-person-phone-1'] . '%')
            // ->where('m_company.ope_person_name_2', 'LIKE', '%' . $param['filter-company-ope-person-name-2'] . '%')
            // ->where('m_company.ope_email_2', 'LIKE', '%' . $param['filter-company-ope-person-email-2'] . '%')
            // ->where('m_company.ope_phone_2', 'LIKE', '%' . $param['filter-company-ope-person-phone-2'] . '%')
            ->groupBy([
                !$groupType ? 'm_company.id' : 'm_service.id',
                !$groupType ? 'm_service.id' : 'm_company.id',
            ])
            ->paginate($pagination);
    }
}
