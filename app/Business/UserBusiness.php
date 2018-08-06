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
        $rolesScreen = [];

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
    public function inArrayAll($needles, $haystack)
    {
        return !array_diff($needles, $haystack);
    }

    /**
     * Get list user data
     *
     * @access public
     * @return mixed Laravel collection
     */
    public function getListUser()
    {
        return $this->_userRepository->getListUser();
    }

    /**
     * Get list company operation
     *
     * @access public
     * @return mixed Laravel collection
     */
    public function getListCompanyOperation()
    {
        $defaultOption = [trans('auth.all_company_operation')];
        $operationCompany = array_pluck($this->_userRepository->getListCompanyOperation(), 'name', 'id');

        return array_merge($defaultOption, $operationCompany);
    }

    /**
     * Search list auth with condition
     *
     * @param array $searchData
     * @return mixed Laravel collection
     */
    public function searchListUser($searchData)
    {
        return $this->_userRepository->searchListUser($searchData);
    }

    /**
     * Call user repository and update auth
     *
     * @param array $data
     * @return array
     */
    public function updateAuth($data)
    {
        $results = [];

        foreach ($data as $userId => $roles) {

            // Check exist user
            if ($this->_userRepository->checkExistUser($userId)) {

                // Convert request data and get user information
                $requestRole = $this->_convertStringToBool($roles);
                $userRole = $this->_userRepository->getUserRoleById($userId);

                // Compare server and user request data
                if ($requestRole != $userRole) {

                    \DB::beginTransaction();
                    try {
                        // Update with request data
                        $updateData = $this->_convertUpdateData($requestRole);
                        $this->_userRepository->updateAuth($userId, $updateData);
                        \DB::commit();

                        $results['success'][] = $userId;

                    } catch (\Exception $e) {
                        // Rollback the transaction
                        \DB::rollBack();

                        $results['error'][]['userId'] = $userId;
                        $results['error'][]['message'] = $e->getMessage();
                    }
                }
            } else {
                $results['notExist'][] = $userId;
            }
        }

        return $results;
    }

    /**
     * Convert string to bool
     *
     * @access private
     * @param array $roles
     * @return array
     */
    private function _convertStringToBool($roles)
    {
        $data = [];
        // TODO check param is not 0 || 1
        foreach ($roles as $value) {
            if (is_null($value) || $value == 0) {
                $data[] = false;
            }
            if ($value == 1) {
                $data[] = true;
            }
        }

        // TODO check case missing param
        return [
            'auth_create' => @$data[0],
            'auth_approve' => @$data[1],
            'auth_reference' => @$data[2],
            'auth_operation' => @$data[3]
        ];
    }

    /**
     * Convert data before update
     *
     * @access private
     * @param array $data
     * @return array
     */
    private function _convertUpdateData($data)
    {
        return [
            'auth_create' => $data['auth_create'],
            'auth_approve' => $data['auth_approve'],
            'auth_reference' => $data['auth_reference'],
            'auth_operation' => $data['auth_operation'],
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => auth()->id()
        ];
    }

    /**
     * Get response messages
     *
     * @param array $resultUpdate
     * @return array|null|string
     */
    public function getResponseMessages($resultUpdate)
    {
        if (!empty($resultUpdate)) {
            $messages = [];

            if (isset($resultUpdate['success'])) {
                $messages['success'] = __('auth.update_success', ['item' => count($resultUpdate['success'])]);
            }

            if (isset($resultUpdate['error'])) {
                foreach ($resultUpdate['error'] as $item) {
                    $messages['error'][] = __('auth.update_error', ['item' => $item]);
                }
            }

            if (isset($resultUpdate['notExist'])) {
                foreach ($resultUpdate['notExist'] as $item) {
                    $messages['notExist'][] = __('common-message.error.E009', ['value' => __('auth.id') . $item]);
                }
            }

            return $messages;
        }

        return __('common-message.warning.W003');
    }
}
