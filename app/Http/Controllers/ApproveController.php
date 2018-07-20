<?php

/**
 * Redirect request user to approve
 *
 * @package    Approve
 * @author     Rikkei.DungLV
 * @date       2018/07/03
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\ApproveBusiness;
use Exception;
use App\Common\Constant;
use Illuminate\Support\Facades\Log;

class ApproveController extends Controller
{
    // Declare business contain handle business
    private $_approveBusiness;
    
    /**
     * Initial business approve
     * 
     * @access public
     * @param App\Business\ApproveBusiness $approveBusiness
     * @return void
     */
    public function __construct(ApproveBusiness $approveBusiness)
    {
        $this->_approveBusiness = $approveBusiness;
    }
    
    /**
     * Display home page approve
     * 
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function showHomeApprove(Request $request)
    {
        try {
            $query = $request->query();
            
            if (!empty($query) && count($query) > 0) {
                $data = $this->_approveBusiness->getDataForSearchAprrove($request);
            } else {
                $data = $this->_approveBusiness->getDataForHomeApprove();
            }
            
            return view('approve.list')->with('datas', $data);
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, $exc->getMessage());
        }
    }
    
    /**
     * Display HTML show content modal
     * 
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return String [HTML string after render from view]
     */
    public function showDetailApprove(Request $request)
    {
        try {
            $data = $this->_approveBusiness->getDataForDetailAprrove($request);
            $type = $request->get('type', null);
            switch ($type) {
                case $this->_approveBusiness::TYPE_APPROVE_SPOT:
                    $viewHtml = view('approve.detail-spot', compact('data'))->render();
                    break;
                
                case $this->_approveBusiness::TYPE_APPROVE_CONTRACT:
                    $viewHtml = view('approve.detail-contract', compact('data'))->render();
                    break;
                
                default:
                    $viewHtml = '';
                    break;
            }
            
            return $viewHtml;
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, $exc->getMessage());
        }
    }
    
    /**
     * Accept request approve
     * 
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return String [HTML string after render from view]
     */
    public function acceptApprove(Request $request)
    {
        try {
            return response()
                ->json($this->_approveBusiness->handleAcceptApprove($request));
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, $exc->getMessage());
        }
    }
    
    /**
     * Reject request approve
     * 
     * @access public
     * @param Illuminate\Support\Facades\Request $request
     * @return String [HTML string after render from view]
     */
    public function rejectApprove(Request $request)
    {
        try {
            return response()
                ->json($this->_approveBusiness->handleRejectApprove($request));
        } catch (Exception $exc) {
            Log::error($exc->getFile() .' on '. $exc->getLine());
            abort(Constant::HTTP_CODE_ERROR_500, $exc->getMessage());
        }
    }
}
