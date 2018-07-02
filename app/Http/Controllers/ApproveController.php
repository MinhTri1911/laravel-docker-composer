<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApproveController extends Controller
{
    public function list()
    {
    	return view('approve.list');
    }
}
