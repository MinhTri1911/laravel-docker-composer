<?php

/**
* File Company Interface
*
* @package App\Repositories\Company
* @author tri_hnm
* @date 2018/07/02
*/

namespace App\Repositories\Company;

interface CompanyInterface
{
    /**
     * Function get list company common
     * @param Type int groupType company = 0/ service = 1
     * @return mixed
     */
    public function getListCompanyCommon($groupType = 0);

    /**
     * Function make condition for search company
     * @param Type array param
     * @return mixed
     */
    public function conditionSearchCompany($param);

    /**
     * Function get detail group company/ service
     * @param Type int id
     * @param Type int type group detail company = 0/ group detail service = 1
     * @return collection
     */
    public function getDetailByGroup($id, $type = 0);
}
