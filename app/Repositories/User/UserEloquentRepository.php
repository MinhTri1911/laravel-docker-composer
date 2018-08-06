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
use Illuminate\Support\Facades\DB;
use App\Common\Constant;
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

    /**
     * Get list auth user
     *
     * @access public
     * @return mixed Laravel collection
     */
    public function getListUser()
    {
        return $this->select([
            't_user_login.id',
            't_user_login.name',
            't_user_login.auth_create',
            't_user_login.auth_approve',
            't_user_login.auth_reference',
            't_user_login.auth_operation',
            't_user_login.auth_admin',
            't_user_login.login_id',
        ])
            ->where('t_user_login.id', '!=', auth()->id())
            ->paginate(Constant::PAGINATION_PER_PAGE);
    }

    /**
     * Get list company operation
     *
     * @return mixed Laravel collection
     */
    public function getListCompanyOperation()
    {
        return DB::table('m_company_operation')->select([
            'm_company_operation.id',
            'm_company_operation.name'
        ])
            ->where('m_company_operation.del_flag', Constant::DELETE_FLAG_FALSE)
            ->get()
            ->toArray();
    }

    /**
     * Search list auth with condition
     *
     * @param array $searchData
     * @return mixed Laravel collection
     */
    public function searchListUser($searchData)
    {
        $query = $this->select([
            't_user_login.id',
            't_user_login.name',
            't_user_login.auth_create',
            't_user_login.auth_approve',
            't_user_login.auth_reference',
            't_user_login.auth_operation',
            't_user_login.auth_admin',
            't_user_login.login_id',
        ]);
        $query->where('t_user_login.id', '!=', auth()->id());

        // Search with with user id
        if (!empty($searchData['id'])) {
            $query->where('t_user_login.id', $searchData['id']);
        }
        // Search with login id
        if (!empty($searchData['login_id'])) {
            $query->where('t_user_login.login_id', 'LIKE', '%' . $searchData['login_id'] . '%');
        }
        // Search with company operation id
        if (!empty($searchData['company_operation'])) {
            if ($searchData['company_operation'] != Constant::SHOW_ALL_FLG) {
                $query->where('t_user_login.ope_company_id', $searchData['company_operation']);
            }
        }

        return $query->paginate(Constant::PAGINATION_PER_PAGE);
    }

    /**
     * Update auth with data
     *
     * @param int $userId
     * @param array $data
     * @return bool
     */
    public function updateAuth($userId, $data)
    {
        return DB::table('t_user_login')
            ->where('del_flag', Constant::DELETE_FLAG_FALSE)
            ->where('id', $userId)
            ->where('id', '!=', auth()->id())
            ->update($data);
    }

    /**
     * Get user role by id
     *
     * @param int $userId
     * @return mixed Laravel collection
     */
    public function getUserRoleById($userId)
    {
        return $this->select([
            'auth_create',
            'auth_approve',
            'auth_reference',
            'auth_operation',
        ])
            ->where('id', $userId)
            ->first()
            ->toArray();
    }

    /**
     * Check exist user by id
     *
     * @param int $userId
     * @return bool
     */
    public function checkExistUser($userId)
    {
        return $this->where('id', $userId)
            ->exists();
    }
}
