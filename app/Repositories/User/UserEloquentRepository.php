<?php

/**
 * User Repository
 *
 * @package App\Repositories\Ship
 * @author Rikkei.QuyenL
 * @date 2018/07/19
 */

namespace App\Repositories\User;

use App\Models\TUserLogin;
use App\Repositories\EloquentRepository;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{
    /**
     * Set model user for interface
     *
     * @return string App\Models\User
     */
    public function getModel()
    {
        return TUserLogin::class;
    }

    /**
     * Get user logged data
     *
     * @param int $userId identification of Auth user
     * @return array
     */
    public function getUserData($userId)
    {
        return $query = $this->select([
            't_user_login.name',
            't_user_login.auth_create',
            't_user_login.auth_approve',
            't_user_login.auth_reference',
            't_user_login.auth_operation',
            't_user_login.auth_admin',
            't_user_login.login_id',
            'm_company_operation.id AS m_company_operation_id',
            'm_company_operation.name AS m_company_operation_name',
            'm_company.id AS company_id',
            'm_company.name_jp AS company_name_jp'
        ])
            ->join('m_company_operation', 'm_company_operation.id', '=', 't_user_login.ope_company_id')
            ->leftJoin('m_company', 'm_company.ope_company_id', '=', 'm_company_operation.id')
            ->where('t_user_login.id', $userId)
            ->get()->toArray();
    }
}
