<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContractorController extends Controller
{
    public function index()
    {
        return view('contractor.index');
    }
    public function create()
    {
        return view('contractor.create');
    }
}
