<?php

/**
 * Intermediate role file
 *
 * @package App\Http\Controllers
 * @author Rikkei.QuyenL
 * @date 2018/07/19
 */

namespace App\Http\Controllers;

use App\Business\UserBusiness;

/**
 * Class Role
 * Intermediate of controller and business
 */
class Role
{
    /**
     * Handle user business
     *
     * @var UserBusiness
     */
    private $_userBusiness = false;

    /**
     * Object of handle user business. Create new if have no init object
     *
     * @return UserBusiness|bool
     */
    protected function userBusiness()
    {
        if ($this->_userBusiness === false) {
            $this->_userBusiness = new UserBusiness();
        }

        return $this->_userBusiness;
    }

    /**
     * Get current user logged data
     *
     * @param int $userId
     * @return array
     */
    public function getUserData($userId)
    {
        return $this->userBusiness()->getUserData($userId);
    }

    /**
     * Get role screen
     *
     * @param bool $authCreate
     * @param bool $authApprove
     * @param bool $authReference
     * @param bool $authOperation
     * @return array
     */
    public function getRoleScreens($authCreate, $authApprove, $authReference, $authOperation)
    {
        return $this->userBusiness()->getRoleScreens($authCreate, $authApprove, $authReference, $authOperation);
    }

    /**
     * Get list current user logged company
     *
     * @param array $userData
     * @return array
     */
    public function getUserCompany($userData)
    {
        return $this->userBusiness()->getUserCompany($userData);
    }

    /**
     * Check if ALL needles exist
     *
     * @param array $needles
     * @param array $haystack
     * @return bool
     */
    public function inArrayAll($needles, $haystack) {
        return $this->userBusiness()->inArrayAll($needles, $haystack);
    }
}
