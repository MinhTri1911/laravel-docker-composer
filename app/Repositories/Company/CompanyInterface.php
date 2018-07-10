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

interface CompanyInterface
{
    /**
     * Function get list company common
     * @access public
     * @param int groupType company = 0/ service = 1
     * @return mixed
     */
    public function getListCompanyCommon($groupType = 0);

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

    // /**
    //  * Function get detail company by id
    //  * @param int id
    //  * @param array colums
    //  * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
    //  * @return \App\Models\MCompany
    //  */
    // public function getCompany($id, $columns = ['*']);
}
