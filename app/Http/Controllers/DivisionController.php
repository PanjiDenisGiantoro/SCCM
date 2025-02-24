<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DivisionController extends Controller
{
    public function index()
    {
        $organizations = Division::with('organizations','managers')->latest()->get();
//        dd($organizations);
        return view('division.list');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:divisions',
            'organization_id' => 'required',
            'description' => 'nullable',
        ]);
        $organization = Division::create($data);
        activity()
            ->causedBy(auth()->user())
            ->log('Division created');
        Alert::success('Success', 'Division created successfully');

        return redirect()->route('division.list');
    }

    public function show(Division $organization)
    {
        return response()->json($organization);
    }
    public function edit(Request $request, $id)
    {
        $data = Division::findOrFail($id);
        $departments = Organization::latest()->get();
        return view('division.index', compact('data','departments'));

    }

    public function update(Request $request, Division $organization,$id)
    {
        $data = $request->validate([
            'name' => 'required|unique:divisions,name,' . $id,
            'organization_id' => 'required',
            'description' => 'nullable',
        ]);
        $organization = Division::findOrFail($id);

        $organization->update($data);
        activity()
            ->causedBy(auth()->user())
            ->log('division updated');
        Alert::success('Success', 'division updated successfully');
        return redirect()->route('division.list');
    }

    public function destroy($id)
    {
        $organization = Division::findOrFail($id);
        $organization->delete();
        activity()
            ->causedBy(auth()->user())
            ->log('division deleted');
        Alert::success('Success', 'division deleted successfully');
        return redirect()->route('division.list');
    }
    public function getData()
    {
        $organizations = Division::with('organizations','managers')->latest()->get();
        return datatables()->of($organizations)
            ->addColumn('name', function ($organizations) {
                return $organizations->name ?? '-';
            })
            ->addColumn('organization', function ($organizations) {
                return $organizations->organizations->name ?? '-';
            })
            ->addColumn('manager', function ($organizations) {
                return $organizations->managers->name ?? '-';
            })

            ->addColumn('action', function ($organizations) {
                $editUrl = route('division.edit', $organizations->id);
                $destroy = route('division.destroy', $organizations->id);
                return '
                <a href="' . $destroy . '" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                    <iconify-icon icon="lucide:trash-2"></iconify-icon>
                </a>
               <a href="' . $editUrl . '" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                   <iconify-icon icon="lucide:edit"></iconify-icon>
                  </a>';
            })
            ->rawColumns(['action','organization','name','managers'])
            ->make(true);

    }
    public function create()
    {
        $departments = Organization::latest()->get();
        return view('division.index',compact('departments'));


    }


    public function data_user($id)
    {
        $data = User::where('organization_id', $id)->get();
        return response()->json($data);


    }

}
