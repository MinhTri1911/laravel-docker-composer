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

    public function initListCompany($column = null, $orderBy = null)
    {
        $query = $this->companyRepository->getListCompanyComon()
            ->groupBy([
                'm_company.id',
                'm_service.id',
            ]);

        $orderBy = $orderBy ? 'desc' : 'asc';

        return $query
            ->orderBy($this->transFormNameToColumn($column), $orderBy)
            ->orderBy('m_company.id', $orderBy)
            ->paginate(config('pagination.default'));
    }

    public function searchCompany($groupType = 0, $pagination = 10, $column = null, $orderBy = null)
    {
        // SMA0001 sheet define hanlde index => 2 search company
        if ($groupType != config('company.group_company') && $groupType != config('company.group_service')) {
            $groupType = config('company.group_company');
        }

        if (!in_array($pagination, config('pagination.paginate_value'))) {
            $pagination = config('pagination.default');
        }

        $orderBy = $orderBy ? 'desc' : 'asc';

        return $this->companyRepository->getListCompanyComon()
            ->groupBy([
                !$groupType ? 'm_company.id' : 'm_service.id',
                !$groupType ? 'm_service.id' : 'm_company.id',
            ])
            ->orderBy($this->transFormNameToColumn($column, $groupType), $orderBy)
            ->orderBy(!$groupType ? 'm_company.id' : 'm_service.id', $orderBy)
            // ->orderBy('m_service.id', $orderBy)
            ->paginate($pagination);
    }

    public function filterCompany($param, $groupType = 0, $pagination = 10, $option = [])
    {
        if ($groupType != config('company.group_company') && $groupType != config('company.group_service')) {
            $groupType = config('company.group_company');
        }

        if (!in_array($pagination, config('pagination.paginate_value'))) {
            $pagination = config('pagination.default');
        }

        $param = $this->checkValueExists($param);
        $option['sortBy'] = $option['sortBy'] ? 'desc' : 'asc';

        return $this->companyRepository->getListCompanyComon()
            ->conditionSearchCompany($param)
            ->groupBy([
                !$groupType ? 'm_company.id' : 'm_service.id',
                !$groupType ? 'm_service.id' : 'm_company.id',
            ])
            ->orderBy($this->transFormNameToColumn($option['field'], $groupType), $option['sortBy'])
            ->orderBy(!$groupType ? 'm_company.id' : 'm_service.id', $option['sortBy'])
            ->paginate($pagination);
    }

    private function checkValueExists($params)
    {
        $data = [];

        $data['filter-company'] = !empty($params['filter-company']) ?  $params['filter-company'] : '';
        $data['filter-service'] = !empty($params['filter-service']) ?  $params['filter-service'] : '';
        $data['filter-nation'] = !empty($params['filter-nation']) ? $params['filter-nation'] : '';
        $data['filter-address'] = !empty($params['filter-address']) ? $params['filter-address'] : '';
        $data['filter-company-operation'] = !empty($params['filter-company-operation']) ? $params['filter-company-operation'] : '';
        $data['filter-company-ope-person-name-1'] = !empty($params['filter-company-ope-person-name-1'])
            ? $params['filter-company-ope-person-name-1']
            : '';
        $data['filter-company-ope-person-email-1'] = !empty($params['filter-company-ope-person-email-1'])
            ? $params['filter-company-ope-person-email-1']
            : '';
        $data['filter-company-ope-person-phone-1'] = !empty($params['filter-company-ope-person-phone-1'])
            ? $params['filter-company-ope-person-phone-1']
            : '';
        $data['filter-company-ope-person-name-2'] = !empty($params['filter-company-ope-person-name-2'])
            ? $params['filter-company-ope-person-name-2']
            : '';
        $data['filter-company-ope-person-email-2'] = !empty($params['filter-company-ope-person-email-2'])
            ? $params['filter-company-ope-person-email-2']
            : '';
        $data['filter-company-ope-person-phone-2'] = !empty($params['filter-company-ope-person-phone-2'])
            ? $params['filter-company-ope-person-phone-2']
            : '';

        return $data;
    }

    private function transFormNameToColumn($name, $option = 0)
    {
        $columns = [
            'filter-company' => 'm_company.name_jp',
            'filter-service' => 'm_service.name_jp',
            'filter-address' => 'm_company.head_office_address',
            'filter-nation' => 'm_nation.name_jp',
            'filter-company-operation' => 'm_company_operation.name',
        ];

        return !empty($columns[$name]) ? $columns[$name] : ($option ? $columns['filter-service'] : $columns['filter-company']);
    }
}
