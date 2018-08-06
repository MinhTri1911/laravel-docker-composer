<?php

/**
 * User Repository Interface
 *
 * @package App\Repositories\User
 * @author Rikkei.QuyenL
 * @date 2018/07/19
 */

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    /**
     * Get user logged data
     *
     * @param int $userId
     * @return mixed
     */
    public function getUserData($userId);

    /**
     * Get list user data
     *
     * @return mixed Laravel collection
     */
    public function getListUser();

    /**
     * Get list company operation
     *
     * @return mixed Laravel collection
     */
    public function getListCompanyOperation();

    /**
     * Search list auth with condition
     *
     * @param array $searchData
     * @return mixed Laravel collection
     */
    public function searchListUser($searchData);

    /**
     * Update auth with data
     *
     * @param int $userId
     * @param array $data
     * @return bool
     */
    public function updateAuth($userId, $data);

    /**
     * Get user role by id
     *
     * @param int $userId
     * @return mixed Laravel collection
     */
    public function getUserRoleById($userId);

    /**
     * Check exist user by id
     *
     * @param int $userId
     * @return bool
     */
    public function checkExistUser($userId);
}
