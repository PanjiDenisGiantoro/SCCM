<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipmentController extends Controller
{

    public function index()
    {
        return view('equipment.index');

    }
    public function create()
    {
        return view('equipment.create');

    }
}
