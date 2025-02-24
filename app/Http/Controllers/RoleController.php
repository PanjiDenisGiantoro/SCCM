<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function index()
    {
        return view('role.list');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles',
            'guard_name' => 'nullable',
        ]);
        $data['guard_name'] = 'web';


        $organization = RoleUser::create($data);
        activity()
            ->causedBy(auth()->user())
            ->log('Role created');
        Alert::success('Success', 'Role created successfully');

        return redirect()->route('role.list');
    }

    public function show(RoleUser $organization)
    {
        return response()->json($organization);
    }
    public function edit(Request $request, $id)
    {
        $data = RoleUser::findOrFail($id);
        return view('role.index', compact('data'));

    }

    public function update(Request $request, RoleUser $organization,$id)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'guard_name' => 'nullable',
        ]);
        $organization = RoleUser::findOrFail($id);

        $data['guard_name'] = 'web';

        $organization->update($data);
        activity()
            ->causedBy(auth()->user())
            ->log('role updated');
        Alert::success('Success', 'role updated successfully');
        return redirect()->route('role.list');
    }

    public function destroy($id)
    {
        $organization = RoleUser::findOrFail($id);
        $organization->delete();
        activity()
            ->causedBy(auth()->user())
            ->log('role deleted');
        Alert::success('Success', 'role deleted successfully');
        return redirect()->route('role.list');
    }
    public function getData()
    {
        $organizations = RoleUser::latest()->get();
        return datatables()->of($organizations)
            ->addColumn('name', function ($organizations) {
                return $organizations->name ?? '-';
            })

            ->addColumn('action', function ($organizations) {
                $editUrl = route('role.edit', $organizations->id);
                $destroy = route('role.destroy', $organizations->id);
                return '
                <a href="' . $destroy . '" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                    <iconify-icon icon="lucide:trash-2"></iconify-icon>
                </a>
               <a href="' . $editUrl . '" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                   <iconify-icon icon="lucide:edit"></iconify-icon>
                  </a>';
            })
            ->rawColumns(['action'])
            ->make(true);

    }
    public function create()
    {
        return view('role.index');

    }
}
