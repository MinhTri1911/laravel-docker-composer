<?php

/**
 * Handle query eloquent m_company_operation
 *
 * File CompanyOpeRepository
 * @package App\Repositories\CompanyOperation
 * @author Rikkei.Trihnm
 * @date 2018/07/27
 */

namespace App\Repositories\CompanyOperation;

use App\Repositories\EloquentRepository;
use App\Models\MCompanyOperation;
use App\Common\Constant;
use Illuminate\Support\Collection;

class CompanyOpeRepository extends EloquentRepository implements CompanyOpeInterface
{
    public function getModel()
    {
        return MCompanyOperation::class;
    }

    /**
     * Function get company operation by permission
     *
     * @param array $columns
     * @throws Exception
     * @return Collection
     */
    public function getCompanyOperationByPermisstion($columns = ['*'])
    {
        // User have permision in and out of company operation
        if (auth()->user()->auth_operation) {
            return $this->where('del_flag', Constant::DELETE_FLAG_FALSE)->get($columns);
        }

        $companyOpe = new Collection();

        // Return only company operation of user
        return $companyOpe->push($this->where('del_flag', Constant::DELETE_FLAG_FALSE)
            ->findOrFail(auth()->user()->ope_company_id, $columns));
    }
}
