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
}
