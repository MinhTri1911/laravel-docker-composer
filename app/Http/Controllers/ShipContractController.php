<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShipContractController extends Controller
{
    public function detail($id = '') {
        return view('ship.contract.detail');
    }
}
