<?php

/**
 * File Company Interface
 *
 * Define function for company repository
 * @package App\Repositories\Company
 * @author Rikkei.trihnm
 * @date 2018/07/02
 */

namespace App\Repositories\Company;
use App\Common\Constant;

interface CompanyInterface
{
    /**
     * Function get list company common
     * @access public
     * @param int groupType company = 0/ service = 1
     * @param int $showType select company have contract active and not have contrct active
     * @return mixed
     */
    public function getListCompanyCommon($groupType = 0, $showType = Constant::SHOW_ACTIVE);

    /**
     * Function make condition for search company
     * @access public
     * @param array param
     * @return mixed
     */
    public function conditionSearchCompany($param);

    /**
     * Function get detail group company/ service
     * @access public
     * @param int id
     * @param int type group detail company = 0/ group detail service = 1
     * @return Collection
     */
    public function getDetailByGroup($id, $type = 0);

     /**
     * Function check exits currency by currency id
     * @access public
     * @param int $currencyId
     * @return boolean
    */
    public function checkExits($currencyId);

    /**
     * Function get detail company by id
     * @param int id
     * @param array columns
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return array
     */
    public function getDetailCompanyWithRelation($id, $columns = ['*']);

    /**
     * Function company currency id
     * @param int companyId
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return array
     */
    public function getCompanyCurrencyId($companyId);

    /**
     * Function update currency company
     * @param int companyId
     * @param int currencyId
     * @return bool|mixed
     */
    public function updateCompanyBillingMethod($companyId, $billingMethodId);

    /**
     * Function check exists contract in company watting for approved
     * @param int companyId
     * @return boolean
     */
    public function existsContractWattingApprove($companyId);

    /**
     * Function check exists company
     *
     * @param int $companyId
     * @return boolean
     */
    public function checkCompanyExists($companyId);

    /**
     * Function get company
     *
     * @param int $companyId
     * @param array $columns
     * @throws Exception
     * @return App\Models\MCompany
     */
    public function getCompanyDetail($companyId, $columns = ['*']);

    /**
     * Check exists name company
     *
     * @param string $name
     * @param integer $type
     * @return void
     */
    public function existsName($name, $type = 0);
}
