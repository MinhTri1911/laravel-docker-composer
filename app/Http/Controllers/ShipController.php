<?php
/**
* File Ship controller
*
* @package App\Http\Controllers
* @author tri_hnm
* @date 2018/06/19
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShipController extends Controller
{
    /**
     * Show list ship
     * @return view
     */
    public function index()
    {
        return view('ship.list');
    }

    /**
     * Show page create ship
     * @return view
     */
    public function create()
    {
        return view('ship.create');
    }

    /**
     * Show page create ship contract
     * @return view
     */
    public function createShipContract()
    {
        return view('ship.create-ship-contract');
    }

    /**
     * Show form edit Ship
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id = '')
    {
        return view('ship.edit');
    }
}
