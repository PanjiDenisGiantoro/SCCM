<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaceController extends Controller
{
    public function index()
    {
        return view('space.index');
    }
    public function create()
    {
        return view('space.create');

    }
    public function analytics(){
        return view('space.analytic');
    }
}
