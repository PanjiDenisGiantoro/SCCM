<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function index()
    {
        return view('wo.index');

    }
    public function create()
    {
        return view('wo.create');

    }
}
