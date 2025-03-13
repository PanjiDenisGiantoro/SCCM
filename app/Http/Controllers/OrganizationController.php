<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Organization;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('groups.list');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:organizations',
            'description' => 'nullable',
        ]);

        $organization = Organization::create($data);
        activity()
            ->causedBy(auth()->user())
            ->log('Organization created');
        Alert::success('Success', 'Organization created successfully');

        return redirect()->route('groups.list');
    }

    public function show(Organization $organization)
    {
        return response()->json($organization);
    }
    public function edit(Request $request, $id)
    {
        $data = Organization::findOrFail($id);
        return view('groups.index', compact('data'));

    }

    public function update(Request $request, Organization $organization,$id)
    {
        $data = $request->validate([
            'name' => 'required|unique:organizations,name,' . $id,
            'description' => 'nullable',
        ]);
        $organization = Organization::findOrFail($id);

        $organization->update($data);
        activity()
            ->causedBy(auth()->user())
            ->log('Organization updated');
        Alert::success('Success', 'Organization updated successfully');
        return redirect()->route('groups.list');
    }

    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();
        activity()
            ->causedBy(auth()->user())
            ->log('Organization deleted');
        Alert::success('Success', 'Organization deleted successfully');
        return redirect()->route('groups.list');
    }
    public function getData()
    {
        $organizations = Organization::latest()->get();
        return datatables()->of($organizations)
            ->addColumn('name', function ($organizations) {
                return $organizations->name ?? '-';
            })
            ->addColumn('description', function ($organizations) {
                return $organizations->description ?? '-';
            })
            ->addColumn('action', function ($organizations) {
                $editUrl = route('groups.edit', $organizations->id);
                $destroy = route('groups.destroy', $organizations->id);
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
        return view('groups.index');

    }
    public function getDivision($id)
    {

        $division = Division::where('organization_id', $id)->get();
        return response()->json($division);

    }

    public function structure()
    {

        return view('groups.structure');

    }


    public function getDivisionsUsers(Request $request)
    {
        $orgId = $request->org_id;
        $divisions = Division::with('users')
            ->where('organization_id', $orgId)
            ->get();

        $result = [];
        foreach ($divisions as $division) {
            $users = $division->users->map(function ($user) {
                $role = $user->roles->first();
                return [
                    'name' => $user->name,
                    'email' => $user->email ?? '-',
                    'role' => $role->name ?? '-',
                ];
            });

            $result[] = [
                'id' => $division->id,
                'name' => $division->name,
                'description' => $division->description ?? '-',
                'users' => $users,
            ];
        }

        return response()->json($result);
    }
    public function getDetails(Request $request)
    {
        $divisionId = $request->id;
        $data = Division::where('id', $divisionId)->with('managers')->get();

        return response()->json($data);
    }
    public function dataStructure(Request $request){



    }


}
