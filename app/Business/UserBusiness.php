<?php

/**
 * User Business
 *
 * @package App\Business
 * @author Rikkei.QuyenL
 * @date 2018/07/19
 */

namespace App\Business;

use App\Common\Constant;
use App\Repositories\User\UserRepositoryInterface;

/**
* Handle user business
*/
class UserBusiness
{
    /**
     * User repository
     *
     * @var $_userRepository
     */
    protected $_userRepository;

    /**
     * UserBusiness constructor.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_userRepository = app(UserRepositoryInterface::class);
    }

    /**
     * Get user logged data and permission value
     *
     * @param int $userId
     * @return array
     */
	public function getUserData($userId)
    {
        return $this->_userRepository->getUserData($userId);
    }

    /**
     * Get role screens
     *
     * @param bool $authCreate
     * @param bool $authApprove
     * @param bool $authReference
     * @param bool $authOperation
     * @return array
     */
    public function getRoleScreens($authCreate, $authApprove, $authReference, $authOperation)
    {
        // Init empty role array
        $rolesScreen  = [];

        // User have create or operation role
        if ($authCreate == true || $authOperation == true) {
            $rolesScreen = array_merge(Constant::ROLE_CREATE_OPERATION_SCREEN, $rolesScreen);
        }
        // User have approve role
        if ($authApprove == true) {
            $mergeApprove = array_merge(Constant::ROLE_APPROVE_SCREEN, $rolesScreen);
            $rolesScreen = array_unique($mergeApprove);
        }
        // User have reference role
        if ($authReference == true) {
            $mergeReference = array_merge(Constant::ROLE_REFERENCE_SCREEN, $rolesScreen);
            $rolesScreen = array_unique($mergeReference);
        }

        return $rolesScreen;
    }

    /**
     * Get current logged user list operation company
     *
     * @param array $userData current logged user data
     * @return array
     */
    public function getUserCompany($userData)
    {
        return array_column($userData, 'company_id');
    }

    /**
     * Check if ALL needles exist
     *
     * @param array $needles
     * @param array $haystack
     * @return bool
     */
    public function inArrayAll($needles, $haystack) {
        return !array_diff($needles, $haystack);
    }
}
