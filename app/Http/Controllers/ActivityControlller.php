<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityControlller extends Controller
{
    public function index()
    {

        $activity = Activity::with('users')
            ->latest()->get();

        return view('activityLogs.index');

    }
    public function getData()
    {
        $activity = Activity::with('users')
            ->latest()->get();

        return datatables()->of($activity)
            ->addColumn('causer', function ($activity) {
                return $activity->causer->name ?? '-';
            })
            ->addColumn('description', function ($activity) {
                return $activity->description ?? '-';
            })
            ->addColumn('created_at', function ($activity) {
                return $activity->created_at->diffForHumans() ?? '-';
            })
            ->rawColumns(['causer','description', 'created_at'])
            ->make(true);

    }
}
