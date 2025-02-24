<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcurementController extends Controller
{
    public function index()
    {
        return view('receipt.list');
    }
    public function create()
    {
        return view('receipt.create');
    }
    public function purchase_index()
    {
        return view('purchase.list');
    }
    public function purchase_create()
    {
        return view('purchase.create');
    }
}
