<?php

/**
 * Roles controller
 *
 * @package App\Http\Controllers
 * @author Rikkei.QuyenL
 * @date 2018/07/19
 */

namespace App\Http\Controllers;

use App\Common\Constant;
use Illuminate\Support\Facades\Auth;

/**
 * Trait RolesController
 * Handle check user permission
 */
trait RolesController
{
    /**
     * Check user logged permission
     *
     * @access public
     * @param int $allowConstant
     * @param int $checkType
     * @param null|int $companyOperationId default null
     * @return mixed
     */
    public static function checkPermission($allowConstant, $checkType, $companyOperationId = null)
    {
        // Get screen by user role
        $user = auth()->user();
        $rolesScreen = Base::role()->getRoleScreens(
            $user->auth_create,
            $user->auth_approve,
            $user->auth_reference,
            $user->auth_operation
        );

        // Call get permission function
        $allowAccess = self::getPermission($allowConstant, $companyOperationId);

        /**
         * Check allow access and redirect to 403 Forbidden page
         * Redirect error page if allow constant not in roles screen || $allowAccess == false
         */
        if (! in_array($allowConstant, $rolesScreen) || $allowAccess == false) {
            if ($checkType === Constant::IS_CHECK_BUTTON) {
                return false;
            }
            return abort(Constant::HTTP_CODE_ERROR_403, trans('common-message.error.E018'));
        }

        return true;
    }

    /**
     * Get permission for current user logged
     *
     * @access public
     * @param int|array $allowConstant
     * @param null|int $idCompany default null
     * @return bool user can or cannot access screen
     */
    public static function getPermission($allowConstant, $idCompany = null)
    {
        // Initial allow access variable
        $allowAccess = false;

        // Get logged user role
        $user = auth()->user();
        $authCreate = $user->auth_create;
        $authApprove = $user->auth_approve;
        $authReference = $user->auth_reference;
        $authOperation = $user->auth_operation;

        // Default statusDependCompany = IN
        $statusDependCompany = Constant::STATUS_DEPEND_COMPANY_IN;

        // Check the status of the company
        if ($idCompany !== null) {
            $statusDependCompany = self::checkOperationCompany($idCompany);
        }

        // User have Create role
        if ($authCreate == true)
        {
            if ($authOperation == true) {
                if ($authApprove == true) {
                    $allowAccess = true;
                } elseif ($authApprove == false) {
                    // If screen is delete company or delete ship
                    $allowAccess = in_array($allowConstant, [Constant::ALLOW_COMPANY_DELETE, Constant::ALLOW_SHIP_DELETE])
                        ? false
                        : true;
                } else {
                    $allowAccess = in_array($allowConstant, Constant::ROLE_CREATE_OPERATION_SCREEN)
                        ? true
                        : false;
                }
            } elseif ($authApprove == true) {
                if ($authReference == true) { // If user have create, approve and reference role
                    if ($statusDependCompany == Constant::STATUS_DEPEND_COMPANY_IN) {
                        // TODO
                        // Làm sao để cho xem ngoài công ty???
                        $allowAccess = in_array($allowConstant, Constant::ROLE_CREATE_OPERATION_SCREEN + Constant::ROLE_APPROVE_SCREEN)
                            ? true
                            : false;
                    } else {
                        $allowAccess = in_array($allowConstant, Constant::ROLE_CREATE_OPERATION_SCREEN + Constant::ROLE_APPROVE_SCREEN)
                            ? true
                            : false;
                    }

                } else { // If user have create and approve role
                    if ($statusDependCompany == Constant::STATUS_DEPEND_COMPANY_IN) {
                        $allowAccess = in_array($allowConstant, Constant::ROLE_CREATE_OPERATION_SCREEN + Constant::ROLE_APPROVE_SCREEN)
                            ? true
                            : false;
                    } else {
                        $allowAccess = false;
                    }
                }
            } elseif ($authReference == true) { // User have create and reference role
                // Reference and create
                if ($statusDependCompany == Constant::STATUS_DEPEND_COMPANY_IN) {
                    $allowAccess = in_array($allowConstant, Constant::ROLE_CREATE_OPERATION_SCREEN) ? true : false;
                } else {
                    // TODO
                    // Làm sao để cho xem ngoài công ty???
                    $allowAccess = in_array($allowConstant, Constant::ROLE_CREATE_OPERATION_SCREEN) ? true : false;
                }
            } else { // If user have only create role
                if ($statusDependCompany == Constant::STATUS_DEPEND_COMPANY_IN) {
                    $allowAccess = in_array($allowConstant, Constant::ROLE_CREATE_OPERATION_SCREEN)
                        ? true
                        : false;
                } else {
                    $allowAccess = false;
                }
            }
        }
        // User have Approve role
        elseif ($authApprove == true)
        {
            // User have approve, operation role
            if ($authOperation == true) {
                $allowAccess = true;
            } elseif ($authReference == true) {
                $allowAccess = in_array($allowConstant,Constant::ROLE_REFERENCE_SCREEN + Constant::ROLE_APPROVE_SCREEN)
                    ? true
                    : false;
            } else { // If have only approve role
                if ($statusDependCompany == Constant::STATUS_DEPEND_COMPANY_IN) {
                    $allowAccess = in_array($allowConstant, Constant::ROLE_APPROVE_SCREEN) ? true : false;
                } else {
                    $allowAccess = false;
                }
            }
        }
        // User have Reference role
        elseif ($authReference == true)
        {
            // Only reference role
            if ($authOperation == false) {
                // Access false if is not view screen
                $allowAccess = in_array($allowConstant,Constant::ROLE_REFERENCE_SCREEN) ? true : false;
            } else {
                $allowAccess = true;
            }
        }
        // User have operation role
        elseif ($authOperation == true)
        {
            // If screen is delete company or delete ship, need more approve role
            $allowAccess = in_array($allowConstant, [Constant::ALLOW_COMPANY_DELETE, Constant::ALLOW_SHIP_DELETE])
                ? false
                : true;
        }

        return $allowAccess;
    }

    /**
     * Get user login data
     *
     * @access public
     * @return array
     */
    public static function getUserData()
    {
        $userLoginData = Base::role()->getUserData(Auth::id());
        if (!empty($userLoginData)) {
            return $userLoginData;
        }

        // Auth data with company id not found
        return abort(Constant::HTTP_CODE_ERROR_404, trans('common-message.error.E001'));
    }

    /**
     * Check operation own company
     *
     * @access public
     * @param int $companyOperationId
     * @return int status depend company IN or OUT
     */
    public static function checkOperationCompany($companyOperationId)
    {
        // Get array list company of user logged
        $loggedOperationCompany = auth()->user()->ope_company_id;

        if ($loggedOperationCompany == $companyOperationId) {
            return Constant::STATUS_DEPEND_COMPANY_IN;
        }

        return Constant::STATUS_DEPEND_COMPANY_OUT;
    }
}
