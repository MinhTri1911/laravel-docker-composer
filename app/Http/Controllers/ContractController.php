<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Show form create new contract
     * @return Illuminate\Support\Facades\View
     */
    public function create() {
        return view('contract.create');
    }
    
    /**
     * Show form edit contract
     *
     * @param  int $id [Id contract]
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id = '') {
        return view('contract.edit');
    }

    /**
     * Show form restore contract
     * 
     * @param  int $id [Id contract]
     * @return Illuminate\Support\Facades\View
     */
    public function restore($id = '') {
        return view('contract.restore');
    }
}
