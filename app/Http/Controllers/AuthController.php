<?php

/**
 * Authentication management Controller
 *
 * @package App\Http\Controllers
 * @author Rikkei.QuyenL
 * @date 2018/08/03
 */

namespace App\Http\Controllers;

use App\Common\Constant;
use App\Business\UserBusiness;
use Illuminate\Http\Request;

/**
 * Class AuthController
 */
class AuthController extends Controller
{
    /**
     * UserBusiness
     *
     * @var $_userBusiness
     */
    private $_userBusiness;

    /**
     * AuthController constructor
     *
     * @param UserBusiness $userBusiness
     * @access public
     * @return void
     */
    public function __construct(UserBusiness $userBusiness)
    {
        $this->_userBusiness = $userBusiness;
    }

    /**
     * Show list user and authorization
     *
     * @param Request $request
     * @return mixed \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function index(Request $request)
    {
        // User have admin role can access this screen
        if (auth()->user()->auth_admin == true) {
            // Get list view data
            $users = !empty($request->query())
                ? $this->_userBusiness->searchListUser($request->query())
                : $this->_userBusiness->getListUser();

            // Get list company operation
            $companyOperation = $this->_userBusiness->getListCompanyOperation();

            return view('auth.list', compact('users', 'companyOperation'));
        }

        return abort(Constant::HTTP_CODE_ERROR_403, trans('common-message.error.E018'));
    }

    /**
     * Call user business and update auth with data
     *
     * @param Request $request
     * @return mixed \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $updateData = $request->get('updateData');

            // Check if empty request data
            if (!empty($updateData)) {
                $resultUpdate = $this->_userBusiness->updateAuth($updateData);

                return $this->returnJson(Constant::HTTP_CODE_SUCCESS,
                    $this->_userBusiness->getResponseMessages($resultUpdate),
                    $resultUpdate
                );
            }

            // Not found update data
            return $this->returnJson(Constant::HTTP_CODE_ERROR_500, __('common-message.warning.W003'));
        }

        return $this->returnJson(Constant::HTTP_CODE_ERROR_500, __('common-message.error.E002'));
    }
}
