<?php

/**
 * File company business
 *
 * Handle business related to company
 * @package App\Business
 * @author Rikkei.trihnm
 * @date 2018/06/19
 */

namespace App\Business;

use App\Repositories\Company\CompanyInterface;

class CompanyBusiness
{
    protected $companyRepository;

    public function __construct(CompanyInterface $companyInterface)
    {
        $this->companyRepository = $companyInterface;
    }

    /**
     * Business init page company
     * @access public
     * @param string column
     * @param int orderBy asc = 0 or null / desc = 1
     * @return Paginate
     */
    public function initListCompany($column = null, $orderBy = null)
    {
        $query = $this->companyRepository->getListCompanyCommon()
            ->groupBy([
                'm_company.id',
                'm_service.id',
            ]);

        // Check order by is desc or asc
        $orderBy = $orderBy ? 'desc' : 'asc';

        return $query->orderBy($this->_transFormNameToColumn($column), $orderBy)
            ->orderBy('m_company.id', $orderBy)
            ->paginate(config('pagination.default'));
    }

    /**
     * Business search company
     * @access public
     * @param int groupType company = 0/ service = 1
     * @param int pagination
     * @param string column
     * @param int orderBy asc = 0 or null / desc = 1
     * @return Paginate
     */
    public function searchCompany($groupType = 0, $pagination = 10, $column = null, $orderBy = null)
    {
        // Check group type is exists if not set default group company
        if ($groupType != config('company.group_company') && $groupType != config('company.group_service')) {
            $groupType = config('company.group_company');
        }

        // Check load result is exists if not set default is 10
        if (!in_array($pagination, config('pagination.paginate_value'))) {
            $pagination = config('pagination.default');
        }

        // Check order by is desc or asc
        $orderBy = $orderBy ? 'desc' : 'asc';

        // Return limit companies
        return $this->companyRepository->getListCompanyCommon($groupType)
            ->groupBy([
                !$groupType ? 'm_company.id' : 'm_service.id',
                !$groupType ? 'm_service.id' : 'm_company.id',
            ])
            ->orderBy($this->_transFormNameToColumn($column, $groupType), $orderBy)
            ->orderBy(!$groupType ? 'm_company.id' : 'm_service.id', $orderBy)
            ->paginate($pagination);
    }

    /**
     * Business filter company
     * @access public
     * @param array param condition filter
     * @param int groupType company = 0/ service = 1
     * @param int pagination
     * @param array option sort with column and ordery by
     * @return Paginate
     */
    public function filterCompany($param, $groupType = 0, $pagination = 10, $option = [])
    {
        if ($groupType != config('company.group_company') && $groupType != config('company.group_service')) {
            $groupType = config('company.group_company');
        }

        if (!in_array($pagination, config('pagination.paginate_value'))) {
            $pagination = config('pagination.default');
        }

        $param = $this->_checkValueExists($param);
        $option['sortBy'] = $option['sortBy'] ? 'desc' : 'asc';

        return $this->companyRepository->getListCompanyCommon($groupType)
            ->conditionSearchCompany($param)
            ->groupBy([
                !$groupType ? 'm_company.id' : 'm_service.id',
                !$groupType ? 'm_service.id' : 'm_company.id',
            ])
            ->orderBy($this->_transFormNameToColumn($option['field'], $groupType), $option['sortBy'])
            ->orderBy(!$groupType ? 'm_company.id' : 'm_service.id', $option['sortBy'])
            ->paginate($pagination);
    }

    /**
     * Check parameter is match with database
     * @access private
     * @param array params
     * @return array params
     */
    private function _checkValueExists($params)
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

    /**
     * Return array map with column in database
     * @access private
     * @param string name
     * @param int option
     * @description default with option = 0 will be return m_company.name_jp
     * @return String column name
     */
    private function _transFormNameToColumn($name, $option = 0)
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

    /**
     * Get detail group company/ detail group service
     * @access public
     * @param int id
     * @param int type group company = 0/ type group service = 1
     * @throws Exception
     * @return Collection
     */
    public function getDetailGroup($id, $type = 0)
    {
        if (!$id) throw new \Exception("Error");

        return $this->companyRepository->getDetailByGroup($id, $type);
    }
}
