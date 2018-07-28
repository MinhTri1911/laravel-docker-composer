<?php

/**
 * NationController.php
 *
 * @package    App\Http\Controllers
 * @author     Rikkei.Trihnm
 * @date       2018/07/23
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\NationBusiness;
use App\Common\Constant;

class NationController extends Controller
{
    private $_nationBusiness;

    public function __construct(NationBusiness $nation)
    {
        $this->_nationBusiness = $nation;
    }

    /**
     * Function search nation by ajax
     * @param Illuminate\Http\Request request
     * @return Response
     */
    public function searchAjax(Request $request)
    {
        if (!$request->ajax()) {
            return $this->returnJson(Constant::HTTP_CODE_ERROR_500);
        }

        $dataSearch = $this->_nationBusiness->searchNationByIdOrName(
            $request->get('search-nation-id'),
            $request->get('search-nation-name')
        );

        $response = view('common.table-nation-search', ['nations' => $dataSearch, 'type' => $request->get('search-type')])->render();

        return $this->returnJson(Constant::HTTP_CODE_SUCCESS, '', [
            'dataTable' => $response,
        ]);
    }
}
