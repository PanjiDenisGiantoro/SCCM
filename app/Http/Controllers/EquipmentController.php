<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{

    public function index()
    {
        return view('equipment.index');

    }
    public function create()
    {

        $personelUser = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'super_admin');
        })
            ->where('status', 1)
            ->get();

        $personelGroup = Organization::latest()->get();
        return view('equipment.create',compact('personelGroup', 'personelUser'));

    }
}
