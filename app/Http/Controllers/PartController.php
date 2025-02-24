<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index()
    {
        return view('part.index');
    }
    public function create()
    {
        return view('part.create');

    }
}
