<?php
/**
* File Spot controller
*
* @package App\Http\Controllers
* @author tri_hnm
* @date 2018/06/27
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpotController extends Controller
{
    /**
     * Show page create spot
     * @param Type var Description
     * @return view
     */
    public function create()
    {
        return view('spot.create');
    }

    /**
     * Show page edit spot
     * @param Type number id
     * @return view
     */
    public function edit($id)
    {
        return view('spot.edit');
    }
}
