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
}
