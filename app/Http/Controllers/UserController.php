<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Division;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles.permissions', 'userOrganitations')->latest()->get();
        return view('user.index');
    }

    public function create()
    {

        $departments = Organization::all();
        $divisions = Division::all();
        $roles = DB::table('roles')
            ->where('name', '!=', 'super_admin')
            ->get();
        return view('user.create', compact('departments', 'roles', 'divisions'));
    }

    public function getData()
    {
        $users = User::with('roles.permissions', 'userOrganitations', 'divisions')->latest()->get();

        return datatables()->of($users)
            ->addColumn('name', function ($users) {
                return $users->name ?? '-';
            })
            ->addColumn('email', function ($users) {
                return $users->email ?? '-';
            })
            ->addColumn('userOrganitations', function ($users) {
                return $users->userOrganitations->name ?? '-';
            })
            ->addColumn('role', function ($users) {
                return $users->roles[0]->name ?? '-';
            })
            ->addColumn('division', function ($users) {
                return $users->divisions->name ?? '-';
            })
            ->addColumn('created_at', function ($users) {
                return $users->created_at->diffForHumans() ?? '-';
            })
            ->addColumn('status', function ($users) {
                return $users->status == 1 ? '<span class="badge bg-success">' . 'Active' . '</span>' : '<span class="badge bg-danger">' . 'Inactive' . '</span>';
            })
            ->addColumn('action', function ($users) {
                $print = route('user.edit', $users->id);
                $show = route('user.show', $users->id);
                return '
                <a href="' . $show . '" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                </a>';

            })
            ->rawColumns(['name', 'email', 'userOrganitations', 'created_at', 'status', 'role', 'action', 'division'])
            ->make(true);
    }

    public function store(Request $request)
    {
//        cek dd file
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'profile_photo_path' => 'nullable|file|image|max:2048',
            'status' => 'required|in:0,1',
            'role' => 'required|exists:roles,id',
            'organization_id' => 'required',
            'division_id' => 'nullable',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Handle file upload for profile photo if provided
            $photoPath = null;
            if ($request->hasFile('profile_photo_path')) {
                $photoPath = $request->file('profile_photo_path')->store('user', 'public');
            }

            $userCompany = Client::where('id_user', Auth::user()->id)->first();
            if (!empty($userCompany)) {
                $idCompany = $userCompany->id;
            } else {
                $userexist = User::where('created_user', Auth::user()->id)->first();
                $idCompany = $userexist->created_user;
            }
            // If there's an existing user, update them. Otherwise, create a new user.
            if ($request->has('id')) {
                $user = User::findOrFail($request->id);
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password ? Hash::make($request->password) : $user->password,
                    'profile_photo_path' => $photoPath ?: $user->profile_photo_path,
                    'status' => $request->status,
                    'organization_id' => $request->organization_id,
                    'division_id' => $request->division_id,
                    'created_user' => $idCompany

                ]);
                $roleId = DB::table('roles')->where('id', $request->role)->first();
                $user->assignRole($roleId->name);
//                $user->userOrganitations()->sync($request->organization_id);
                Alert::success('Success', 'User updated successfully');
                return redirect()->route('user.list');
            } else {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'profile_photo_path' => $photoPath,
                    'status' => $request->status,
                    'organization_id' => $request->organization_id,
                    'division_id' => $request->division_id,
                    'created_user' => $idCompany


                ]);
//                $user->userOrganitations()->sync($request->organization_id);  // Sync departments for the user
                $roleId = DB::table('roles')->where('id', $request->role)->first();
                $user->assignRole($roleId->name);

                Alert::success('Success', 'User created successfully');
                return redirect()->route('user.list');
            }
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back()->withInput();

        }

    }

    public function show($id)
    {
        $organizations = Organization::with('divisions.users')->get();
        $users = User::with('userOrganitations', 'divisions', 'roles', 'companies', 'company_child')->where('id', $id)->first();


        $departments = Organization::all();
        $divisions = Division::all();
        $roles = DB::table('roles')->get();

        return view('user.view', compact('users', 'organizations', 'departments', 'divisions', 'roles'));

    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);
        if ($request->password != $request->confirm) {
            Alert::error('Error', 'Password not match');
            return redirect()->back();
        }
        $user->password = Hash::make($request->password);
        $user->save();
        Alert::success('Success', 'Password updated successfully');
        return redirect()->route('user.show', $id);

    }

    public function update_profile(Request $request, $id)
    {


        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'organization_id' => $request->organization_id,
            'division_id' => $request->division_id,
        );
        $user = User::find($id);
        $photoPath = null;
        if ($request->hasFile('profile_photo_path')) {
            $photoPath = $request->file('profile_photo_path')->store('user', 'public');
            $oldPhotoPath = public_path('storage/user/' . $user->profile_photo_path);
            if (!empty($user->profile_photo_path) && file_exists($oldPhotoPath) && is_file($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }

        $user->profile_photo_path = $photoPath;
        $roleId = DB::table('roles')->where('id', $request->role)->first();
        $user->assignRole($roleId->name);

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }


        $user->update($data);

        Alert::success('Success', 'Profile updated successfully');
        return redirect()->route('user.show', $id);
    }


}
