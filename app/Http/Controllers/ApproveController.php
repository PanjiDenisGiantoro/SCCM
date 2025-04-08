<?php

namespace App\Http\Controllers;

use App\Models\Approval_layers;
use App\Models\Approval_process;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ApproveController extends Controller
{
    public function index()
    {
        $approve = Approval_process::latest()->get();
        return view('approve.index',compact('approve'));
    }
    public function store(Request $request)
    {
        try {
            Approval_process::create([
                'process_name' => $request->name,
                'required_approvals' => $request->total,
                'budget' => str_replace('.', '', $request->budget),
                'max_budget' => str_replace('.', '', $request->max_budget)
            ]);

            Alert::success('Success', 'Process added successfully');
        }catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
        }

        return redirect()->back();
    }
    public function destroy($id)
    {
        try {
            Approval_process::find($id)->delete();
            Alert::success('Success', 'Process deleted successfully');
        }catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
        }
        return redirect()->back();

    }
    public function edit($id)
    {
        $client = Client::with('users')->where('id_user', Auth::user()->id)->first();

        if(!empty($client) || !empty($client->users)){
            $users = User::with('roles.permissions', 'userOrganitations', 'divisions')
                ->where('created_user', $client->id)
                ->latest()->get();
        }else{
            $users = User::with('roles.permissions', 'userOrganitations', 'divisions')->latest()->get();
        }

        $approve = Approval_process::find($id);
        $layers = Approval_layers::where('process_id', $id)->get();

        if (count($layers) > 0) {
            $approve->layers = $layers;
        }else{
            $approve->layers = [];
        }
        return view('approve.edit',compact('approve','users'));

    }
    public function store_sequence(Request $request)
    {

        try {

            foreach ($request->approvers as $key => $value) {
                Approval_layers::create([
                    'process_id' => $request->id,
                    'role_id' => $value,
                    'sequence_order' => $key,
                    'approval_required' => false
                ]);
            }
            Alert::success('Success', 'Process updated successfully');
        }catch (\Exception $e){
            Alert::error('Error', $e->getMessage());

        }
        return redirect()->back();

    }
    public function destroy_sequence($id)
    {
        try {
            $approve = Approval_layers::where('process_id', $id)->get();
            foreach ($approve as $key => $value) {
                $value->delete();
            }
            Alert::success('Success', 'Process deleted successfully');
        }catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
        }
        return redirect()->back();
    }

}
