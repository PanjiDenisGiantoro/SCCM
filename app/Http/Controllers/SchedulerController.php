<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchedulerController extends Controller
{
    public function index()
    {
        return view('scheduler.index');

    }
    public function create()
    {
        return view('scheduler.create');

    }
}
